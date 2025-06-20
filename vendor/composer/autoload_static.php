<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit03facffc6fcb8c959a2a569c78c97160
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'app\\Controller\\Cliente' => __DIR__ . '/../..' . '/app/Controller/Cliente.php',
        'app\\Controller\\OrdemServico' => __DIR__ . '/../..' . '/app/Controller/OrdemServico.php',
        'app\\Controller\\Usuario' => __DIR__ . '/../..' . '/app/Controller/Usuario.php',
        'app\\Models\\Database' => __DIR__ . '/../..' . '/app/Models/Database.php',
        'app\\Models\\Env' => __DIR__ . '/../..' . '/app/Models/Env.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit03facffc6fcb8c959a2a569c78c97160::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit03facffc6fcb8c959a2a569c78c97160::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit03facffc6fcb8c959a2a569c78c97160::$classMap;

        }, null, ClassLoader::class);
    }
}
