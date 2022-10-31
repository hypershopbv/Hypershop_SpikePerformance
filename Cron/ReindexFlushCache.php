<?php

declare(strict_types=1);

namespace Hypershop\SpikePerformance\Cron;

use Hypershop\SpikePerformance\Helper\Config;
use Magento\Framework\App\Cache\Manager;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Indexer\Model\Indexer\CollectionFactory;
use Magento\Indexer\Model\IndexerFactory;

class ReindexFlushCache
{
    private $spikePerformanceConfig;
    private $cacheManager;
    private $indexerFactory;
    private $collectionFactory;

    public function __construct(
        Config $spikePerformanceConfig,
        Manager $cacheManager,
        IndexerFactory $indexerFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->spikePerformanceConfig = $spikePerformanceConfig;
        $this->cacheManager = $cacheManager;
        $this->indexerFactory = $indexerFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        if (!$this->spikePerformanceConfig->getIsCronEnabled()) {
            return;
        }

        // Reindex all indexes
        $this->reindexAllIndexes();
        // Flush all caches
        $this->flushAllCaches();
    }

    /**
     * Reindex all indexes
     *
     * @return void
     * @throws \Exception
     */
    private function reindexAllIndexes()
    {
        // Reindex all indexes
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
        $this->cacheManager->flush($this->cacheManager->getAvailableTypes());
    }
}
