<?php

function findAllProducts(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT id, name, price, stock, category FROM products ORDER BY id');
    return $stmt->fetchAll();
}

function findProductById(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT id, name, price, stock, category FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    return $product ?: null;
}

function findProductsByTerm(PDO $pdo, string $searchTerm): array
{
    // Usamos LIKE para fazer uma busca parcial (case-insensitive por padrão no MySQL)
    // e procuramos tanto no nome quanto na categoria.
    $likeTerm = '%' . $searchTerm . '%';
    $stmt = $pdo->prepare('SELECT id, name, price, stock, category FROM products WHERE name LIKE ? OR category LIKE ? ORDER BY name');
    $stmt->execute([$likeTerm, $likeTerm]);
    return $stmt->fetchAll();
}

function insertProduct(PDO $pdo, array $productData): array
{
    $stmt = $pdo->prepare('INSERT INTO products (name, price, stock, category) VALUES (?, ?, ?, ?)');
    $stmt->execute([
        $productData['name'],
        $productData['price'],
        $productData['stock'],
        $productData['category'],
    ]);

    $id = $pdo->lastInsertId();

    return findProductById($pdo, (int) $id);
}

function updateProduct(PDO $pdo, int $id, array $fields): ?array
{
    $setClauses = [];
    $params = [];
    foreach ($fields as $key => $value) {
        $setClauses[] = "$key = ?";
        $params[] = $value;
    }
    $params[] = $id;

    $sql = 'UPDATE products SET ' . implode(', ', $setClauses) . ' WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return findProductById($pdo, $id);
}

function deleteProduct(PDO $pdo, int $id): ?array
{
    $product = findProductById($pdo, $id);

    if ($product === null) {
        return null;
    }

    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$id]);

    return $product;
}