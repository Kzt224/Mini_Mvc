<?php

return [
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
        'name' => $_ENV['DB_NAME'] ?? 'xtocis',
        'user' => $_ENV['DB_USERNAME'] ?? 'root',
        'pass' => $_ENV['DB_PASSWORD'] ?? ''
    ]
];