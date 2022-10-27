<?php
declare(strict_types=1);

namespace Hypershop\SpikePerformance\Plugin\Magento\Backend\Controller\Adminhtml\Cache;

use Hypershop\SpikePerformance\Helper\Config;
use Magento\Backend\Controller\Adminhtml\Cache\MassRefresh as MagentoMassRefresh;
use Magento\Framework\Controller\ResultFactory;

class MassRefresh
{
    /**
     * @var Config
     */
    private $spikePerformanceConfig;
    /**
     * @var ResultFactory
     */
    private $resultFactory;

    public function __construct(
        Config $spikePerformanceConfig,
        ResultFactory $resultFactory
    ) {
        $this->spikePerformanceConfig = $spikePerformanceConfig;
        $this->resultFactory = $resultFactory;
    }

    public function aroundExecute(MagentoMassRefresh $subject, callable $proceed)
    {
        if ($this->spikePerformanceConfig->getIsEnabled()) {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('adminhtml/*');
        }

        return $proceed();
    }
}
