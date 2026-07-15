<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/controllers.php';

try {
    $pdo = getDbConnection();

    match ($_SERVER['REQUEST_METHOD']) {
        'GET' => handleGet($pdo),
        'POST' => handlePost($pdo),
        'PUT' => handlePut($pdo),
        'PATCH' => handlePatch($pdo),
        'DELETE' => handleDelete($pdo),
        default => handleMethodNotAllowed(),
    };
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection error: ' . $e->getMessage()]);
}