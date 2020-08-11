<?php
namespace Yireo\SlackLogger\Proxy;

use Magento\Framework\ObjectManagerInterface;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\SlackHandler;
use Yireo\SlackLogger\Config\Config;

class SlackHandlerProxy implements HandlerInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var SlackHandler
     */
    private $subject;

    /**
     * @var string
     */
    private $instanceName = SlackHandler::class;

    /**
     * @var Config
     */
    private $config;

    /**
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
     * @return SlackHandler
     */
    protected function getSubject(): SlackHandler
    {
        if (!$this->subject) {
            $arguments = [];
            $arguments['channel'] = $this->config->getChannelName();
            $arguments['username'] = $this->config->getUsername();
            $arguments['token'] = $this->config->getToken();
            $this->subject = $this->objectManager->create($this->instanceName, $arguments);
        }
        return $this->subject;
    }

    /**
     * @param array $record
     * @return bool
     */
    public function isHandling(array $record)
    {
        return $this->getSubject()->isHandling($record);
    }

    /**
     * @param array $record
     * @return bool
     */
    public function handle(array $record)
    {
        return $this->getSubject()->handle($record);
    }

    /**
     * @param array $records
     */
    public function handleBatch(array $records)
    {
        $this->getSubject()->handleBatch($records);
    }

    /**
     * @param callable $callback
     * @return HandlerInterface|SlackHandler
     */
    public function pushProcessor($callback)
    {
        return $this->getSubject()->pushProcessor($callback);
    }

    /**
     * @return callable|mixed
     */
    public function popProcessor()
    {
        return $this->getSubject()->popProcessor();
    }

    /**
     * @param FormatterInterface $formatter
     * @return HandlerInterface|SlackHandler
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        return $this->getSubject()->setFormatter($formatter);
    }

    /**
     * @return FormatterInterface|\Monolog\Formatter\LineFormatter
     */
    public function getFormatter()
    {
        return $this->getSubject()->getFormatter();
    }
}
