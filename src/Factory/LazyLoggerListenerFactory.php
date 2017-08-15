<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog\Factory;

use Interop\Container\ContainerInterface;
use Monolog\Formatter\FormatterInterface;
use Monolog\Logger;
use MSBios\Monolog\Handler\HandlerInterface;
use MSBios\Monolog\Logger\LoggerInterface;
use MSBios\Monolog\Module;
use Zend\Config\Config;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class LazyLoggerListenerFactory
 * @package MSBios\Monolog\Factory
 */
class LazyLoggerListenerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $loggerData
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $loggerData = null)
    {
        /** @var LoggerInterface $logger */
        $logger = new Logger($requestedName);

        /** @var Config $options */
        $options = $container->get(Module::class);

        /** @var Config $loggerData */
        $loggerData = $options
            ->get('loggers')
            ->get($requestedName);

        /** @var string $handlerName */
        foreach ($loggerData->get('handlers') as $handlerName) {

            /** @var Config $handlersData */
            $handlersData = $options->get('handlers')
                ->get($handlerName);

            /** @var HandlerInterface $handler */
            $handler = (new \ReflectionClass($handlersData->get('class')))->newInstanceArgs(
                $handlersData->get('args')->toArray()
            );

            /** @var Config $formatterData */
            $formatterData = $options->get('formatters')
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

        return new $requestedName($logger, $loggerData);
    }
}