<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog\Listener;

use MSBios\Monolog\LoggerAwareInterface;
use MSBios\Monolog\LoggerAwareTrait;
use Zend\EventManager\EventInterface;

/**
 * Class LogDispatchErrorListener
 * @package MSBios\Monolog\Listener
 */
class LoggerDispatchErrorListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @param EventInterface $event
     */
    public function onDispatchError(EventInterface $event)
    {
        /** @var \Exception $exception */
        $exception = $event->getParam('exception');

        if (! $exception instanceof \Exception) {
            return;
        }

        $this->getLogger()->error($exception->getTraceAsString());
    }
}
