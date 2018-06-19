<?php
/**
 * Register application modules
 */

$application->registerModules(
    [
        'main'  => [
            'className' => 'Venus\Apps\Main\Module',
            'path'      => __DIR__ . '/../Apps/Main/Module.php'
        ],
        'desk' => [
            'className' => 'Venus\Apps\Desk\Module',
            'path'      => __DIR__ . '/../Apps/Desk/Module.php'
        ]
    ]
);

