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
 * Class LogRenderErrorListener
 * @package MSBios\Monolog\Listener
 */
class LogRenderErrorListener extends AbstractListenerAggregate
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
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'onRenderError'], $priority);
    }

    /**
     * @param EventInterface $event
     */
    public function onRenderError(EventInterface $event)
    {
        /** @var array $resultVariables */
        $resultVariables = $event->getResult()
            ->getVariables();

        /** @var string $message */
        $message = $resultVariables['exception']->getMessage();

        $this->logger->error($message);
    }
}
