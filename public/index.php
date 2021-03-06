<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Get plguins service for use in inline setup below
     */
    $di->getPlugins()->loadPlugins();

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    /**
     * Print the content of application
     */
    echo $application->handle($_SERVER['REQUEST_URI'])->getContent();


} catch (\Exception $e) {
    if (getenv('APP_DEBUG')) {
        // move this after calling $di Factory
        $debug = new \Phalcon\Debug();
        $debug->listen();

        echo $e->getMessage() . '<br>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    }else 
        echo $e->getMessage() . '<br>';
        exit('Error ! please contact support ! ');
}
