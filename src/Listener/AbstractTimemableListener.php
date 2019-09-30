<?php
/**
 * @access protected
 * @author JUdzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Monolog\Listener;

use MSBios\Monolog\LoggerAwareInterface;
use MSBios\Monolog\LoggerAwareTrait;
use MSBios\Monolog\OptionsAwareInterface;
use MSBios\Monolog\OptionsAwareTrait;
use Zend\EventManager\EventInterface;

/**
 * Class AbstractTimemableListener
 * @package MSBios\Monolog\Listener
 * @deprecated
 */
abstract class AbstractTimemableListener implements
    LoggerAwareInterface,
    OptionsAwareInterface
{
    use LoggerAwareTrait;
    use OptionsAwareTrait;

    /** @var integer */
    private $startTime;

    /**
     * AbstractTimemableListener constructor.
     */
    public function __construct()
    {
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
}
