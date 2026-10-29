<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class NovenaTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeders_create_the_demo_data(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(4, Category::count());
        $this->assertSame(2, Product::count());
        $this->post('/login', ['email' => 'admin@novena.com', 'password' => 'admin123']);
        $this->get('/admin')->assertOk();
    }

    public function test_store_lists_only_active_products_and_filters_by_category(): void
    {
        $tazas = Category::factory()->create();
        Product::factory()->for($tazas)->create(['name' => 'Taza roja']);
        Product::factory()->create(['name' => 'Vaso azul']);
        Product::factory()->create(['name' => 'Oculto', 'is_active' => false]);

        $this->get('/productos')->assertOk()->assertSee('Taza roja')->assertSee('Vaso azul')->assertDontSee('Oculto');
        $this->get('/productos?cat='.$tazas->id)->assertSee('Taza roja')->assertDontSee('Vaso azul');
    }

    public function test_only_admins_can_open_the_admin_panel(): void
    {
        $this->get('/admin')->assertForbidden();
        $this->actingAs(User::factory()->create())->get('/admin')->assertForbidden();
        $this->actingAs(User::factory()->admin()->create())->get('/admin')->assertOk();
    }

    public function test_login_register_and_logout(): void
    {
        $user = User::factory()->create(['password' => 'secreto']);

        $this->post('/login', ['email' => $user->email, 'password' => 'mal'])->assertSessionHasErrorsIn('login', 'email');
        $this->assertGuest();

        $this->post('/login', ['email' => $user->email, 'password' => 'secreto']);
        $this->assertAuthenticatedAs($user);

        $this->post('/logout');
        $this->assertGuest();

        $this->post('/register', ['name' => 'Nuevo', 'email' => 'nuevo@novena.com', 'password' => '1234', 'password_confirmation' => '4321'])
            ->assertSessionHasErrorsIn('register', 'password');

        $this->post('/register', [
            'name' => 'Nuevo', 'email' => 'nuevo@novena.com', 'password' => '1234', 'password_confirmation' => '1234',
        ]);
        $this->assertAuthenticated();
        $this->assertSame('user', User::firstWhere('email', 'nuevo@novena.com')->role);
    }

    public function test_admin_creates_category_with_generated_slug(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->post('/admin/categorias', ['name' => 'Regalos Bonitos', 'is_active' => 'on'])->assertSessionHasNoErrors();

        $category = Category::firstWhere('slug', 'regalos-bonitos');
        $this->assertTrue($category->is_active);
        $this->assertSame(0, $category->display_order);

        $this->post('/admin/categorias', ['name' => 'Regalos bonitos'])->assertSessionHasErrorsIn('category', 'slug');
    }

    public function test_admin_creates_product_with_image(): void
    {
        $this->actingAs(User::factory()->admin()->create());
        $category = Category::factory()->create();

        // PNG real de 1x1 para no depender de la extensión GD.
        $tmp = tempnam(sys_get_temp_dir(), 'img');
        file_put_contents($tmp, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='));

        $this->post('/admin/productos', [
            'name' => 'Termo', 'price' => 250, 'category_id' => $category->id, 'is_active' => 'on',
            'image' => new UploadedFile($tmp, 'termo.png', 'image/png', null, true),
        ])->assertSessionHasNoErrors();

        $product = Product::firstWhere('name', 'Termo');
        $this->assertTrue($product->is_active);
        $this->assertFalse($product->is_featured);
        $this->assertFileExists(public_path($product->image_path));
        unlink(public_path($product->image_path));

        $this->post('/admin/productos', ['name' => 'Sin imagen', 'price' => 10, 'category_id' => $category->id])
            ->assertSessionHasErrorsIn('product', 'image');
    }

    public function test_admin_edits_and_deletes_product(): void
    {
        $this->actingAs(User::factory()->admin()->create());
        $product = Product::factory()->create(['description' => 'Taza de cerámica']);

        $this->get("/admin?edit_id={$product->id}")->assertOk()
            ->assertSee('value="'.$product->name.'"', false)
            ->assertSee('>Taza de cerámica</textarea>', false);

        $this->put("/admin/productos/{$product->id}", [
            'name' => 'Taza grande', 'price' => 150, 'category_id' => $product->category_id,
        ])->assertSessionHasNoErrors();
        $this->assertSame('Taza grande', $product->fresh()->name);
        $this->assertFalse($product->fresh()->is_active);
        $this->assertSame('Recursos/producto1_1765211937.png', $product->fresh()->image_path);

        $this->put("/admin/productos/{$product->id}", ['name' => 'X', 'price' => 0, 'category_id' => $product->category_id])
            ->assertSessionHasErrorsIn('edit', 'price');

        $this->delete("/admin/productos/{$product->id}");
        $this->assertModelMissing($product);
    }
}
