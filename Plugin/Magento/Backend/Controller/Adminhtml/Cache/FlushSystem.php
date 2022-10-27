<?php
declare(strict_types=1);

namespace Hypershop\SpikePerformance\Plugin\Magento\Backend\Controller\Adminhtml\Cache;

use Magento\Backend\Controller\Adminhtml\Cache\FlushSystem as MagentoFlushSystem;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\ResultFactory;

class FlushSystem
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ResultFactory $resultFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->resultFactory = $resultFactory;
    }

    public function aroundExecute(MagentoFlushSystem $subject, callable $proceed)
    {
        if ($this->scopeConfig->getValue('hypershop_spikeperformance/general/enable')) {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('adminhtml/*');
        }

        return $proceed();
    }
}
