<?php

declare(strict_types=1);

namespace Yireo\SlackLogger\Factory;

use Magento\Framework\ObjectManagerInterface;
use Monolog\Handler\SlackHandler;
use Monolog\Logger;
use Yireo\SlackLogger\Config\Config;
use Yireo\SlackLogger\Exception\NotConfigured;

class SlackHandlerFactory
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var Config
     */
    private $config;

    /**
     * SlackHandlerFactory constructor.
     * @param ObjectManagerInterface $objectManager
     * @param Config $config
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        Config $config
    ) {
        $this->objectManager = $objectManager;
        $this->config = $config;
    }

    /**
     * @param array $arguments
     * @return SlackHandler
     */
    public function create(array $arguments = [])
    {
        if (!isset($arguments['token'])) {
            $arguments['token'] = $this->config->getToken();
        }

        if (!isset($arguments['username'])) {
            $arguments['username'] = $this->config->getUsername();
        }

        if (!isset($arguments['channel'])) {
            $arguments['channel'] = $this->config->getChannelName();
        }

        if (empty($arguments['token'])) {
            throw new NotConfigured('"token" is not configured');
        }

        if (empty($arguments['username'])) {
            throw new NotConfigured('"username" is not configured');
        }

        if (empty($arguments['channel'])) {
            throw new NotConfigured('"channel" is not configured');
        }

        // @todo: Modify this as well via configuration
        $arguments['level'] = Logger::CRITICAL;

        /** @var SlackHandler $slackHandler */
        $slackHandler = $this->objectManager->create(SlackHandler::class, $arguments);
        return $slackHandler;
    }
}
