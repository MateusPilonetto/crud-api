<?php

require_once __DIR__ . '/validation.php';
require_once __DIR__ . '/data.php';

function getAllProducts(PDO $pdo, ?string $searchTerm = null): array
{
    if ($searchTerm !== null && $searchTerm !== '') {
        return ['products' => findProductsByTerm($pdo, $searchTerm)];
    }

    return ['products' => findAllProducts($pdo)];
}

function createProduct(PDO $pdo, ?array $input): array
{
    if (!is_array($input)) {
        return ['error' => 'Invalid SQL body', 'status' => 400];
    }

    $error = validateRequiredFields($input, ['name', 'price', 'stock', 'category']);
    if ($error) {
        return ['error' => $error, 'status' => 400];
    }

    $error = validateProductFields($input);
    if ($error) {
        return ['error' => $error, 'status' => 400];
    }

    $product = insertProduct($pdo, [
        'name' => trim($input['name']),
        'price' => (float) $input['price'],
        'stock' => (int) $input['stock'],
        'category' => trim($input['category']),
    ]);

    return ['data' => $product, 'status' => 201];
}

function editProduct(PDO $pdo, ?int $id, ?array $input, bool $partial = false): array
{
    if ($id === null) {
        return ['error' => 'Product id is required', 'status' => 400];
    }

    if (!is_array($input)) {
        return ['error' => 'Invalid JSON body', 'status' => 400];
    }

    if (!$partial) {
        $error = validateRequiredFields($input, ['name', 'price', 'stock', 'category']);
        if ($error) {
            return ['error' => $error, 'status' => 400];
        }
    }

    $error = validateProductFields($input);
    if ($error) {
        return ['error' => $error, 'status' => 400];
    }

    $allowed = ['name', 'price', 'stock', 'category'];
    $fields = array_intersect_key($input, array_flip($allowed));

    if (isset($fields['name'])) {
        $fields['name'] = trim($fields['name']);
    }

    if (isset($fields['price'])) {
        $fields['price'] = (float) $fields['price'];
    }

    if (isset($fields['stock'])) {
        $fields['stock'] = (int) $fields['stock'];
    }

    if (isset($fields['category'])) {
        $fields['category'] = trim($fields['category']);
    }

    $product = updateProduct($pdo, $id, $fields);

    if ($product === null) {
        return ['error' => 'Product not found', 'status' => 404];
    }

    return ['data' => $product, 'status' => 200];
}

function removeProduct(PDO $pdo, ?int $id): array
{
    if ($id === null) {
        return ['error' => 'Product id is required', 'status' => 400];
    }

    $product = deleteProduct($pdo, $id);

    if ($product === null) {
        return ['error' => 'Product not found', 'status' => 404];
    }

    return ['data' => ['deleted' => $product], 'status' => 200];
}