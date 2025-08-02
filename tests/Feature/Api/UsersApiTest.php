<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsersApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $testUser;
    protected $testPassword = 'TestPassword123!';

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user with a known password for authentication testing
        // This simulates a real user in the system with proper password hashing
        $this->testUser = User::factory()->create([
            'name' => 'Test',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'password' => Hash::make($this->testPassword), // Use Hash::make like the real system
        ]);
    }

    /**
     * Helper method to create Basic Auth header
     */
    private function getAuthHeader(string $email, string $password): array
    {
        return [
            'Authorization' => 'Basic ' . base64_encode($email . ':' . $password),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }

    /**
     * Test API health endpoint with valid credentials
     */
    public function test_api_health_endpoint()
    {
        $response = $this->getJson('/api/health',
            $this->getAuthHeader($this->testUser->email, $this->testPassword)
        );

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'API is healthy',
                    'version' => '1.0.0'
                ]);
    }

    /**
     * Test users index endpoint with valid authentication
     */
    public function test_users_index_with_authentication()
    {
        // Create additional test users
        User::factory()->count(5)->create();

        $response = $this->getJson('/api/users',
            $this->getAuthHeader($this->testUser->email, $this->testPassword)
        );

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'lastname',
                            'email',
                            'created_at',
                            'updated_at',
                            'roles'
                        ]
                    ],
                    'pagination' => [
                        'current_page',
                        'last_page',
                        'per_page',
                        'total',
                        'from',
                        'to'
                    ]
                ]);
    }

    /**
     * Test that API authentication uses the same system as web login
     */
    public function test_api_uses_same_authentication_as_web_login()
    {
        // Test with the exact same credentials that would work for web login
        $response = $this->getJson('/api/users/me',
            $this->getAuthHeader($this->testUser->email, $this->testPassword)
        );

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $this->testUser->id,
                        'email' => $this->testUser->email,
                        'name' => $this->testUser->name,
                        'lastname' => $this->testUser->lastname
                    ]
                ]);
    }

    /**
     * Test users index endpoint without authentication
     */
    public function test_users_index_without_authentication()
    {
        $response = $this->getJson('/api/users');

        $response->assertStatus(401)
                ->assertJson([
                    'success' => false,
                    'error' => 'Unauthorized',
                    'message' => 'Authorization header is required'
                ])
                ->assertHeader('WWW-Authenticate', 'Basic realm="Panel Colaborador API"');
    }

    /**
     * Test users index endpoint with invalid credentials
     */
    public function test_users_index_with_invalid_credentials()
    {
        $response = $this->getJson('/api/users',
            $this->getAuthHeader('invalid@example.com', 'wrongpassword')
        );

        $response->assertStatus(401)
                ->assertJson([
                    'success' => false,
                    'error' => 'Unauthorized',
                    'message' => 'Invalid credentials'
                ])
                ->assertHeader('WWW-Authenticate', 'Basic realm="Panel Colaborador API"');
    }

    /**
     * Test API authentication with valid email but wrong password
     */
    public function test_api_authentication_with_wrong_password()
    {
        $response = $this->getJson('/api/users',
            $this->getAuthHeader($this->testUser->email, 'wrongpassword')
        );

        $response->assertStatus(401)
                ->assertJson([
                    'success' => false,
                    'error' => 'Unauthorized',
                    'message' => 'Invalid credentials'
                ]);
    }

    /**
     * Test API authentication with invalid email format
     */
    public function test_api_authentication_with_invalid_email_format()
    {
        $response = $this->getJson('/api/users',
            $this->getAuthHeader('not-an-email', $this->testPassword)
        );

        $response->assertStatus(401)
                ->assertJson([
                    'success' => false,
                    'error' => 'Unauthorized',
                    'message' => 'Invalid email format'
                ]);
    }

    /**
     * Test API authentication with malformed authorization header
     */
    public function test_api_authentication_with_malformed_header()
    {
        $response = $this->getJson('/api/users', [
            'Authorization' => 'Basic ' . base64_encode('no-colon-separator'),
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401)
                ->assertJson([
                    'success' => false,
                    'error' => 'Unauthorized',
                    'message' => 'Invalid authorization format'
                ]);
    }

    /**
     * Test users show endpoint
     */
    public function test_users_show_endpoint()
    {
        $response = $this->getJson("/api/users/{$this->testUser->id}",
            $this->getAuthHeader($this->testUser->email, $this->testPassword)
        );

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'name',
                        'lastname',
                        'email',
                        'created_at',
                        'updated_at',
                        'roles'
                    ]
                ])
                ->assertJson([
                    'data' => [
                        'id' => $this->testUser->id,
                        'email' => $this->testUser->email
                    ]
                ]);
    }

    /**
     * Test users show endpoint with non-existent user
     */
    public function test_users_show_nonexistent_user()
    {
        $response = $this->getJson('/api/users/99999',
            $this->getAuthHeader($this->testUser->email, $this->testPassword)
        );

        $response->assertStatus(404)
                ->assertJson([
                    'success' => false,
                    'message' => 'User not found'
                ]);
    }

    /**
     * Test users me endpoint
     */
    public function test_users_me_endpoint()
    {
        $response = $this->getJson('/api/users/me',
            $this->getAuthHeader($this->testUser->email, $this->testPassword)
        );

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'name',
                        'lastname',
                        'email',
                        'created_at',
                        'updated_at',
                        'roles'
                    ]
                ])
                ->assertJson([
                    'data' => [
                        'id' => $this->testUser->id,
                        'email' => $this->testUser->email,
                        'name' => $this->testUser->name,
                        'lastname' => $this->testUser->lastname
                    ]
                ]);
    }

    /**
     * Test users index with search parameter
     */
    public function test_users_index_with_search()
    {
        // Create a user with specific name for searching
        User::factory()->create([
            'name' => 'SearchableUser',
            'lastname' => 'TestLastname',
            'email' => 'searchable@example.com',
            'password' => Hash::make('password123')
        ]);

        $response = $this->getJson('/api/users?search=SearchableUser',
            $this->getAuthHeader($this->testUser->email, $this->testPassword)
        );

        $response->assertStatus(200)
                ->assertJsonFragment([
                    'name' => 'SearchableUser'
                ]);
    }

    /**
     * Test users index with pagination parameters
     */
    public function test_users_index_with_pagination()
    {
        // Create additional users
        User::factory()->count(20)->create();

        $response = $this->getJson('/api/users?per_page=5&sort_by=email&sort_order=desc',
            $this->getAuthHeader($this->testUser->email, $this->testPassword)
        );

        $response->assertStatus(200)
                ->assertJsonPath('pagination.per_page', 5);
    }

    /**
     * Test that password hashing works the same as web login
     */
    public function test_password_hashing_consistency_with_web_login()
    {
        // Create a user with a specific password using Hash::make (same as web registration)
        $plainPassword = 'MySecurePassword123!';
        $webUser = User::factory()->create([
            'email' => 'webuser@example.com',
            'password' => Hash::make($plainPassword) // Same method used in RegisteredUserController
        ]);

        // Test that API authentication works with the same password
        $response = $this->getJson('/api/users/me',
            $this->getAuthHeader($webUser->email, $plainPassword)
        );

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $webUser->id,
                        'email' => $webUser->email
                    ]
                ]);
    }

    /**
     * Test authentication with different user accounts
     */
    public function test_authentication_with_multiple_users()
    {
        // Create another user
        $secondUser = User::factory()->create([
            'email' => 'second@example.com',
            'password' => Hash::make('SecondPassword123!')
        ]);

        // Test first user
        $response1 = $this->getJson('/api/users/me',
            $this->getAuthHeader($this->testUser->email, $this->testPassword)
        );

        $response1->assertStatus(200)
                 ->assertJson(['data' => ['id' => $this->testUser->id]]);

        // Test second user
        $response2 = $this->getJson('/api/users/me',
            $this->getAuthHeader($secondUser->email, 'SecondPassword123!')
        );

        $response2->assertStatus(200)
                 ->assertJson(['data' => ['id' => $secondUser->id]]);
    }
}
