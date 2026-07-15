<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/openapi.php';

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

in_array($origin, $allowedOrigins) ?
    header("Access-Control-Allow-Origin: $origin") : null;
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$uri = strtok($_SERVER['REQUEST_URI'], '?');

match ($uri) {
    '/api/products' => require __DIR__ . '/../src/api.php',
    '/docs' => serveView(__DIR__ . '/../views/docs.html'),
    '/openapi.json' => serveJson(__DIR__ . '/../openapi.json'),
    default => notFound(),
};


function serveView(string $filePath): void
{
    if (!file_exists($filePath)) {
        notFound();
        exit;
    }
    header('Content-Type: text/html; charset=utf-8');
    readfile($filePath);
}

function serveJson(string $filePath): void
{
    if (!file_exists($filePath)) {
        notFound();
        exit;
    }
    header('Content-Type: application/json; charset=utf-8');
    readfile($filePath);
}

function notFound(): void
{
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}