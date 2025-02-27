<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitc2ec774ca66e8b707bacdb3f781a26fd
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitc2ec774ca66e8b707bacdb3f781a26fd', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitc2ec774ca66e8b707bacdb3f781a26fd', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitc2ec774ca66e8b707bacdb3f781a26fd::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
