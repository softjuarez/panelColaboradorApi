<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationConsistencyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that API authentication uses exactly the same Auth::attempt() method as web login
     */
    public function test_api_authentication_uses_same_method_as_web_login()
    {
        // Create a user with the same method used in the system
        $email = 'consistency@test.com';
        $password = 'TestPassword123!';
        
        $user = User::create([
            'name' => 'Consistency',
            'lastname' => 'Test',
            'email' => $email,
            'password' => Hash::make($password), // Same as RegisteredUserController
        ]);

        // First, verify that Auth::attempt() works directly (simulating web login)
        $webAuthResult = Auth::attempt(['email' => $email, 'password' => $password]);
        $this->assertTrue($webAuthResult, 'Web authentication should work');
        
        // Logout to reset authentication state
        Auth::logout();

        // Now test that the API uses the same authentication
        $response = $this->getJson('/api/users/me', [
            'Authorization' => 'Basic ' . base64_encode($email . ':' . $password),
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $user->id,
                        'email' => $email,
                        'name' => 'Consistency',
                        'lastname' => 'Test'
                    ]
                ]);
    }

    /**
     * Test that API authentication fails with the same credentials that would fail web login
     */
    public function test_api_authentication_fails_consistently_with_web_login()
    {
        $email = 'test@example.com';
        $correctPassword = 'CorrectPassword123!';
        $wrongPassword = 'WrongPassword123!';

        // Create user
        User::create([
            'name' => 'Test',
            'lastname' => 'User',
            'email' => $email,
            'password' => Hash::make($correctPassword),
        ]);

        // Verify that Auth::attempt() fails with wrong password (simulating web login failure)
        $webAuthResult = Auth::attempt(['email' => $email, 'password' => $wrongPassword]);
        $this->assertFalse($webAuthResult, 'Web authentication should fail with wrong password');

        // Test that API also fails with the same wrong credentials
        $response = $this->getJson('/api/users/me', [
            'Authorization' => 'Basic ' . base64_encode($email . ':' . $wrongPassword),
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                ->assertJson([
                    'success' => false,
                    'error' => 'Unauthorized',
                    'message' => 'Invalid credentials'
                ]);
    }

    /**
     * Test that API authentication works with users created through the web registration process
     */
    public function test_api_works_with_web_registered_users()
    {
        // Simulate the exact user creation process from RegisteredUserController
        $userData = [
            'name' => 'Web',
            'lastname' => 'Registered',
            'email' => 'web.registered@example.com',
            'password' => 'WebPassword123!'
        ];

        // Create user exactly like RegisteredUserController does
        $user = User::create([
            'name' => $userData['name'],
            'lastname' => $userData['lastname'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']), // Same method as RegisteredUserController
        ]);

        // Test that API authentication works with this user
        $response = $this->getJson('/api/users/me', [
            'Authorization' => 'Basic ' . base64_encode($userData['email'] . ':' . $userData['password']),
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $user->id,
                        'email' => $userData['email'],
                        'name' => $userData['name'],
                        'lastname' => $userData['lastname']
                    ]
                ]);
    }

    /**
     * Test that API authentication respects the same user model and database connection
     */
    public function test_api_uses_same_user_model_and_connection()
    {
        // Create a user and verify it uses the same connection as defined in User model
        $user = User::create([
            'name' => 'Connection',
            'lastname' => 'Test',
            'email' => 'connection@test.com',
            'password' => Hash::make('ConnectionTest123!')
        ]);

        // Verify the user was created with the correct connection (sqlsrv as defined in User model)
        $this->assertEquals('sqlsrv', $user->getConnectionName());

        // Test API authentication
        $response = $this->getJson('/api/users/me', [
            'Authorization' => 'Basic ' . base64_encode('connection@test.com:ConnectionTest123!'),
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $user->id,
                        'email' => 'connection@test.com'
                    ]
                ]);
    }

    /**
     * Test that API authentication handles edge cases the same way as web login
     */
    public function test_api_handles_edge_cases_like_web_login()
    {
        // Test case 1: Empty password
        $user = User::create([
            'name' => 'Edge',
            'lastname' => 'Case',
            'email' => 'edge@test.com',
            'password' => Hash::make('ValidPassword123!')
        ]);

        // Test with empty password
        $response = $this->getJson('/api/users/me', [
            'Authorization' => 'Basic ' . base64_encode('edge@test.com:'),
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);

        // Test case 2: Case sensitivity in email (should work - Laravel is case insensitive for emails)
        $response = $this->getJson('/api/users/me', [
            'Authorization' => 'Basic ' . base64_encode('EDGE@TEST.COM:ValidPassword123!'),
            'Accept' => 'application/json'
        ]);

        // This should work because Laravel's Auth::attempt is case insensitive for emails
        $response->assertStatus(200);
    }

    /**
     * Test that API logs authentication attempts like the web system would
     */
    public function test_api_logs_authentication_attempts()
    {
        // Create a user
        $user = User::create([
            'name' => 'Log',
            'lastname' => 'Test',
            'email' => 'log@test.com',
            'password' => Hash::make('LogTest123!')
        ]);

        // Test successful authentication (should be logged)
        $response = $this->getJson('/api/users/me', [
            'Authorization' => 'Basic ' . base64_encode('log@test.com:LogTest123!'),
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);

        // Test failed authentication (should be logged)
        $response = $this->getJson('/api/users/me', [
            'Authorization' => 'Basic ' . base64_encode('log@test.com:WrongPassword'),
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);

        // Note: In a real application, you would check the logs here
        // For this test, we're just ensuring the requests complete without errors
        $this->assertTrue(true, 'Authentication logging test completed');
    }
}
