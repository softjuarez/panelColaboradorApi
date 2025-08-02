# Panel Colaborador API Documentation

## Overview

This API provides access to the Panel Colaborador system data through RESTful endpoints. All API endpoints require basic HTTP authentication and return JSON responses.

## Base URL

```
http://your-domain.com/api
```

## Authentication

The API uses **Basic HTTP Authentication** with the **exact same credentials** as the web login system. This means:

- ✅ **Same email and password** you use to log into the web interface
- ✅ **Same user accounts** from the `users` table
- ✅ **Same password validation** using Laravel's Auth::attempt()
- ✅ **Same database connection** (SQL Server - sqlsrv)

### Authentication Header Format

```
Authorization: Basic <base64-encoded-credentials>
```

Where `<base64-encoded-credentials>` is the base64 encoding of `email:password`.

### Example Authentication Header

```bash
# If your web login credentials are:
# Email: usuario@empresa.com
# Password: MiPassword123!

# Then your API authentication header would be:
Authorization: Basic $(echo -n 'usuario@empresa.com:MiPassword123!' | base64)
```

### Important Notes

- 🔐 **Use your web login credentials**: The same email and password you use to access the web system
- 📧 **Email format required**: Must be a valid email address (same as web login)
- 🔒 **Case sensitivity**: Emails are case-insensitive, passwords are case-sensitive
- 🚫 **No separate API keys**: Uses your existing user account credentials

## Response Format

All API responses follow a consistent JSON format:

### Success Response
```json
{
    "success": true,
    "message": "Success message",
    "data": {
        // Response data
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        // Optional error details
    }
}
```

### Paginated Response
```json
{
    "success": true,
    "message": "Success message",
    "data": [
        // Array of items
    ],
    "pagination": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 15,
        "total": 75,
        "from": 1,
        "to": 15
    }
}
```

## HTTP Status Codes

- `200` - OK: Request successful
- `201` - Created: Resource created successfully
- `400` - Bad Request: Invalid request parameters
- `401` - Unauthorized: Authentication required or failed
- `403` - Forbidden: Access denied
- `404` - Not Found: Resource not found
- `422` - Unprocessable Entity: Validation errors
- `500` - Internal Server Error: Server error

## Endpoints

### Health Check

Check if the API is running and accessible.

**GET** `/health`

#### Response
```json
{
    "success": true,
    "message": "API is healthy",
    "timestamp": "2025-08-02T10:30:00.000000Z",
    "version": "1.0.0"
}
```

### Users

#### Get All Users

Retrieve a paginated list of system users.

**GET** `/users`

#### Query Parameters
- `per_page` (integer, optional): Number of items per page (default: 15, max: 100)
- `search` (string, optional): Search term for name, lastname, or email
- `sort_by` (string, optional): Sort field (id, name, lastname, email, created_at) - default: name
- `sort_order` (string, optional): Sort order (asc, desc) - default: asc

#### Example Request
```bash
curl -X GET "http://your-domain.com/api/users?per_page=10&search=john&sort_by=name&sort_order=asc" \
  -H "Authorization: Basic dXNlckBleGFtcGxlLmNvbTpteXBhc3N3b3Jk"
```

#### Example Response
```json
{
    "success": true,
    "message": "Users retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "John",
            "lastname": "Doe",
            "email": "john.doe@example.com",
            "created_at": "2025-01-01T00:00:00.000000Z",
            "updated_at": "2025-01-01T00:00:00.000000Z",
            "roles": [
                {
                    "id": 1,
                    "name": "Admin"
                }
            ]
        }
    ],
    "pagination": {
        "current_page": 1,
        "last_page": 1,
        "per_page": 10,
        "total": 1,
        "from": 1,
        "to": 1
    }
}
```

#### Get Single User

Retrieve details of a specific user.

**GET** `/users/{id}`

#### Parameters
- `id` (integer, required): User ID

#### Example Request
```bash
curl -X GET "http://your-domain.com/api/users/1" \
  -H "Authorization: Basic dXNlckBleGFtcGxlLmNvbTpteXBhc3N3b3Jk"
```

#### Example Response
```json
{
    "success": true,
    "message": "User retrieved successfully",
    "data": {
        "id": 1,
        "name": "John",
        "lastname": "Doe",
        "email": "john.doe@example.com",
        "created_at": "2025-01-01T00:00:00.000000Z",
        "updated_at": "2025-01-01T00:00:00.000000Z",
        "roles": [
            {
                "id": 1,
                "name": "Admin"
            }
        ]
    }
}
```

#### Get Current User

Retrieve details of the currently authenticated user.

**GET** `/users/me`

#### Example Request
```bash
curl -X GET "http://your-domain.com/api/users/me" \
  -H "Authorization: Basic dXNlckBleGFtcGxlLmNvbTpteXBhc3N3b3Jk"
```

#### Example Response
```json
{
    "success": true,
    "message": "Current user retrieved successfully",
    "data": {
        "id": 1,
        "name": "John",
        "lastname": "Doe",
        "email": "john.doe@example.com",
        "created_at": "2025-01-01T00:00:00.000000Z",
        "updated_at": "2025-01-01T00:00:00.000000Z",
        "roles": [
            {
                "id": 1,
                "name": "Admin"
            }
        ]
    }
}
```

## Error Handling

### Authentication Errors

#### Missing Authorization Header
```json
{
    "error": "Unauthorized",
    "message": "Authorization header is required"
}
```

#### Invalid Credentials
```json
{
    "error": "Unauthorized",
    "message": "Invalid credentials"
}
```

### Validation Errors
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "field_name": ["Error message"]
    }
}
```

### Not Found Errors
```json
{
    "success": false,
    "message": "Resource not found"
}
```

## CORS Configuration

CORS is configured to allow requests from any origin for API routes. The following headers are supported:
- All HTTP methods
- All origins (*)
- All headers

## Rate Limiting

API requests are subject to Laravel's default throttling middleware with a limit of 60 requests per minute per IP address.

## Future Extensibility

The API is designed with scalability in mind:

1. **Base Controller**: All API controllers extend `BaseApiController` for consistent responses
2. **Middleware**: Custom `ApiBasicAuth` middleware can be easily extended or replaced
3. **Route Grouping**: Routes are organized in logical groups for easy management
4. **Error Handling**: Standardized error responses across all endpoints
5. **Validation**: Built-in support for request validation with proper error responses

## Adding New Endpoints

To add new API endpoints:

1. Create a new controller extending `BaseApiController`
2. Add routes to the authenticated group in `routes/api.php`
3. Use the provided response methods for consistency
4. Update this documentation

## Security Considerations

- All API routes require authentication
- Sensitive user data (passwords, tokens) are excluded from responses
- Input validation is performed on all endpoints
- HTTPS should be used in production environments
- Consider implementing API rate limiting per user for production use
