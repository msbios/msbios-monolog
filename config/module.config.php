<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog;

use Zend\ServiceManager\Factory\InvokableFactory;

return [

    'service_manager' => [
        'factories' => [
            Module::class => Factory\ModelFactory::class,

            // logger manager
            LoggerManager::class => Factory\LoggerManagerFactory::class,

            // listeners
            Listener\CheckSlowResponseTimeListener::class => InvokableFactory::class,
            Listener\LoggerDispatchErrorListener::class => InvokableFactory::class,
            Listener\LoggerRenderErrorListener::class => InvokableFactory::class
        ],
        'shared' => [
            // Logger::class => false
        ],
        'initializers' => [
            new Initializer\LoggerInitializer
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
                'listener' => Listener\LoggerDispatchErrorListener::class,
                'method' => 'onDispatchError',
                'event' => \Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR,
                'priority' => 100,
            ], [
                'listener' => Listener\LoggerRenderErrorListener::class,
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
                'formatter' => Formatter\DefaultFormatterInterface::class
            ],

            Handler\DispatchErrorInterface::class => [
                'class' => \Monolog\Handler\StreamHandler::class,
                'args' => [
                    'stream' => './data/logs/dispatch.error.handler.log'
                ],
                'formatter' => Formatter\DefaultFormatterInterface::class
            ],
            Handler\RenderErrorInterface::class => [
                'class' => \Monolog\Handler\StreamHandler::class,
                'args' => [
                    'stream' => './data/logs/render.error.handler.log'
                ],
                'formatter' => Formatter\DefaultFormatterInterface::class
            ],
            Handler\SlowResponseTimeInterface::class => [
                'class' => \Monolog\Handler\StreamHandler::class,
                'args' => [
                    'stream' => './data/logs/slow.response.handler.log'
                ],
                'formatter' => Formatter\DefaultFormatterInterface::class
            ]
        ],

        'formatters' => [
            Formatter\DefaultFormatterInterface::class => [
                'class' => \Monolog\Formatter\LineFormatter::class,
                'args' => [
                    'format' => "%datetime% - %channel% - %message% \n%extra% \n",
                ],
            ]
        ]
    ]
];
