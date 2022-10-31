<?php

declare(strict_types=1);

namespace Hypershop\SpikePerformance\Cron;

use Hypershop\SpikePerformance\Helper\Config;

class ReindexFlushCache
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

    public function execute()
    {
        if (!$this->spikePerformanceConfig->getIsCronEnabled()) {
            return;
        }
    }
}
