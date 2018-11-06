<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog\Listener;

use MSBios\Monolog\LoggerAwareInterface;
use MSBios\Monolog\LoggerAwareTrait;
use Zend\EventManager\EventInterface;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;

/**
 * Class LogDispatchErrorListener
 * @package MSBios\Monolog\Listener
 */
class LoggerDispatchErrorListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @param EventInterface|MvcEvent $event
     */
    public function onDispatchError(EventInterface $event)
    {
        if (! $event->isError() || Application::ERROR_EXCEPTION !== $event->getError()) {
            return;
        }

        /** @var \Exception $exception */
        $exception = $event->getParam('exception');
        $this->getLogger()
            ->error($exception->getTraceAsString());
    }
}
