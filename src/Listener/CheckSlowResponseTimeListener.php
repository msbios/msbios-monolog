<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Monolog\Listener;

use MSBios\Monolog\Exception\LoggingException;
use Zend\EventManager\EventInterface;

/**
 * Class CheckSlowResponseTimeListener
 * @package MSBios\Monolog\Listeners
 */
class CheckSlowResponseTimeListener extends AbstractTimemableListenerAggregate
{
    /** @const THRESHOLD */
    const THRESHOLD = 'threshold';

    /**
     * @param EventInterface $e
     */
    public function onFinish(EventInterface $e)
    {
        /** @var integer $elapsedTime */
        $elapsedTime = (microtime(true) - $this->getStartTime()) * 1000;

        if ($elapsedTime > $this->options->get(self::THRESHOLD)) {
            try {
                $this->getLogger()->info(sprintf("%.0fms", $elapsedTime));
            } catch (\Exception $e) {
                throw new LoggingException(
                    'An Exception happenned while logging message for CheckSlowRespondTimeListener on action onFinish',
                    500,
                    $e
                );
            }
        }
    }
}
