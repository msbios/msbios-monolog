<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * Interface LoggerManagerInterface
 * @package MSBios\Monolog
 */
interface LoggerManagerInterface
{
    /**
     * @param $key
     * @param array $options
     * @return mixed
     */
    public function initFormatter($key, array $options);

    /**
     * @param $key
     * @param FormatterInterface $formatter
     * @return $this
     */
    public function addFormatter($key, FormatterInterface $formatter);

    /**
     * @param $key
     * @return FormatterInterface
     */
    public function getFormatter($key);

    /**
     * @param $key
     * @param array $options
     * @return mixed
     */
    public function initHandler($key, array $options);

    /**
     * @param $key
     * @param HandlerInterface $handler
     * @return $this
     */
    public function addHandler($key, HandlerInterface $handler);

    /**
     * @param $key
     * @return mixed
     */
    public function getHandler($key);

    /**
     * @param $key
     * @param array $options
     * @return mixed
     */
    public function init($key, array $options);

    /**
     * @param $key
     * @param LoggerInterface $logger
     * @return $this
     */
    public function add($key, LoggerInterface $logger);

    /**
     * @param $key
     * @return LoggerInterface
     */
    public function get($key);
}
