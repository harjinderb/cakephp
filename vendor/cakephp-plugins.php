<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'ADmad/JwtAuth' => $baseDir . '/vendor/admad/cakephp-jwt-auth/',
        'Acl' => $baseDir . '/vendor/cakephp/acl/',
        'AclManager' => $baseDir . '/vendor/ivanamat/cakephp3-aclmanager/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'CakeMonga' => $baseDir . '/vendor/lewestopher/cakephp-monga/',
        'CakePdf' => $baseDir . '/vendor/friendsofcake/cakepdf/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Josegonzalez/Upload' => $baseDir . '/vendor/josegonzalez/cakephp-upload/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'WyriHaximus/TwigView' => $baseDir . '/vendor/wyrihaximus/twig-view/',
        'jwtTokenComponent' => $baseDir . '/plugins/jwtTokenComponent/'
    ]
];