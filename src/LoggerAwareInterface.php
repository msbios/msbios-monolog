<?php
/**
 * @access protected
 * @author Jduzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Monolog;

use Psr\Log\LoggerInterface;

/**
 * Interface LoggerInterface
 * @package MSBios\Monolog
 */
interface LoggerAwareInterface
{
    /**
     * @return LoggerInterface
     */
    public function getLogger();

    /**
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger);
}
