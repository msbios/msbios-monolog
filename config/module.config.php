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
                    'threshold' => 400
                ]
            ],
            Listener\LoggerDispatchErrorListener::class => [
                'handlers' => [
                    Handler\DispatchErrorInterface::class
                ],
                'processors' => [
                    \Monolog\Processor\WebProcessor::class,
                    \Monolog\Processor\PsrLogMessageProcessor::class
                ],
                'options' => [
                    'enabled' => true
                ]
            ],
            Listener\LoggerRenderErrorListener::class => [
                'handlers' => [
                    Handler\RenderErrorInterface::class
                ],
                'processors' => [
                    \Monolog\Processor\WebProcessor::class,
                    \Monolog\Processor\PsrLogMessageProcessor::class
                ],
                'options' => [
                    'enabled' => true
                ]
            ],
        ],

        'handlers' => [
            // Default
            Handler\DefaultHandlerInterface::class => [
                'class' => \Monolog\Handler\StreamHandler::class,
                'args' => [
                    'stream' => './data/logs/default.handler.log'
                ],
                'formatter' => \Monolog\Formatter\LineFormatter::class
            ],

            Handler\DispatchErrorInterface::class => [
                'class' => \Monolog\Handler\StreamHandler::class,
                'args' => [
                    'stream' => './data/logs/dispatch.error.handler.log'
                ],
                'formatter' => \Monolog\Formatter\LineFormatter::class
            ],
            Handler\RenderErrorInterface::class => [
                'class' => \Monolog\Handler\StreamHandler::class,
                'args' => [
                    'stream' => './data/logs/render.error.handler.log'
                ],
                'formatter' => \Monolog\Formatter\LineFormatter::class
            ],
            Handler\SlowResponseTimeInterface::class => [
                'class' => \Monolog\Handler\StreamHandler::class,
                'args' => [
                    'stream' => './data/logs/slow.response.handler.log'
                ],
                'formatter' => \Monolog\Formatter\LineFormatter::class
            ]
        ],

        'formatters' => [
            \Monolog\Formatter\LineFormatter::class => [
                'class' => \Monolog\Formatter\LineFormatter::class,
                'args' => [
                    'format' => "%datetime% - %channel% - %message% \n%extra% \n",
                ],
            ]
        ]
    ],
];
