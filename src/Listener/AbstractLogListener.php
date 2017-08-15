<?php
/**
 * @access protected
 * @author JUdzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog\Listener;

use Monolog\Logger;
use Zend\Config\Config;

/**
 * Class AbstractLoggerListener
 * @package MSBios\Monolog\Listener
 */
abstract class AbstractLogListener
{
    /** @var Logger */
    private $logger;

    /** @var Config */
    private $options;

    /**
     * AbstractLoggerListener constructor.
     * @param Logger $logger
     * @param Config $options
     */
    public function __construct(Logger $logger, Config $options)
    {
        $this->logger = $logger;
        $this->options = $options;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return Config
     */
    public function getOptions()
    {
        return $this->options;
    }
}
