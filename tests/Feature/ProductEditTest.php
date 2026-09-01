<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductEditTest extends TestCase
{
    use RefreshDatabase;

    private City $city;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->city = City::create([
            'name_departament' => 'Managua',
            'name_city' => 'Managua',
        ]);
        $this->category = Category::create([
            'name' => 'Tecnología',
            'type_category' => 'Productos',
        ]);
    }

    public function test_owner_can_update_every_product_field_and_recommendation(): void
    {
        $owner = $this->createUser('owner@example.com', 'pro_1');
        $product = $this->createProduct($owner);
        $newCategory = Category::create([
            'name' => 'Hogar',
            'type_category' => 'Productos',
        ]);

        $response = $this->actingAs($owner)->patch(route('product.update', $product), [
            'category_id' => $newCategory->id,
            'title' => 'Título actualizado',
            'description' => 'Descripción completamente actualizada.',
            'price' => 250.50,
            'unit' => 'par',
            'stock' => 8,
            'state' => 'Usado',
            'is_recommended' => '1',
        ]);

        $response->assertRedirect(route('myprofile.show'))
            ->assertSessionHas('success');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'category_id' => $newCategory->id,
            'title' => 'Título actualizado',
            'description' => 'Descripción completamente actualizada.',
            'price' => 250.50,
            'unit' => 'par',
            'stock' => 8,
            'state' => 'Usado',
            'is_recommended' => true,
        ]);
    }

    public function test_owner_can_remove_recommended_status(): void
    {
        $owner = $this->createUser('owner@example.com', 'pro_3');
        $product = $this->createProduct($owner, true);

        $this->actingAs($owner)->patch(route('product.update', $product), [
            'category_id' => $product->category_id,
            'title' => $product->title,
            'description' => $product->description,
            'price' => $product->price,
            'unit' => $product->unit,
            'stock' => $product->stock,
            'state' => $product->state,
        ])->assertRedirect(route('myprofile.show'));

        $this->assertFalse($product->fresh()->is_recommended);
    }

    public function test_another_user_cannot_edit_or_update_the_product(): void
    {
        $owner = $this->createUser('owner@example.com', 'pro_1');
        $otherUser = $this->createUser('other@example.com', 'pro_1');
        $product = $this->createProduct($owner);

        $this->actingAs($otherUser)
            ->get(route('product.edit', $product))
            ->assertForbidden();

        $this->actingAs($otherUser)
            ->patch(route('product.update', $product), [])
            ->assertForbidden();
    }

    public function test_my_profile_shows_modify_link_for_owned_products(): void
    {
        $owner = $this->createUser('owner@example.com', 'free');
        $product = $this->createProduct($owner);

        $this->actingAs($owner)
            ->get(route('myprofile.show'))
            ->assertOk()
            ->assertSee(route('product.edit', $product), false)
            ->assertSee('Modificar')
            ->assertSee('Visibilidad normal');
    }

    public function test_my_profile_identifies_products_with_priority_visibility(): void
    {
        $owner = $this->createUser('owner@example.com', 'pro_1');
        $this->createProduct($owner, true);

        $this->actingAs($owner)
            ->get(route('myprofile.show'))
            ->assertOk()
            ->assertSee('Visibilidad prioritaria');
    }

    private function createUser(string $email, string $plan): User
    {
        return User::factory()->create([
            'city_id' => $this->city->id,
            'phone' => '88888888',
            'email' => $email,
            'plan' => $plan,
        ]);
    }

    private function createProduct(User $owner, bool $recommended = false): Product
    {
        return Product::create([
            'user_id' => $owner->id,
            'category_id' => $this->category->id,
            'title' => 'Producto original',
            'description' => 'Descripción original',
            'price' => 100,
            'unit' => 'unidad',
            'stock' => 10,
            'state' => 'Nuevo',
            'is_recommended' => $recommended,
        ]);
    }
}
