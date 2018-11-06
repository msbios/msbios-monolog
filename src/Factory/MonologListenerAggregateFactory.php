<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Monolog\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Monolog\Module;
use MSBios\Monolog\MonologListenerAggregate;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class MonologListenerAggregateFactory
 * @package MSBios\Monolog\Factory
 */
class MonologListenerAggregateFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return MonologListenerAggregate|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var array $listeners */
        $listeners = $container->get(Module::class)['listeners'];
        return new MonologListenerAggregate($listeners, $container);
    }
}
