<?php

declare(strict_types=1);

namespace Yireo\SlackLogger\Logger;

use Magento\Framework\Logger\Monolog;
use Yireo\SlackLogger\Exception\NotConfigured;
use Yireo\SlackLogger\Factory\SlackHandlerFactory;

class Logger extends Monolog
{
    /**
     * Logger constructor.
     * @param SlackHandlerFactory $slackHandlerFactory
     * @param $name
     * @param array $handlers
     * @param array $processors
     */
    public function __construct(
        SlackHandlerFactory $slackHandlerFactory,
        $name,
        array $handlers = [],
        array $processors = []
    ) {
        try {
            $handlers[] = $slackHandlerFactory->create();
        } catch (NotConfigured $exception) {
        }

        parent::__construct($name, $handlers, $processors);
    }
}
