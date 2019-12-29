<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

use Zend\Stdlib\ArrayUtils;

/**
 * Class Module
 * @package MSBios\Monolog
 * @link https://github.com/gdpro/gdpro-monolog
 */
class Module extends \MSBios\Module
{
    /** @const VERSION */
    const VERSION = '1.0.7';

    /** @const ENABLED */
    const ENABLED = 'enabled';

    /**
     * @inheritdoc
     *
     * @return string
     */
    protected function getDir()
    {
        return __DIR__;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    protected function getNamespace()
    {
        return __NAMESPACE__;
    }

    /**
     * @inheritdoc
     *
     * @return array|mixed|\Traversable
     */
    public function getConfig()
    {
        return ArrayUtils::merge(parent::getConfig(), [
            'service_manager' => (new ConfigProvider)->getDependencyConfig(),
            'listeners' => [
                ListenerAggregate::class =>
                    ListenerAggregate::class
            ]
        ]);
    }
}
