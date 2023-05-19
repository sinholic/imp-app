<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user list success
     */
    public function testUserListSuccess() {
        $user = User::factory()->create();

        $token = auth()->login($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET','/user/userlist');

        $response->assertStatus(200);
    }

    /**
     * Test user list fail
     */
    public function testUserListFail() {
        $response = $this->json('GET', '/user/userlist');

        $response->assertStatus(401);
    }
}
