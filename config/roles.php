<?php

    return [

        [
            'id' => 1,
            "name" => [
            'en' => 'Admin',
            'mm' => 'အတ်မင်',
        ],
            'slug' => 'admin',
            'permissions' => [
                "result-view", "result-create", "result-edit", "result-detail", "result-delete", "result-action",
                "student-view", "student-create", "student-edit", "student-detail", "student-delete", "student-action",
            ],
            'level' => 0,
        ],

        [
            'id' => 2,
            "name" => [
            'en' => 'user',
            'mm' => 'user',
        ],
            'slug' => 'user',
            'level' => 1,
            'permissions' => [],
        ]
    ];