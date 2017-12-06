<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

return [

    Module::class => [
        'loggers' => [
            Listener\CheckSlowResponseTimeListener::class => [
                'handlers' => [
                    Handler\SlowResponseTimeInterface::class
                ],
                'processors' => [
                    \Monolog\Processor\WebProcessor::class,
                    \Monolog\Processor\PsrLogMessageProcessor::class
                ],
                'options' => [
                    'enabled' => true,
                    'threshold' => -1
                ]
            ],
        ],
    ]
];
