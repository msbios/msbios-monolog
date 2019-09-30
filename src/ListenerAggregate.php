<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

use MSBios\Exception\DomainException;
use MSBios\Exception\Exception;
use Psr\Log\LoggerInterface;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;

/**
 * Class ListenerAggregate
 * @package MSBios\Monolog
 */
class ListenerAggregate extends AbstractListenerAggregate implements
    LoggerAwareInterface,
    OptionsAwareInterface
{
    use LoggerAwareTrait;
    use OptionsAwareTrait;

    /** @var integer */
    private $startTime;

    /**
     * ListenerAggregate constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->setLogger($logger);
        $this->startTime = microtime(true);
    }

    /**
     * @inheritdoc
     *
     * @param EventManagerInterface $events
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 100)
    {
        $this->listeners[] = $events
            ->attach(MvcEvent::EVENT_FINISH, [$this, 'onFinish'], $priority);
    }

    /**
     * @param EventInterface $e
     */
    public function onFinish(EventInterface $e)
    {
        if ($e->isError()) {
            return;
        }

        /** @var integer $elapsedTime */
        $elapsedTime = (microtime(true) - $this->startTime()) * 1000;

        if ($elapsedTime > $this->getOptions()['threshold']) {

            try {
                $this
                    ->getLogger()
                    ->info(sprintf("%.0fms", $elapsedTime));
            } catch (Exception $e) {
                throw new DomainException(sprintf(
                    "An Exception happenned while logging message for %s on action %s",
                    __CLASS__, __METHOD__
                ), Response::STATUS_CODE_500, $e);
            }
        }
    }

    /**
     * @param EventInterface $e
     */
    public function onDispatchError(EventInterface $e)
    {
        if (! $e->isError() || Application::ERROR_EXCEPTION !== $e->getError()) {
            return;
        }

        $this->getLogger()->error(
            $e->getParam('exception')->getTraceAsString()
        );
    }

    /**
     * @param EventInterface $e
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