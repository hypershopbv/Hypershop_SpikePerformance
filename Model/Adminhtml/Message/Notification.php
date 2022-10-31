<?php

namespace Hypershop\SpikePerformance\Model\Adminhtml\Message;

use Hypershop\SpikePerformance\Helper\Config;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Notification\MessageInterface;
use Magento\Framework\UrlInterface;

class Notification implements MessageInterface
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;
    /**
     * @var Config
     */
    private $spikePerformanceConfig;

    /**
     * @param UrlInterface $urlBuilder
     * @param Config $spikePerformanceConfig
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Config $spikePerformanceConfig
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->spikePerformanceConfig = $spikePerformanceConfig;
    }

    /**
     * @return string
     */
    public function getIdentity(): string
    {
        return 'spike_performance_notification';
    }

    /**
     * @return bool
     * @throws NoSuchEntityException
     */
    public function isDisplayed(): bool
    {
        if (!$this->spikePerformanceConfig->getIsEnabled()) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        $spikePerformanceConfigUrl = $this->urlBuilder->getUrl('adminhtml/system_config/edit/section/hypershop_spikeperformance');
        return "<strong>The Hypershop Spike Performance module is enabled, this temporarily disables all cache flushes from the magento backend or frontend.</strong> <a href='$spikePerformanceConfigUrl'>Change the configuration here</a>";
    }

    /**
     * Return 0 because the sort order on messages is based on severity. This will load before others.
     *
     * @return int
     */
    public function getSeverity(): int
    {
        return 0;
    }
}
