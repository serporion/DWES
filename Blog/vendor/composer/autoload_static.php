<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0da66a6f9bd7d2b677dfcd8f2849bd3d
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'src\\css\\' => 8,
        ),
        'S' => 
        array (
            'Services\\' => 9,
            'Serporion\\Blog\\' => 15,
        ),
        'R' => 
        array (
            'Repositories\\' => 13,
        ),
        'M' => 
        array (
            'Models\\' => 7,
        ),
        'L' => 
        array (
            'Lib\\' => 4,
        ),
        'C' => 
        array (
            'Controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'src\\css\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/css',
        ),
        'Services\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Services',
        ),
        'Serporion\\Blog\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
        'Repositories\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Repositories',
        ),
        'Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Models',
        ),
        'Lib\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Lib',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Controllers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Zebra_Pagination' => __DIR__ . '/..' . '/stefangabos/zebra_pagination/Zebra_Pagination.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0da66a6f9bd7d2b677dfcd8f2849bd3d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0da66a6f9bd7d2b677dfcd8f2849bd3d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0da66a6f9bd7d2b677dfcd8f2849bd3d::$classMap;

        }, null, ClassLoader::class);
    }
}