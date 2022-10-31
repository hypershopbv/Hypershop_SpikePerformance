<?php
declare(strict_types=1);

namespace Hypershop\SpikePerformance\Cron;

use Exception;
use Hypershop\SpikePerformance\Helper\Config;
use Magento\Framework\App\Cache\Manager;
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
     * @var Manager
     */
    private $cacheManager;
    /**
     * @var IndexerFactory
     */
    private $indexerFactory;
    /**
     * @var CollectionFactory
     */
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
     * @throws Exception
     */
    public function execute()
    {
        if ($this->spikePerformanceConfig->getIsEnabled() && $this->spikePerformanceConfig->getIsCronEnabled()) {
            // Reindex all indexes
            $this->reindexAllIndexes();
            // Flush all caches
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
