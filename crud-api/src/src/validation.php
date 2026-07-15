<?php

function validateRequiredFields(array $input, array $fields): ?string
{
    $missing = [];

    foreach ($fields as $field) {
        if (!isset($input[$field])) {
            $missing[] = $field;
        }
    }

    if (!empty($missing)) {
        return implode(', ', $missing) . ' are required';
    }

    return null;
}

function validateProductFields(array $input): ?string
{
    if (isset($input['name'])) {
        $name = trim($input['name']);

        if ($name === '') {
            return 'Name cannot be empty';
        }

        if (strlen($name) > 100) {
            return 'Name must be at most 100 characters';
        }
    }

    if (isset($input['price'])) {
        if (!is_numeric($input['price'])) {
            return 'Price must be a number';
        }

        $price = (float) $input['price'];

        if ($price < 0) {
            return 'Price cannot be negative';
        }
    }

    if (isset($input['stock'])) {
        if (!is_numeric($input['stock']) || floor($input['stock']) != $input['stock'] || $input['stock'] < 0) {
            return 'Stock must be a non-negative integer.';
        }
    }

    if (isset($input['category'])) {
        $category = trim($input['category']);

        if ($category === '') {
            return 'Category cannot be empty';
        }

        if (strlen($category) > 100) {
            return 'Category must be at most 100 characters';
        }
    }

    return null;
}