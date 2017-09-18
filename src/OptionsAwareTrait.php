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
    /** @var Config */
    protected $options;

    /**
     * @return Config
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param Config $options
     * @return $this
     */
    public function setOptions(Config $options)
    {
        $this->options = $options;
        return $this;
    }
}
