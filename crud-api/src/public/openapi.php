<?php

$openApiSpec = [
    "openapi" => "3.0.0",
    "info" => [
        "title" => "Product CRUD API",
        "version" => "1.0.0",
        "description" => "A simple API to manage products (Create, Read, Update, Delete)."
    ],
    "servers" => [
        [
            "url" => "http://localhost:8000",
            "description" => "Development Server"
        ]
    ],
    "paths" => [
        "/api/products" => [
            "get" => [
                "summary" => "List all products",
                "description" => "Returns an array of all registered products.",
                "parameters" => [
                    [
                        "name" => "search",
                        "in" => "query",
                        "description" => "Term to search in product name or category.",
                        "required" => false,
                        "schema" => ["type" => "string"]
                    ]
                ],
                "tags" => ["Products"],
                "responses" => [
                    "200" => [
                        "description" => "Success",
                        "content" => [
                            "application/json" => [
                                "schema" => [
                                    "type" => "object",
                                    "properties" => [
                                        "products" => [
                                            "type" => "array",
                                            "items" => [
                                                '$ref' => '#/components/schemas/Product'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "post" => [
                "summary" => "Create a new product",
                "tags" => ["Products"],
                "requestBody" => [
                    "required" => true,
                    "content" => [
                        "application/json" => [
                            "schema" => [
                                '$ref' => '#/components/schemas/ProductInput'
                            ]
                        ]
                    ]
                ],
                "responses" => [
                    "201" => [
                        "description" => "Product created successfully",
                        "content" => [
                            "application/json" => [
                                "schema" => [
                                    '$ref' => '#/components/schemas/Product'
                                ]
                            ]
                        ]
                    ],
                    "400" => ["description" => "Invalid data"]
                ]
            ]
        ],
        "/api/products?id={id}" => [
            "parameters" => [
                [
                    "name" => "id",
                    "in" => "query",
                    "required" => true,
                    "description" => "Product ID",
                    "schema" => [
                        "type" => "integer"
                    ]
                ]
            ],
            "put" => [
                "summary" => "Update a product (full update)",
                "tags" => ["Products"],
                "requestBody" => [
                    "required" => true,
                    "content" => [
                        "application/json" => [
                            "schema" => [
                                '$ref' => '#/components/schemas/ProductInput'
                            ]
                        ]
                    ]
                ],
                "responses" => [
                    "200" => ["description" => "Product updated"],
                    "400" => ["description" => "Invalid data"],
                    "404" => ["description" => "Product not found"]
                ]
            ],
            "delete" => [
                "summary" => "Delete a product",
                "tags" => ["Products"],
                "responses" => [
                    "200" => ["description" => "Product deleted"],
                    "404" => ["description" => "Product not found"]
                ]
            ]
            // PATCH can be added here as well
        ]
    ],
    "components" => [
        "schemas" => [
            "Product" => [
                "type" => "object",
                "properties" => [
                    "id" => ["type" => "integer", "example" => 1],
                    "name" => ["type" => "string", "example" => "Laptop"],
                    "price" => ["type" => "number", "format" => "float", "example" => 1200.50],
                    "stock" => ["type" => "integer", "example" => 50],
                    "category" => ["type" => "string", "example" => "Electronics"]
                ]
            ],
            "ProductInput" => [
                "type" => "object",
                "properties" => [
                    "name" => ["type" => "string", "example" => "Laptop"],
                    "price" => ["type" => "number", "format" => "float", "example" => 1200.50],
                    "stock" => ["type" => "integer", "example" => 50],
                    "category" => ["type" => "string", "example" => "Electronics"]
                ],
                "required" => ["name", "price", "stock", "category"]
            ]
        ]
    ]
];

file_put_contents(__DIR__ . '/../openapi.json', json_encode($openApiSpec, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));