<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog\Initializer;

use Interop\Container\ContainerInterface;
use MSBios\Monolog\LoggerAwareInterface;
use MSBios\Monolog\LoggerManager;
use MSBios\Monolog\Module;
use MSBios\Monolog\OptionsAwareInterface;
use Zend\Config\Config;
use Zend\ServiceManager\Initializer\InitializerInterface;

/**
 * Class LoggerInitializer
 * @package MSBios\Monolog\Initializer
 */
class LoggerInitializer implements InitializerInterface
{
    /**
     * @param ContainerInterface $container
     * @param object $instance
     */
    public function __invoke(ContainerInterface $container, $instance)
    {
        if (! $instance instanceof LoggerAwareInterface) {
            return;
        }

        /** @var LoggerManager $loggerManager */
        $loggerManager = $container->get(LoggerManager::class);

        /** @var Config $options */
        $options = $container->get(Module::class);

        /** @var string $identifier */
        $identifier = get_class($instance);

        $instance->setLogger(
            $loggerManager->get($identifier)
        );

        if ($instance instanceof OptionsAwareInterface) {
            $instance->setOptions(
                $options['loggers'][$identifier]['options']
            );
        }
    }

    /**
     * @param $an_array
     * @return LoggerInitializer
     */
    public static function __set_state($an_array)
    {
        return new self();
    }
}
