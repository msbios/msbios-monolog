<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog\Listener;

use Zend\EventManager\EventInterface;

/**
 * Class LogDispatchErrorListener
 * @package MSBios\Monolog\Listener
 */
class LogDispatchErrorListener extends AbstractLogListener
{
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
