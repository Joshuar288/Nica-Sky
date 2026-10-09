<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    private City $city;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->city = City::create(['name_departament' => 'Managua', 'name_city' => 'Managua']);
        $this->category = Category::create(['name' => 'Tecnología', 'type_category' => 'Productos']);
    }

    public function test_only_admin_can_access_management_lists(): void
    {
        $admin = $this->userWithRole(UserRole::Admin, 'admin@example.com');
        $user = $this->userWithRole(UserRole::User, 'user@example.com');

        $this->actingAs($admin)->get(route('admin.products.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.users.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.products.index'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_admin_can_reject_a_publication(): void
    {
        $admin = $this->userWithRole(UserRole::Admin, 'admin@example.com');
        $seller = $this->userWithRole(UserRole::User, 'seller@example.com');
        $product = $this->productOwnedBy($seller);

        $this->actingAs($admin)->patch(route('admin.products.moderate', $product), [
            'moderation_status' => 'rejected',
            'moderation_notes' => 'La publicación necesita información adicional.',
        ])->assertRedirect();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'moderation_status' => 'rejected',
            'moderated_by' => $admin->id,
        ]);
    }

    public function test_admin_can_delete_a_publication_and_user_but_not_an_admin(): void
    {
        $admin = $this->userWithRole(UserRole::Admin, 'admin@example.com');
        $seller = $this->userWithRole(UserRole::User, 'seller@example.com');
        $product = $this->productOwnedBy($seller);

        $this->actingAs($admin)->delete(route('admin.products.destroy', $product))->assertRedirect();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);

        $this->actingAs($admin)->delete(route('admin.users.destroy', $seller))->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $seller->id]);

        $anotherAdmin = $this->userWithRole(UserRole::Admin, 'another-admin@example.com');
        $this->actingAs($admin)->delete(route('admin.users.destroy', $anotherAdmin))->assertForbidden();
    }

    private function userWithRole(UserRole $role, string $email): User
    {
        return User::factory()->create([
            'city_id' => $this->city->id,
            'phone' => '88888888',
            'email' => $email,
            'role' => $role,
        ]);
    }

    private function productOwnedBy(User $user): Product
    {
        return Product::create([
            'user_id' => $user->id,
            'category_id' => $this->category->id,
            'title' => 'Publicación de prueba',
            'description' => 'Descripción de prueba',
            'price' => 100,
            'unit' => 'unidad',
            'stock' => 10,
            'state' => 'Nuevo',
        ]);
    }
}
