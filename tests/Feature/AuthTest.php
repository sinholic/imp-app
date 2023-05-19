<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration success
     */

    public function testUserRegistrationSuccess()
    {
        $response = $this->post('/auth/signup', [
            'username' => 'testuser',
            'password' => 'test123',
            'fullname' => 'Test User',
        ]);

        $response->assertStatus(201)
        ->assertJson([
            'access_token' => $response['access_token'],
            'token_type' => $response['token_type'],
            'expires_in' => $response['expires_in'],
            'user' => $response['user']
        ]);
    }

    /**
     * Test user registration with duplicate username
     */
    public function testUserRegistrationDuplicateUsername(){
        $this->post('/auth/signup', [
            'username' => 'testuser',
            'password' => 'test123',
            'fullname' => 'Test User',
        ]);

        $response = $this->post('/auth/signup', [
            'username' => 'testuser',
            'password' => 'test123',
            'fullname' => 'Test User',
        ]);

        $response->assertStatus(409)
        ->assertJson([
            'error' => 'User already exists',
        ]);
    }

    /**
     * Test user registration with duplicate fullname
     */
    public function testUserRegistrationDuplicateFullname(){
        $this->post('/auth/signup', [
            'username' => 'testuser',
            'password' => 'test123',
            'fullname' => 'Test User',
        ]);

        $response = $this->post('/auth/signup', [
            'username' => 'testuser1',
            'password' => 'test123',
            'fullname' => 'Test User',
        ]);

        $response->assertStatus(201)
        ->assertJson([
            'access_token' => $response['access_token'],
            'token_type' => $response['token_type'],
            'expires_in' => $response['expires_in'],
            'user' => $response['user']
        ]);
    }

    /**
     * Test user registration with invalid username
     */
    public function testUserRegistrationInvalidUsername(){
        $response = $this->post('/auth/signup', [
            'password' => 'test123',
            'fullname' => 'Test User',
        ]);

        $response->assertStatus(400)
        ->assertJson([
            'error' => 'Username is required',
        ]);
    }

    /**
     * Test user registration with invalid password
     */
    public function testUserRegistrationInvalidPassword(){
        $response = $this->post('/auth/signup', [
            'username' => 'testuser',
            'fullname' => 'Test User',
        ]);

        $response->assertStatus(400)
        ->assertJson([
            'error' => 'Password is required'
        ]);
    }

    /**
     * Test user registration with invalid fullname
     */
    public function testUserRegistrationInvalidFullname(){
        $response = $this->post('/auth/signup', [
            'username' => 'testuser',
            'password' => 'test123',
        ]);

        $response->assertStatus(400)
        ->assertJson([
            'error' => 'Fullname is required'
        ]);
    }

    /**
     * Test user login success
     */
    public function testUserLoginSuccess()
    {
        $password = 'test123';
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        $response = $this->post('/auth/login', [
            'username' => $user->username,
            'password' => $password,
        ]);

        $response->assertStatus(200)
        ->assertJson([
            'access_token' => $response['access_token'],
            'token_type' => $response['token_type'],
            'expires_in' => $response['expires_in'],
            'user' => $response['user']
        ]);
    }

    /**
     * Test user login failure
     */
    public function testUserLoginFailure() {
        $password = 'test123';
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        $response = $this->post('/auth/login', [
            'username' => $user->username,
            'password' => "test132",
        ]);

        $response->assertStatus(401)
        ->assertJson([
            'error' => 'Invalid credentials'
        ]);
    }
}
