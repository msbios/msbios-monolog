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
 * Class LoggerRenderErrorListener
 * @package MSBios\Monolog\Listener
 */
class LoggerRenderErrorListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @param EventInterface $e
     */
    public function onRenderError(EventInterface $e)
    {
        /** @var string $error */
        $error = $e->getError();

        if (! $error) {
            return;
        }

        $this->getLogger()->error(
            $e->getParam('exception')->getMessage()
        );
    }
}
