<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Class LoggerManager
 * @package MSBios\Monolog
 */
class LoggerManager implements LoggerManagerInterface
{
    /** @var FormatterInterface[] */
    protected $formatters = [];

    /** @var HandlerInterface[] */
    protected $handlers = [];

    /** @var LoggerInterface[] */
    protected $loggers = [];

    /**
     * @param array $options
     * @return object
     * @throws \ReflectionException
     */
    protected function factory(array $options)
    {
        /** @var \ReflectionClass $reflection */
        $reflection = new \ReflectionClass($options['class']);
        return $reflection->newInstanceArgs($options['args']);
    }

    /**
     * @param $key
     * @param array $options
     * @return mixed|LoggerManager
     * @throws \ReflectionException
     */
    public function initFormatter($key, array $options)
    {
        /** @var FormatterInterface $formatter */
        $formatter = $this->factory($options);
        return $this->addFormatter($key, $formatter);
    }

    /**
     * @param $key
     * @param FormatterInterface $formatter
     * @return $this|LoggerManagerInterface
     */
    public function addFormatter($key, FormatterInterface $formatter)
    {
        $this->formatters[$key] = $formatter;
        return $this;
    }

    /**
     * @param $key
     * @return FormatterInterface
     */
    public function getFormatter($key)
    {
        return $this->formatters[$key];
    }

    /**
     * @param $key
     * @param array $options
     * @return mixed|LoggerManager
     * @throws \ReflectionException
     */
    public function initHandler($key, array $options)
    {
        /** @var HandlerInterface $handler */
        $handler = $this->factory($options);

        $handler->setFormatter(
            $this->getFormatter($options['formatter'])
        );

        return $this->addHandler($key, $handler);
    }

    /**
     * @param $key
     * @param HandlerInterface $handler
     * @return $this|LoggerManagerInterface
     */
    public function addHandler($key, HandlerInterface $handler)
    {
        $this->handlers[$key] = $handler;
        return $this;
    }

    /**
     * @param $key
     * @return mixed|HandlerInterface
     */
    public function getHandler($key)
    {
        return $this->handlers[$key];
    }

    /**
     * @param $key
     * @param array $options
     * @return mixed|LoggerManager
     */
    public function init($key, array $options)
    {
        /** @var LoggerInterface $logger */
        $logger = new Logger($key);

        /** @var string $handler */
        foreach ($options['handlers'] as $handler) {
            $logger->pushHandler(
                $this->getHandler($handler)
            );
        }

        /** @var string $processor */
        foreach ($options['processors'] as $processor) {
            $logger->pushProcessor(new $processor());
        }

        return $this->add($key, $logger);
    }

    /**
     * @param $key
     * @param LoggerInterface $logger
     * @return $this|LoggerManagerInterface
     */
    public function add($key, LoggerInterface $logger)
    {
        $this->loggers[$key] = $logger;
        return $this;
    }

    /**
     * @param $key
     * @return LoggerInterface
     */
    public function get($key)
    {
        return $this->loggers[$key];
    }
}
