<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitce30bfcc8cb91572fa1e1f0fbad4f0d8
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mathaus\\LaravelFastApi\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mathaus\\LaravelFastApi\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitce30bfcc8cb91572fa1e1f0fbad4f0d8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitce30bfcc8cb91572fa1e1f0fbad4f0d8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitce30bfcc8cb91572fa1e1f0fbad4f0d8::$classMap;

        }, null, ClassLoader::class);
    }
}
