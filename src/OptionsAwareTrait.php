<?php
/**
 * @access protected
 * @author Jduzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

use Zend\Config\Config;

/**
 * Trait OptionsAwareTrait
 * @package MSBios\Monolog
 */
trait OptionsAwareTrait
{
    /** @var array */
    protected $options;

    /**
     * @return Config
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }
}
