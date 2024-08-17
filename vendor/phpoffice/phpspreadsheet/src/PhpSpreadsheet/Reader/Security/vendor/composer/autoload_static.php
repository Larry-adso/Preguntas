<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf3c3d2082722f6a603ad0b42708af25f
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Larrygarcia\\Security\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Larrygarcia\\Security\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf3c3d2082722f6a603ad0b42708af25f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf3c3d2082722f6a603ad0b42708af25f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf3c3d2082722f6a603ad0b42708af25f::$classMap;

        }, null, ClassLoader::class);
    }
}
