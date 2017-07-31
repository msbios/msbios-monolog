<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog\Listener;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

/**
 * Class LogMemoryUsageListener
 * @package MSBios\Monolog\Listener
 */
class LogDispatchErrorListener extends AbstractListenerAggregate
{
    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     * @param int $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'onDispatchError'], $priority);
    }

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
