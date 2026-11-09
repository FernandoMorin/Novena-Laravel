<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_searches_paginates_and_shows_featured_only_on_its_front_page(): void
    {
        Product::factory()->count(13)->create(['name' => 'Vaso']);
        Product::factory()->create(['name' => 'Taza estrella', 'is_featured' => true]);

        $this->get('/productos')->assertOk()->assertSee('Destacados')->assertSee('Taza estrella')->assertSee('page=2', false);
        $this->get('/productos?page=2')->assertOk()->assertDontSee('Destacados');
        $this->get('/productos?q=estrella')->assertSee('Taza estrella')->assertDontSee('Vaso')->assertDontSee('Destacados');
    }

    public function test_product_page_shows_active_products_only(): void
    {
        $product = Product::factory()->create(['name' => 'Termo', 'price' => 250]);
        $hidden = Product::factory()->create(['is_active' => false]);

        $this->get("/productos/{$product->id}")->assertOk()->assertSee('Termo')->assertSee('$250.00');
        $this->get("/productos/{$hidden->id}")->assertNotFound();
    }

    public function test_cart_add_update_and_remove(): void
    {
        $taza = Product::factory()->create(['name' => 'Taza', 'price' => 100]);
        $vaso = Product::factory()->create(['name' => 'Vaso', 'price' => 50]);

        $this->post("/carrito/{$taza->id}", ['quantity' => 2]);
        $this->post("/carrito/{$taza->id}", ['quantity' => 1]);
        $this->post("/carrito/{$vaso->id}", ['quantity' => 1]);
        $this->assertSame([$taza->id => 3, $vaso->id => 1], session('cart'));
        $this->get('/carrito')->assertOk()->assertSee('$350.00');

        $this->patch("/carrito/{$taza->id}", ['quantity' => 0])->assertSessionHasErrors('quantity');
        $this->patch("/carrito/{$taza->id}", ['quantity' => 5]);
        $this->delete("/carrito/{$vaso->id}");
        $this->assertSame([$taza->id => 5], session('cart'));
    }

    public function test_checkout_creates_order_with_database_prices_and_empties_cart(): void
    {
        $user = User::factory()->create();
        $taza = Product::factory()->create(['name' => 'Taza', 'price' => 100]);
        $oculto = Product::factory()->create(['price' => 999]);

        $this->post('/pedidos')->assertRedirect(route('home', ['login' => 1]));

        $this->actingAs($user)->post("/carrito/{$taza->id}", ['quantity' => 2]);
        $this->post("/carrito/{$oculto->id}", ['quantity' => 1]);
        $oculto->update(['is_active' => false]); // desactivado después de agregarlo: no se cobra

        $this->post('/pedidos')->assertRedirect();

        $order = $user->orders()->with('items')->sole();
        $this->assertSame('200.00', $order->total);
        $this->assertSame('pendiente', $order->status);
        $this->assertSame(['Taza' => 2], $order->items->pluck('quantity', 'product_name')->all());
        $this->assertNull(session('cart'));

        $this->get('/mis-pedidos')->assertOk()->assertSee('#'.$order->id);
        $this->get("/mis-pedidos/{$order->id}")->assertOk()->assertSee('Taza');
    }

    public function test_customers_only_see_their_own_orders(): void
    {
        $order = Order::factory()->create();

        $this->actingAs(User::factory()->create())->get("/mis-pedidos/{$order->id}")->assertForbidden();
        $this->actingAs($order->user)->get("/mis-pedidos/{$order->id}")->assertOk();
    }

    public function test_profile_update_and_password_change(): void
    {
        $user = User::factory()->create(['password' => 'vieja']);
        $other = User::factory()->create();

        $this->get('/perfil')->assertRedirect(route('home', ['login' => 1]));

        $this->actingAs($user)->get('/perfil')->assertOk();
        $this->put('/perfil', ['name' => 'Diego', 'email' => $other->email])->assertSessionHasErrorsIn('profile', 'email');
        $this->put('/perfil', ['name' => 'Diego', 'email' => 'diego@novena.com'])->assertSessionHasNoErrors();
        $this->assertSame('diego@novena.com', $user->fresh()->email);

        $this->put('/perfil/password', ['current_password' => 'mal', 'password' => 'nueva', 'password_confirmation' => 'nueva'])
            ->assertSessionHasErrorsIn('password', 'current_password');
        $this->put('/perfil/password', ['current_password' => 'vieja', 'password' => 'nueva', 'password_confirmation' => 'nueva'])
            ->assertSessionHasNoErrors();
        $this->assertTrue(password_verify('nueva', $user->fresh()->password));
    }
}
