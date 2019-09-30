<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Monolog\Listener;

use MSBios\Monolog\Exception\Exception;
use Zend\EventManager\EventInterface;

/**
 * Class CheckSlowResponseTimeListener
 * @package MSBios\Monolog\Listeners
 * @deprecated
 */
class CheckSlowResponseTimeListener extends AbstractTimemableListener
{
    /** @const THRESHOLD */
    const THRESHOLD = 'threshold';

    /**
     * @param EventInterface $e
     * @return mixed|void
     * @throws Exception
     */
    public function onFinish(EventInterface $e)
    {
        if ($e->isError()) {
            return;
        }

        /** @var integer $elapsedTime */
        $elapsedTime = (microtime(true) - $this->getStartTime()) * 1000;
        if ($elapsedTime > $this->getOptions()[self::THRESHOLD]) {
            try {
                $this->getLogger()->info(sprintf("%.0fms", $elapsedTime));
            } catch (\Exception $e) {
                throw new Exception(
                    'An Exception happenned while logging message for CheckSlowRespondTimeListener on action onFinish',
                    500,
                    $e
                );
            }
        }
    }
}
