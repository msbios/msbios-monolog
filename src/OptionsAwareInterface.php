<?php
/**
 * @access protected
 * @author Jduzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

/**
 * Interface OptionsAwareInterface
 * @package MSBios\Monolog
 */
interface OptionsAwareInterface
{
    /**
     * @return mixed
     */
    public function getOptions();

    /**
     * @param array $options
     * @return mixed
     */
    public function setOptions(array $options);
}
