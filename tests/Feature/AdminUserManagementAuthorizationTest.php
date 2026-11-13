<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AdminUserManagementAuthorizationTest extends TestCase
{
    public function test_leaders_cannot_access_user_management(): void
    {
        $leader = new User([
            'name' => 'Leader',
            'npk' => 'leader-1',
            'role' => 'leader',
            'password' => 'password',
        ]);

        $this->actingAs($leader)
            ->get(route('users.index'))
            ->assertForbidden();
    }

    public function test_user_management_is_admin_only_while_data_management_is_shared(): void
    {
        $userManagementMiddleware = Route::getRoutes()
            ->getByName('users.index')
            ->gatherMiddleware();
        $dataManagementMiddleware = Route::getRoutes()
            ->getByName('best-records.index')
            ->gatherMiddleware();

        $this->assertContains('role:admin', $userManagementMiddleware);
        $this->assertContains('role:admin,leader', $dataManagementMiddleware);
    }
}
