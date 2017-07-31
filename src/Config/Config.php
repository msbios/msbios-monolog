<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Monolog\Config;

use Zend\Config\Config as DefaultConfig;

/**
 * Class Config
 * @package MSBios\Monolog\Config
 */
class Config extends DefaultConfig
{
    /** @const FORMATTERS */
    const FORMATTERS = 'formatters';

    /** @const HANDLERS */
    const HANDLERS = 'handlers';

    /** @const LISTENERS */
    const LISTENERS = 'listeners';

    /** @const LOGGERS */
    const LOGGERS = 'loggers';

    /**
     * @return mixed
     */
    public function getFormatters()
    {
        return $this->get(self::FORMATTERS);
    }

    /**
     * @return mixed
     */
    public function getHandlers()
    {
        return $this->get(self::HANDLERS);
    }

    /**
     * @return mixed
     */
    public function getListeners()
    {
        return $this->get(self::LISTENERS);
    }

    /**
     * @return mixed
     */
    public function getLoggers()
    {
        return $this->get(self::LOGGERS);
    }
}
