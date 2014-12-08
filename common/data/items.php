<?php
return [
    'isObjectOwner' => [
        'type' => 2,
        'description' => 'Is the user the owner of the object?',
        'ruleName' => 'ObjectOwner',
    ],
    'user' => [
        'type' => 1,
        'description' => 'User',
        'ruleName' => 'UserRole',
        'children' => [
            'isObjectOwner',
        ],
    ],
    'anonymous' => [
        'type' => 1,
        'description' => 'Anonymous User',
        'ruleName' => 'UserRole',
        'children' => [
            'user',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Administrator',
        'ruleName' => 'UserRole',
        'children' => [
            'user',
        ],
    ],
];
