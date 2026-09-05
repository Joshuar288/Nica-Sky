<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\City;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionsTest extends TestCase
{
    use RefreshDatabase;

    private City $city;

    protected function setUp(): void
    {
        parent::setUp();

        $this->city = City::create([
            'name_departament' => 'Managua',
            'name_city' => 'Managua',
        ]);
    }

    public function test_user_cannot_access_the_audit_panel(): void
    {
        $this->actingAs($this->userWithRole(UserRole::User))
            ->get(route('auditor.shipments.index'))
            ->assertForbidden();
    }

    public function test_auditor_can_access_the_audit_panel(): void
    {
        $this->actingAs($this->userWithRole(UserRole::Auditor))
            ->get(route('auditor.shipments.index'))
            ->assertOk();
    }

    public function test_admin_can_access_the_audit_panel(): void
    {
        $this->actingAs($this->userWithRole(UserRole::Admin))
            ->get(route('auditor.shipments.index'))
            ->assertOk();
    }

    public function test_auditor_cannot_publish_buy_or_purchase_plans(): void
    {
        $auditor = $this->userWithRole(UserRole::Auditor);

        $this->actingAs($auditor)->get(route('product.create'))->assertForbidden();
        $this->actingAs($auditor)->get(route('cart.index'))->assertForbidden();
        $this->actingAs($auditor)->get(route('premium.show'))->assertForbidden();
    }

    public function test_user_can_access_marketplace_actions(): void
    {
        $user = $this->userWithRole(UserRole::User);

        $this->actingAs($user)->get(route('product.create'))->assertOk();
        $this->actingAs($user)->get(route('cart.index'))->assertOk();
        $this->actingAs($user)->get(route('premium.show'))->assertOk();
    }

    private function userWithRole(UserRole $role): User
    {
        return User::factory()->create([
            'city_id' => $this->city->id,
            'phone' => '88888888',
            'role' => $role,
        ]);
    }
}
