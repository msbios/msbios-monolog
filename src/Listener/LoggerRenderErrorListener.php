<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog\Listener;

use MSBios\Monolog\LoggerAwareInterface;
use MSBios\Monolog\LoggerAwareTrait;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;

/**
 * Class LoggerRenderErrorListener
 * @package MSBios\Monolog\Listener
 * @deprecated
 */
class LoggerRenderErrorListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @param EventInterface|MvcEvent $e
     */
    public function onRenderError(EventInterface $e)
    {
        if (! $e->isError()) {
            return;
        }

        $this->getLogger()->error(
            $e->getParam('exception')->getMessage()
        );
    }
}
