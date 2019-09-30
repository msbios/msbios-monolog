<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Monolog\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Monolog\LoggerManager;
use MSBios\Monolog\Module;
use MSBios\Stdlib\ArrayCollection;
use Zend\Config\Config;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class LoggerManagerFactory
 * @package MSBios\Monolog\Factory
 */
class LoggerManagerFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return LoggerManager|object
     * @throws \ReflectionException
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // $collection = new ArrayCollection;
        // $collection->put($key, $value);

        /** @var LoggerManager $loggerManager */
        $loggerManager = new LoggerManager;

        /** @var Config $options */
        $options = $container->get(Module::class);

        /**
         * @var string $key
         * @var Config $config
         */
        foreach ($options['formatters'] as $key => $config) {
            $loggerManager->initFormatter($key, $config);
        }

        /**
         * @var string $key
         * @var Config $config
         */
        foreach ($options['handlers'] as $key => $config) {
            $loggerManager->initHandler($key, $config);
        }

        /**
         * @var string $key
         * @var Config $config
         */
        foreach ($options['loggers'] as $key => $config) {
            $loggerManager->init($key, $config);
        }

        return $loggerManager;
    }
}
