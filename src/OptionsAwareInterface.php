<?php
/**
 * @access protected
 * @author Jduzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

use Zend\Config\Config;

/**
 * Interface OptionsAwareInterface
 * @package MSBios\Monolog
 */
interface OptionsAwareInterface
{
    /**
     * @return Config
     */
    public function getOptions();

    /**
     * @param Config $options
     * @return $this
     */
    public function setOptions(Config $options);
}