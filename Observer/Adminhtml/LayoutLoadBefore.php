<?php

namespace Hypershop\SpikePerformance\Observer\Adminhtml;

use Hypershop\SpikePerformance\Helper\Config as SpikePerformanceConfig;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\View\Page\Config;

class LayoutLoadBefore implements ObserverInterface
{
    /**
     * @var Config
     */
    private $pageConfig;
    /**
     * @var SpikePerformanceConfig
     */
    private $spikePerformanceConfig;

    /**
     * @param Config $pageConfig
     * @param SpikePerformanceConfig $spikePerformanceConfig
     */
    public function __construct(
        Config $pageConfig,
        SpikePerformanceConfig $spikePerformanceConfig
    ) {
        $this->pageConfig = $pageConfig;
        $this->spikePerformanceConfig = $spikePerformanceConfig;
    }

    public function execute(Observer $observer)
    {
        $action = $observer->getData('full_action_name');

        if ($action == 'adminhtml_cache_index') {
            if (!$this->spikePerformanceConfig->getIsEnabled()) {
                return;
            }

            $this->pageConfig->addBodyClass('spike-performance-is-active');
        }
    }
}
