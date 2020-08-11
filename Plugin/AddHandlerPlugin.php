<?php

declare(strict_types=1);

namespace Yireo\SlackLogger\Plugin;

use Magento\Framework\Logger\Monolog;
use Yireo\SlackLogger\Factory\SlackHandlerFactory;

class AddHandlerPlugin
{
    /**
     * @var SlackHandlerFactory
     */
    private $slackHandlerFactory;

    /**
     * AddHandlerPlugin constructor.
     * @param SlackHandlerFactory $slackHandlerFactory
     */
    public function __construct(SlackHandlerFactory $slackHandlerFactory)
    {
        $this->slackHandlerFactory = $slackHandlerFactory;
    }

    /**
     * @param Monolog $subject
     * @param array $handlers
     * @return array
     */
    public function beforeSetHandlers(Monolog $subject, array $handlers): array
    {
        $handlers[] = $this->slackHandlerFactory->create();
        return $handlers;
    }
}
