<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Monolog;

return [

    'service_manager' => [
        'factories' => [
            Module::class => Factory\ModelFactory::class
        ]
    ],

    Module::class => [
        Config\Config::LISTENERS => [
            Listener\CheckSlowResponseTimeListener::class => [
                'enabled' => false,
                'logger' => Logger\SlowResponseTimeInterface::class,
                'threshold' => 400
            ],
            Listener\LogDispatchErrorListener::class => [
                'enabled' => false,
                'logger' => Logger\DispatchErrorInterface::class
            ],
            Listener\LogMemoryUsageListener::class => [
                'enabled' => false,
                'logger' => Logger\DefaultLoggerInterface::class,
                'type' => 1
            ],
            Listener\LogRenderErrorListener::class => [
                'enabled' => false,
                'logger' => Logger\RenderErrorInterface::class
            ],
        ],
        'loggers' => [
            Logger\DefaultLoggerInterface::class => [
                'handlers' => [
                    Handler\DefaultHandlerInterface::class
                ],
                'processors' => [
                    \Monolog\Processor\WebProcessor::class,
                    \Monolog\Processor\PsrLogMessageProcessor::class
                ],
            ],
            Logger\DispatchErrorInterface::class => [
                'handlers' => [
                    Handler\DispatchErrorInterface::class
                ],
                'processors' => [
                    \Monolog\Processor\WebProcessor::class,
                    \Monolog\Processor\PsrLogMessageProcessor::class
                ],
            ],
            Logger\RenderErrorInterface::class => [
                'handlers' => [
                    Handler\RenderErrorInterface::class
                ],
                'processors' => [
                    \Monolog\Processor\WebProcessor::class,
                    \Monolog\Processor\PsrLogMessageProcessor::class
                ],
            ],
            Logger\SlowResponseTimeInterface::class => [
                'handlers' => [
                    Handler\SlowResponseTimeInterface::class
                ],
                'processors' => [
                    \Monolog\Processor\WebProcessor::class,
                    \Monolog\Processor\PsrLogMessageProcessor::class
                ],
            ],
        ],
        'handlers' => [
            Handler\DefaultHandlerInterface::class => [
                'class' => \Monolog\Handler\StreamHandler::class,
                'args' => [
                    'stream' => './data/logs/monolog/default.handler.log'
                ],
                'formatter' => Formatter\SlowResponseTimeInterface::class
            ],
            Handler\DispatchErrorInterface::class => [
                'class' => \Monolog\Handler\StreamHandler::class,
                'args' => [
                    'stream' => './data/logs/monolog/dispatch.error.handler.log'
                ],
                'formatter' => Formatter\DefaultFormatterInterface::class
            ],
            Handler\RenderErrorInterface::class => [
                'class' => \Monolog\Handler\StreamHandler::class,
                'args' => [
                    'stream' => './data/logs/monolog/render.error.handler.log'
                ],
                'formatter' => Formatter\DefaultFormatterInterface::class
            ],
            Handler\SlowResponseTimeInterface::class => [
                'class' => \Monolog\Handler\StreamHandler::class,
                'args' => [
                    'stream' => './data/logs/monolog/slow.response.handler.log'
                ],
                'formatter' => Formatter\SlowResponseTimeInterface::class
            ]
        ],
        'formatters' => [
            Formatter\DefaultFormatterInterface::class => [
                'class' => \Monolog\Formatter\LineFormatter::class,
                'args' => [
                    'format' => "%datetime% - %channel% - %message% \n%extra% \n",
                ],
            ],
            Formatter\SlowResponseTimeInterface::class => [
                'class' => \Monolog\Formatter\LineFormatter::class,
                'args' => [
                    'format' => "%datetime% - %channel% - %message% \n%extra% \n",
                ],
            ]
        ]
    ]
];
