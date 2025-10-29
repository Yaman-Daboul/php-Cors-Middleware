<?php

// السماح فقط بـ GET و OPTIONS
$allowed_methods = ['POST', 'GET' ,'OPTIONS'];

// حظر ال method ->post
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // منع التنفيذ
    http_response_code(405); // رمز "Method Not Allowed"
    exit('تم حظر العملية GET.');
}

///////////////////////////////////////////////////////////////////////////////////s

//header ("Access-Control-Allow-Origin: http://localhost:*" );

$allowedOrigins = [
    "http://localhost:3000",
    "http://localhost:3002",
    "https://example.com"
];

$blockedOrigins = [
    "http://localhost:3003",
    "https://localhost:3001"
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (in_array($origin, $blockedOrigins)) {
    // رفض الطلب من هذا النطاق
    http_response_code(403); // Forbidden
    echo json_encode(["error" => "Access denied for origin: $origin"]);
    exit();
}

if (in_array($origin, $allowedOrigins)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, X-Custom-Header");
}

// إذا كان الطلب من نوع OPTIONS (Preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
////////////////////////////////////////////////////////////////////////////////s

header ("Access-Control-Allow-Credentials: true" ); //true

////////////////////////////////////////////////////////////////////////////////s

header ("Content-Type: application/json" );

//header("Content-Type: text/html"); // لصفحة HTML
// أو
//header("Content-Type: text/plain"); // لنص عادي

////////////////////////////////////////////////////////////////////////////////s



// Handle Preflight OPTIONS request
if ($_SERVER ['REQUEST_METHOD' ] === 'OPTIONS' ) {
// Allowed methods and headers for preflight

////////////////////////////////////////////////////////////////////////////////s

//header ("Access-Control-Allow-Methods: GET, POST, OPTIONS" );

////////////////////////////////////////////////////////////////////////////////s

// header("Access-Control-Allow-Headers: Content-Type, X-Custom-Header");

header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

//header("Access-Control-Allow-Headers: *");

#### 3. السماح بترويسة واحدة فقط
//header("Access-Control-Allow-Headers: Authorization");

////////////////////////////////////////////////////////////////////////////////s

exit(0); // No content for OPTIONS
}
$response = [
"method" => $_SERVER ['REQUEST_METHOD' ],
"message" => "Hello from laragon PHP backend!" ,
"timestamp" => time()
];
// Read POST data if POST method
if ($_SERVER ['REQUEST_METHOD' ] === 'POST' ) {
// Read raw POST body
$input = json_decode (file_get_contents ('php://input' ), true);
$response ['received' ] = $input ;
}
echo json_encode ($response );