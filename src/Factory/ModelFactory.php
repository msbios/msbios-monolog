<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Monolog\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Monolog\Config\Config;
use MSBios\Monolog\Module;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ModelFactory
 * @package MSBios\Monolog\Factory
 */
class ModelFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return Config
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Config($container->get('config')[Module::class]);
    }
}
