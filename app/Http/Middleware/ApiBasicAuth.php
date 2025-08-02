<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiBasicAuth
{
    /**
     * Handle an incoming request for API basic authentication.
     *
     * This middleware validates API credentials using the same authentication
     * system as the web login, ensuring consistency with the main application.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if Authorization header is present
        if (!$request->hasHeader('Authorization')) {
            return $this->unauthorizedResponse('Authorization header is required');
        }

        $authHeader = $request->header('Authorization');

        // Check if it's Basic authentication
        if (!str_starts_with($authHeader, 'Basic ')) {
            return $this->unauthorizedResponse('Basic authentication required');
        }

        // Extract and decode credentials
        $credentials = base64_decode(substr($authHeader, 6));

        if (!$credentials || !str_contains($credentials, ':')) {
            return $this->unauthorizedResponse('Invalid authorization format');
        }

        [$email, $password] = explode(':', $credentials, 2);

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->unauthorizedResponse('Invalid email format');
        }

        // Attempt to authenticate using the same method as the web login
        // This uses the exact same Auth::attempt() call as in LoginRequest.php
        try {
            if (!Auth::attempt(['email' => $email, 'password' => $password], false)) {
                // Log failed authentication attempt for security monitoring
                Log::warning('API authentication failed', [
                    'email' => $email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);

                return $this->unauthorizedResponse('Invalid credentials');
            }

            // Authentication successful - user is now authenticated
            // The Auth::attempt() method automatically logs in the user
            Log::info('API authentication successful', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
                'ip' => $request->ip()
            ]);

        } catch (\Exception $e) {
            // Log any authentication errors
            Log::error('API authentication error', [
                'email' => $email,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return $this->unauthorizedResponse('Authentication system error');
        }

        return $next($request);
    }

    /**
     * Return a standardized unauthorized response
     *
     * @param string $message
     * @return Response
     */
    private function unauthorizedResponse(string $message): Response
    {
        return response()->json([
            'success' => false,
            'error' => 'Unauthorized',
            'message' => $message
        ], 401, [
            'WWW-Authenticate' => 'Basic realm="Panel Colaborador API"'
        ]);
    }
}
