<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit5db7e2e9de99699aaf3c76607520a2df
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

        spl_autoload_register(array('ComposerAutoloaderInit5db7e2e9de99699aaf3c76607520a2df', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit5db7e2e9de99699aaf3c76607520a2df', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit5db7e2e9de99699aaf3c76607520a2df::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
