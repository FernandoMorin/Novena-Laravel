<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NovenaTest extends TestCase
{
    use RefreshDatabase;

    private function product(array $attributes = []): Product
    {
        return Product::create([
            'name' => 'Taza',
            'price' => 100,
            'image_path' => 'Recursos/producto1_1765211937.png',
            ...$attributes,
        ]);
    }

    public function test_store_lists_only_active_products_and_filters_by_category(): void
    {
        $tazas = Category::create(['name' => 'Tazas', 'slug' => 'tazas']);
        $vasos = Category::create(['name' => 'Vasos', 'slug' => 'vasos']);
        $this->product(['name' => 'Taza roja', 'category_id' => $tazas->id]);
        $this->product(['name' => 'Vaso azul', 'category_id' => $vasos->id]);
        $this->product(['name' => 'Oculto', 'is_active' => false]);

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

        $this->post('/register', [
            'name' => 'Nuevo', 'email' => 'nuevo@novena.com', 'password' => '1234', 'password_confirmation' => '1234',
        ]);
        $this->assertAuthenticated();
        $this->assertSame('user', User::firstWhere('email', 'nuevo@novena.com')->role);
    }

    public function test_admin_creates_category_and_edits_and_deletes_product(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->post('/admin/categorias', ['name' => 'Regalos Bonitos', 'is_active' => 'on'])->assertSessionHasNoErrors();
        $category = Category::firstWhere('slug', 'regalos-bonitos');
        $this->assertTrue($category->is_active);

        $product = $this->product();
        $this->put("/admin/productos/{$product->id}", [
            'name' => 'Taza grande', 'price' => 150, 'category_id' => $category->id,
        ])->assertSessionHasNoErrors();
        $this->assertSame('Taza grande', $product->fresh()->name);
        $this->assertFalse($product->fresh()->is_active);

        $this->put("/admin/productos/{$product->id}", ['name' => 'X', 'price' => 0, 'category_id' => $category->id])
            ->assertSessionHasErrorsIn('edit', 'price');

        $this->delete("/admin/productos/{$product->id}");
        $this->assertModelMissing($product);
    }
}
