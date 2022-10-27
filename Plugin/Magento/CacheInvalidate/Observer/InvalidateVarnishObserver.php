<?php
declare(strict_types=1);

namespace Hypershop\SpikePerformance\Plugin\Magento\CacheInvalidate\Observer;

use Hypershop\SpikePerformance\Helper\Config;
use Magento\CacheInvalidate\Observer\InvalidateVarnishObserver as MagentoInvalidateVarnishObserver;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class InvalidateVarnishObserver
{
    /**
     * @var Config
     */
    private $spikePerformanceConfig;

    /**
     * @param Config $spikePerformanceConfig
     */
    public function __construct(
        Config $spikePerformanceConfig
    ) {
        $this->spikePerformanceConfig = $spikePerformanceConfig;
    }

    /**
     * @param MagentoInvalidateVarnishObserver $subject
     * @param callable $proceed
     * @param $observer
     * @return void
     * @throws NoSuchEntityException
     */
    public function aroundExecute(MagentoInvalidateVarnishObserver $subject, callable $proceed, $observer)
    {
        if ($this->spikePerformanceConfig->getIsEnabled()) {
            return;
        }

        return $proceed($observer);
    }
}
