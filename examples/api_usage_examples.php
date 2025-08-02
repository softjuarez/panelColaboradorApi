<?php

/**
 * Panel Colaborador API Usage Examples
 *
 * This file contains examples of how to interact with the Panel Colaborador API
 * using PHP cURL. These examples demonstrate authentication and basic API calls.
 *
 * IMPORTANT: The API uses the SAME credentials as your web login!
 * Use your existing email and password from the Panel Colaborador system.
 */

// Configuration - USE YOUR ACTUAL WEB LOGIN CREDENTIALS
$baseUrl = 'http://your-domain.com/api';
$email = 'your-web-login-email@company.com';    // Same email you use for web login
$password = 'your-web-login-password';          // Same password you use for web login

// Create authorization header (same credentials as web login)
$credentials = base64_encode($email . ':' . $password);
$authHeader = 'Authorization: Basic ' . $credentials;

echo "=== AUTHENTICATION INFO ===\n";
echo "Using web login credentials:\n";
echo "Email: " . $email . "\n";
echo "Password: " . str_repeat('*', strlen($password)) . "\n";
echo "Auth Header: " . $authHeader . "\n\n";

/**
 * Make an authenticated API request
 */
function makeApiRequest($url, $method = 'GET', $data = null, $authHeader = null) {
    $ch = curl_init();
    
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json',
            $authHeader
        ],
        CURLOPT_SSL_VERIFYPEER => false, // Only for development
    ]);
    
    if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    if ($error) {
        return ['error' => $error];
    }
    
    return [
        'status_code' => $httpCode,
        'data' => json_decode($response, true)
    ];
}

// Example 1: Health Check
echo "=== API Health Check ===\n";
$response = makeApiRequest($baseUrl . '/health', 'GET', null, $authHeader);
echo "Status: " . $response['status_code'] . "\n";
echo "Response: " . json_encode($response['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 2: Get All Users
echo "=== Get All Users ===\n";
$response = makeApiRequest($baseUrl . '/users', 'GET', null, $authHeader);
echo "Status: " . $response['status_code'] . "\n";
echo "Response: " . json_encode($response['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 3: Get Users with Pagination and Search
echo "=== Get Users with Pagination ===\n";
$queryParams = http_build_query([
    'per_page' => 5,
    'search' => 'john',
    'sort_by' => 'name',
    'sort_order' => 'asc'
]);
$response = makeApiRequest($baseUrl . '/users?' . $queryParams, 'GET', null, $authHeader);
echo "Status: " . $response['status_code'] . "\n";
echo "Response: " . json_encode($response['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 4: Get Current User
echo "=== Get Current User ===\n";
$response = makeApiRequest($baseUrl . '/users/me', 'GET', null, $authHeader);
echo "Status: " . $response['status_code'] . "\n";
echo "Response: " . json_encode($response['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 5: Get Specific User
echo "=== Get Specific User (ID: 1) ===\n";
$response = makeApiRequest($baseUrl . '/users/1', 'GET', null, $authHeader);
echo "Status: " . $response['status_code'] . "\n";
echo "Response: " . json_encode($response['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 6: Test Authentication Error
echo "=== Test Authentication Error ===\n";
$invalidAuthHeader = 'Authorization: Basic ' . base64_encode('invalid@example.com:wrongpassword');
$response = makeApiRequest($baseUrl . '/users', 'GET', null, $invalidAuthHeader);
echo "Status: " . $response['status_code'] . "\n";
echo "Response: " . json_encode($response['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 7: Test Missing Authentication
echo "=== Test Missing Authentication ===\n";
$response = makeApiRequest($baseUrl . '/users', 'GET', null, null);
echo "Status: " . $response['status_code'] . "\n";
echo "Response: " . json_encode($response['data'], JSON_PRETTY_PRINT) . "\n\n";

/**
 * JavaScript/AJAX Example
 */
echo "=== JavaScript/AJAX Example ===\n";
echo <<<'JAVASCRIPT'
// JavaScript example using fetch API
const baseUrl = 'http://your-domain.com/api';
const credentials = btoa('your-email@example.com:your-password');

// Function to make authenticated API requests
async function apiRequest(endpoint, options = {}) {
    const url = `${baseUrl}${endpoint}`;
    const defaultOptions = {
        headers: {
            'Authorization': `Basic ${credentials}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    };
    
    const response = await fetch(url, { ...defaultOptions, ...options });
    return await response.json();
}

// Example: Get all users
apiRequest('/users')
    .then(data => console.log('Users:', data))
    .catch(error => console.error('Error:', error));

// Example: Get users with search
apiRequest('/users?search=john&per_page=10')
    .then(data => console.log('Search results:', data))
    .catch(error => console.error('Error:', error));

// Example: Get current user
apiRequest('/users/me')
    .then(data => console.log('Current user:', data))
    .catch(error => console.error('Error:', error));
JAVASCRIPT;

echo "\n\n";

/**
 * cURL Command Examples
 */
echo "=== cURL Command Examples ===\n";
echo <<<CURL
# Health check
curl -X GET "http://your-domain.com/api/health" \
  -H "Authorization: Basic $(echo -n 'your-email@example.com:your-password' | base64)" \
  -H "Accept: application/json"

# Get all users
curl -X GET "http://your-domain.com/api/users" \
  -H "Authorization: Basic $(echo -n 'your-email@example.com:your-password' | base64)" \
  -H "Accept: application/json"

# Get users with pagination and search
curl -X GET "http://your-domain.com/api/users?per_page=10&search=john&sort_by=name&sort_order=asc" \
  -H "Authorization: Basic $(echo -n 'your-email@example.com:your-password' | base64)" \
  -H "Accept: application/json"

# Get current user
curl -X GET "http://your-domain.com/api/users/me" \
  -H "Authorization: Basic $(echo -n 'your-email@example.com:your-password' | base64)" \
  -H "Accept: application/json"

# Get specific user
curl -X GET "http://your-domain.com/api/users/1" \
  -H "Authorization: Basic $(echo -n 'your-email@example.com:your-password' | base64)" \
  -H "Accept: application/json"
CURL;

echo "\n\n=== Examples Complete ===\n";
echo "Remember to replace 'your-domain.com', 'your-email@example.com', and 'your-password' with actual values.\n";
echo "For production use, always use HTTPS and consider more secure authentication methods.\n";
