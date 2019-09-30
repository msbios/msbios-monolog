<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

use Psr\Log\LoggerInterface;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * Class ConfigProvider
 * @package MSBios\Monolog
 */
class ConfigProvider extends \MSBios\ConfigProvider
{
    /**
     * @return array
     */
    public function getDependencyConfig(): array
    {
        return [
            'factories' => [
                LoggerInterface::class => function () {
                    return self::class; // Placeholder name
                },
                LoggerManager::class =>
                    Factory\LoggerManagerFactory::class,

                MonologListenerAggregate::class =>
                    Factory\MonologListenerAggregateFactory::class,

                // listeners
                Listener\CheckSlowResponseTimeListener::class =>
                    InvokableFactory::class,
                Listener\LoggerDispatchErrorListener::class =>
                    InvokableFactory::class,
                Listener\LoggerRenderErrorListener::class =>
                    InvokableFactory::class
            ]
        ];
    }

}