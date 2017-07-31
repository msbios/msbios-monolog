<?php
/**
 * @access protected
 * @author JUdzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog\Listener;

use Monolog\Logger;
use MSBios\Monolog\Config\Config;
use Zend\EventManager\AbstractListenerAggregate as DefaultAbstractListenerAggregate;

/**
 * Class AbstractListenerAggregate
 * @package MSBios\Monolog\Listener
 */
abstract class AbstractListenerAggregate extends DefaultAbstractListenerAggregate
{
    /** @var Logger */
    protected $logger;

    /** @var Config */
    protected $options;

    /**
     * AbstractListenerAggregate constructor.
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
    protected function getLogger()
    {
        return $this->logger;
    }
}
