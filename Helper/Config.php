<?php
declare(strict_types=1);

namespace Hypershop\SpikePerformance\Helper;

use Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory;
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
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param StoreManagerInterface $storeManager
     * @param Context $context
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Context $context,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Check if config value is enabled
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function getIsEnabled()
    {
        return $this->getConfigValueByKey('enabled');
    }

    /**
     * Check if config value for cronjob is enabled
     *
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getIsCronEnabled()
    {
        return $this->getConfigValueByKey('cron_enabled');
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
            'hypershop_spikeperformance/settings/' . $key,
            ScopeInterface::SCOPE_STORE,
            $this->storeManager->getStore()->getId()
        );
    }
}
