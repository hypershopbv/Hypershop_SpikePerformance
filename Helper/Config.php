<?php
declare(strict_types=1);

namespace Hypershop\SpikePerformance\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config extends AbstractHelper
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     * @param Context $context
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Context $context
    ) {
        parent::__construct($context);
        $this->storeManager = $storeManager;
    }

    /**
     * Check if config value is enabled
     *
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getIsEnabled()
    {
        return $this->getConfigValueByKey('enabled');
    }

    /**
     * Get Spike Performance config value by key
     *
     * @param string $key
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getConfigValueByKey(string $key)
    {
        return $this->scopeConfig->getValue(
            'system/hypershop_spikeperformance/' . $key,
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }
}
