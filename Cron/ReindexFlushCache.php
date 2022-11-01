<?php
declare(strict_types=1);

namespace Hypershop\SpikePerformance\Cron;

use Exception;
use Hypershop\SpikePerformance\Helper\Config;
use Magento\Framework\App\Cache\Frontend\Pool;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Indexer\Model\Indexer\CollectionFactory;
use Magento\Indexer\Model\IndexerFactory;

class ReindexFlushCache
{
    /**
     * @var Config
     */
    private $spikePerformanceConfig;
    /**
     * @var IndexerFactory
     */
    private $indexerFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var ManagerInterface
     */
    private $eventManager;
    /**
     * @var Pool
     */
    private $cachePool;

    /**
     * @param Config $spikePerformanceConfig
     * @param Pool $cachePool
     * @param IndexerFactory $indexerFactory
     * @param CollectionFactory $collectionFactory
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        Config $spikePerformanceConfig,
        Pool $cachePool,
        IndexerFactory $indexerFactory,
        CollectionFactory $collectionFactory,
        ManagerInterface $eventManager
    ) {
        $this->spikePerformanceConfig = $spikePerformanceConfig;
        $this->cachePool = $cachePool;
        $this->indexerFactory = $indexerFactory;
        $this->collectionFactory = $collectionFactory;
        $this->eventManager = $eventManager;
    }

    /**
     * @throws NoSuchEntityException
     * @throws Exception
     */
    public function execute()
    {
        if ($this->spikePerformanceConfig->getIsEnabled() && $this->spikePerformanceConfig->getIsCronEnabled()) {
            $this->reindexAllIndexes();
            $this->flushAllCaches();
        }
    }

    /**
     * Reindex all indexes
     *
     * @return void
     * @throws Exception
     */
    private function reindexAllIndexes()
    {
        $indexerCollection = $this->collectionFactory->create();
        $indexIds = $indexerCollection->getAllIds();

        foreach ($indexIds as $indexId) {
            $index = $this->indexerFactory->create()->load($indexId);
            $index->reindexAll();
        }
    }

    /**
     * Flush all caches
     *
     * @return void
     */
    private function flushAllCaches()
    {
        $this->eventManager->dispatch('adminhtml_cache_flush_all');
        foreach ($this->cachePool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
    }
}
