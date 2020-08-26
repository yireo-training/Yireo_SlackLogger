<?php

declare(strict_types=1);

namespace Yireo\SlackLogger\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    const XML_CONFIG_BASE_PATH = 'admin/slack_logging';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function enabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(self::XML_CONFIG_BASE_PATH . '/enabled');
    }

    public function getToken(): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_CONFIG_BASE_PATH . '/token');
    }

    public function getUsername(): string
    {
        return (string)$this->scopeConfig->getValue(self::XML_CONFIG_BASE_PATH . '/username');
    }

    public function getChannelName(): string
    {
        $channelName = (string)$this->scopeConfig->getValue(self::XML_CONFIG_BASE_PATH . '/channel_name');

        if (!$channelName) {
            $channelName = 'general';
        }

        return '#' . ltrim($channelName, '#');
    }
}
