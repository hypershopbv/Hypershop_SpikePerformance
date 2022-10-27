<?php
declare(strict_types=1);

namespace Hypershop\SpikePerformance\Plugin\Magento\Backend\Controller\Adminhtml\Cache;

use Hypershop\SpikePerformance\Helper\Config;
use Magento\Backend\Controller\Adminhtml\Cache\FlushAll as MagentoFlushAll;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class FlushAll
{
    /**
     * @var Config
     */
    private $spikePerformanceConfig;
    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @param Config $spikePerformanceConfig
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        Config $spikePerformanceConfig,
        ResultFactory $resultFactory
    ) {
        $this->spikePerformanceConfig = $spikePerformanceConfig;
        $this->resultFactory = $resultFactory;
    }

    /**
     * @param MagentoFlushAll $subject
     * @param callable $proceed
     * @return Redirect|Redirect&ResultInterface
     * @throws NoSuchEntityException
     */
    public function aroundExecute(MagentoFlushAll $subject, callable $proceed)
    {
        if ($this->spikePerformanceConfig->getIsEnabled()) {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('adminhtml/*');
        }

        return $proceed();
    }
}
