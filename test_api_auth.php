<?php

/**
 * Script de Prueba de Autenticación API
 * 
 * Este script te permite probar rápidamente si la autenticación del API
 * funciona con tus credenciales reales del sistema web.
 * 
 * INSTRUCCIONES:
 * 1. Cambia las variables $email y $password por tus credenciales reales
 * 2. Cambia $baseUrl por la URL real de tu aplicación
 * 3. Ejecuta: php test_api_auth.php
 */

// ========================================
// CONFIGURACIÓN - CAMBIA ESTOS VALORES
// ========================================

$baseUrl = 'http://127.0.0.1:8000/api';  // Cambia por tu URL real
$email = 'admin@sidgt.com';         // Tu email de login web
$password = '123456789';          // Tu password de login web

// ========================================
// NO CAMBIES NADA DEBAJO DE ESTA LÍNEA
// ========================================

echo "==========================================\n";
echo "PRUEBA DE AUTENTICACIÓN API\n";
echo "==========================================\n\n";

echo "Configuración:\n";
echo "- Base URL: $baseUrl\n";
echo "- Email: $email\n";
echo "- Password: " . str_repeat('*', strlen($password)) . "\n\n";

// Crear header de autorización
$credentials = base64_encode($email . ':' . $password);
$authHeader = 'Authorization: Basic ' . $credentials;

echo "Header de autorización generado:\n";
echo "$authHeader\n\n";

/**
 * Función para hacer peticiones API
 */
function testApiEndpoint($url, $authHeader, $endpointName) {
    echo "Probando: $endpointName\n";
    echo "URL: $url\n";
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Content-Type: application/json',
            $authHeader
        ],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 30
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "❌ ERROR cURL: $error\n\n";
        return false;
    }
    
    echo "Status Code: $httpCode\n";
    
    if ($httpCode == 200) {
        echo "✅ ÉXITO - Autenticación correcta\n";
        $data = json_decode($response, true);
        if ($data) {
            echo "Respuesta: " . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
        }
    } elseif ($httpCode == 401) {
        echo "❌ ERROR 401 - Credenciales inválidas\n";
        echo "Verifica que tu email y password sean correctos\n";
        $data = json_decode($response, true);
        if ($data && isset($data['message'])) {
            echo "Mensaje: " . $data['message'] . "\n";
        }
    } else {
        echo "⚠️  Status Code inesperado: $httpCode\n";
        echo "Respuesta: $response\n";
    }
    
    echo "\n" . str_repeat("-", 50) . "\n\n";
    return $httpCode == 200;
}

// Pruebas
echo "Iniciando pruebas...\n\n";

$tests = [
    'Health Check' => $baseUrl . '/health',
    'Usuario Actual' => $baseUrl . '/users/me',
    'Lista de Usuarios' => $baseUrl . '/users?per_page=5'
];

$successCount = 0;
$totalTests = count($tests);

foreach ($tests as $name => $url) {
    if (testApiEndpoint($url, $authHeader, $name)) {
        $successCount++;
    }
}

// Resumen
echo "==========================================\n";
echo "RESUMEN DE PRUEBAS\n";
echo "==========================================\n";
echo "Pruebas exitosas: $successCount / $totalTests\n";

if ($successCount == $totalTests) {
    echo "🎉 ¡TODAS LAS PRUEBAS PASARON!\n";
    echo "La autenticación del API funciona correctamente con tus credenciales.\n";
} elseif ($successCount > 0) {
    echo "⚠️  ALGUNAS PRUEBAS FALLARON\n";
    echo "Verifica la configuración del servidor y las URLs.\n";
} else {
    echo "❌ TODAS LAS PRUEBAS FALLARON\n";
    echo "Posibles causas:\n";
    echo "1. Credenciales incorrectas (email/password)\n";
    echo "2. URL base incorrecta\n";
    echo "3. Servidor no disponible\n";
    echo "4. Middleware de autenticación no configurado\n";
}

echo "\n";
echo "Notas importantes:\n";
echo "- Usa las MISMAS credenciales que usas para el login web\n";
echo "- Verifica que el servidor esté ejecutándose\n";
echo "- Asegúrate de que la URL base sea correcta\n";
echo "- En producción, usa HTTPS en lugar de HTTP\n";

echo "\nEjemplo de uso con cURL:\n";
echo "curl -X GET \"$baseUrl/users/me\" \\\n";
echo "  -H \"Authorization: Basic $credentials\" \\\n";
echo "  -H \"Accept: application/json\"\n";
