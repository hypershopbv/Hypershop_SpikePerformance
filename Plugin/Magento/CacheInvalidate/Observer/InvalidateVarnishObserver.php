<?php
declare(strict_types=1);

namespace Hypershop\SpikePerformance\Plugin\Magento\CacheInvalidate\Observer;

use Magento\CacheInvalidate\Observer\InvalidateVarnishObserver as MagentoInvalidateVarnishObserver;
use Magento\Framework\App\Config\ScopeConfigInterface;

class InvalidateVarnishObserver
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function aroundExecute(MagentoInvalidateVarnishObserver $subject, callable $proceed, $observer)
    {
        if ($this->scopeConfig->getValue('hypershop_spikeperformance/general/enable')) {
            return;
        }

        return $proceed($observer);
    }
}
