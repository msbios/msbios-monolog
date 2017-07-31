<?php
/**
 * @access protected
 * @author JUdzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Monolog\Listener;

use Monolog\Logger;
use MSBios\Monolog\Config\Config;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

/**
 * Class AbstractTimemableListenerAggregate
 * @package MSBios\Monolog\Listener
 */
abstract class AbstractTimemableListenerAggregate extends AbstractListenerAggregate
{
    /** @var integer */
    private $startTime;

    /**
     * AbstractTimemableListenerAggregate constructor.
     * @param Logger $logger
     * @param Config $options
     */
    public function __construct(Logger $logger, Config $options)
    {
        parent::__construct($logger, $options);
        $this->startTime = microtime(true);
    }

    /**
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param EventInterface $e
     * @return mixed
     */
    abstract public function onFinish(EventInterface $e);

    /**
     * @param EventManagerInterface $events
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_FINISH,
            [$this, 'onFinish'],
            $priority
        );
    }
}
