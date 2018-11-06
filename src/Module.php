<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

use MSBios\ModuleInterface;
use MSBios\Monolog\Initializer\LoggerInitializer;
use Psr\Log\LoggerInterface;
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Class Module
 * @package MSBios\Monolog
 * @link https://github.com/gdpro/gdpro-monolog
 */
class Module implements
    ModuleInterface,
    ServiceProviderInterface,
    AutoloaderProviderInterface
{
    /** @const VERSION */
    const VERSION = '1.0.5';

    /** @const ENABLED */
    const ENABLED = 'enabled';

    /**
     * @return array|mixed|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            AutoloaderFactory::STANDARD_AUTOLOADER => [
                StandardAutoloader::LOAD_NS => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                LoggerInterface::class => function () {
                    return self::class; // Placeholder name
                }
            ],
            'initializers' => [
                new LoggerInitializer
            ]
        ];
    }
}
