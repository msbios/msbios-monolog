<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

return [

    'service_manager' => [
        'invokables' => [

        ],
        'factories' => [
            Module::class => Factory\ModelFactory::class,

            // listeners
            Listener\CheckSlowResponseTimeListener::class =>
                Factory\LazyLoggerListenerFactory::class,
            Listener\LogDispatchErrorListener::class =>
                Factory\LazyLoggerListenerFactory::class,
            Listener\LogRenderErrorListener::class =>
                Factory\LazyLoggerListenerFactory::class
        ]
    ],

    Module::class => [
        'listeners' => [
            [
                'listener' => Listener\CheckSlowResponseTimeListener::class,
                'method' => 'onFinish',
                'event' => \Zend\Mvc\MvcEvent::EVENT_FINISH,
                'priority' => 100,
            ], [
                'listener' => Listener\LogDispatchErrorListener::class,
                'method' => 'onDispatchError',
                'event' => \Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR,
                'priority' => 100,
            ], [
                'listener' => Listener\LogRenderErrorListener::class,
                'method' => 'onRenderError',
                'event' => \Zend\Mvc\MvcEvent::EVENT_RENDER_ERROR,
                'priority' => 100,
            ],
        ],

        'loggers' => [
            Listener\CheckSlowResponseTimeListener::class => [
                'handlers' => [
                    Handler\SlowResponseTimeInterface::class
                ],
                'processors' => [
                    \Monolog\Processor\WebProcessor::class,
                    \Monolog\Processor\PsrLogMessageProcessor::class
                ],
                'enabled' => true,
                'threshold' => 400
            ],
            Listener\LogDispatchErrorListener::class => [
                'handlers' => [
                    Handler\DispatchErrorInterface::class
                ],
                'processors' => [
                    \Monolog\Processor\WebProcessor::class,
                    \Monolog\Processor\PsrLogMessageProcessor::class
                ],
                'enabled' => true,
            ],
            Listener\LogRenderErrorListener::class => [
                'handlers' => [
                    Handler\RenderErrorInterface::class
                ],
                'processors' => [
                    \Monolog\Processor\WebProcessor::class,
                    \Monolog\Processor\PsrLogMessageProcessor::class
                ],
                'enabled' => true,
            ]
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