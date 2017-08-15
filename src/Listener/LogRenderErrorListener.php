<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog\Listener;

use Zend\EventManager\EventInterface;

/**
 * Class LogRenderErrorListener
 * @package MSBios\Monolog\Listener
 */
class LogRenderErrorListener extends AbstractLogListener
{
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

        $this->getLogger()->error($message);
    }
}
