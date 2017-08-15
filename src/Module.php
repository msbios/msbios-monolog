<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Logger;
use MSBios\ModuleInterface;
use MSBios\Monolog\Config\Config;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\LazyListenerAggregate;
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\Mvc\Application;
use Zend\Mvc\ApplicationInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Module
 * @package MSBios\Monolog
 * @link https://github.com/gdpro/gdpro-monolog
 */
class Module implements ModuleInterface, BootstrapListenerInterface, AutoloaderProviderInterface
{
    /** @const VERSION */
    const VERSION = '0.0.1';

    /** @var ENABLED */
    const ENABLED = 'enabled';

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Listen to the bootstrap event
     *
     * @param EventInterface $e
     * @return array
     */
    public function onBootstrap(EventInterface $e)
    {
        /** @var ApplicationInterface $target */
        $target = $e->getTarget();

        /** @var ServiceLocatorInterface $serviceManager */
        $serviceManager = $target->getServiceManager();

        (new LazyListenerAggregate(
            $serviceManager->get(self::class)->get('listeners')->toArray(),
            $serviceManager
        ))->attach($target->getEventManager());
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
}
