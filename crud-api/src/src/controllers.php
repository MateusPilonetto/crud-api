<?php

require_once __DIR__ . '/services.php';

function sendJsonResponse(array $data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
}

function handleGet(PDO $pdo): void
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $searchTerm = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);

    // Note: A API não suporta buscar por ID e por termo ao mesmo tempo.
    // A busca por ID tem prioridade.
    if ($id !== null && $id !== false) {
        // Lógica para buscar por ID pode ser adicionada aqui se necessário.
    }

    $result = getAllProducts($pdo, $searchTerm);
    sendJsonResponse($result);
}

function handlePost(PDO $pdo): void
{
    $input = json_decode(file_get_contents('php://input'), true);
    $result = createProduct($pdo, $input);
    sendJsonResponse($result['data'] ?? ['error' => $result['error']], $result['status']);
}

function handlePut(PDO $pdo): void
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $input = json_decode(file_get_contents('php://input'), true);
    $result = editProduct($pdo, $id, $input);
    sendJsonResponse($result['data'] ?? ['error' => $result['error']], $result['status']);
}

function handlePatch(PDO $pdo): void
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $input = json_decode(file_get_contents('php://input'), true);
    $result = editProduct($pdo, $id, $input, true);
    sendJsonResponse($result['data'] ?? ['error' => $result['error']], $result['status']);
}

function handleDelete(PDO $pdo): void
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $result = removeProduct($pdo, $id);
    sendJsonResponse($result['data'] ?? ['error' => $result['error']], $result['status']);
}

function handleMethodNotAllowed(): void
{
    sendJsonResponse(['error' => 'Method Not Allowed'], 405);
}