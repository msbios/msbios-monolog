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
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\Mvc\Application;
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
        /** @var Application $target */
        $target = $e->getTarget();

        /** @var ServiceLocatorInterface $serviceManager */
        $serviceManager = $target->getServiceManager();

        /** @var Config $config */
        $config = $serviceManager->get(self::class);

        /**
         * @var string $className
         * @var Config $listenerArgs
         */
        foreach ($config->get('listeners') as $className => $listenerArgs) {
            if (! $listenerArgs->get(self::ENABLED, false)) {
                continue;
            }

            /** @var Logger $logger */
            $logger = new Logger($className);

            /** @var Config $loggerData */
            $loggerData = $config->getLoggers()
                ->get($listenerArgs->get('logger'));

            /** @var string $handlerName */
            foreach ($loggerData->get('handlers') as $handlerName) {

                /** @var Config $handlersData */
                $handlersData = $config->getHandlers()
                    ->get($handlerName);

                /** @var HandlerInterface $handler */
                $handler = (new \ReflectionClass($handlersData->get('class')))->newInstanceArgs(
                    $handlersData->get('args')->toArray()
                );

                /** @var Config $formatterData */
                $formatterData = $config->getFormatters()
                    ->get($handlersData->get('formatter'));

                /** @var FormatterInterface $formatter */
                $formatter = (new \ReflectionClass($formatterData->get('class')))->newInstanceArgs(
                    $formatterData->get('args')->toArray()
                );

                $handler->setFormatter($formatter);
                $logger->pushHandler($handler);
            }

            /** @var string $processorName */
            foreach ($loggerData->get('processors') as $processorName) {
                $logger->pushProcessor(new $processorName());
            }

            /** @var AbstractListenerAggregate $listenerAggregate */
            $listenerAggregate = new $className($logger, $listenerArgs);

            if ($listenerAggregate instanceof AbstractListenerAggregate) {
                $listenerAggregate->attach($target->getEventManager());
            }
        }
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
