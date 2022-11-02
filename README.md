# Hypershop_SpikePerformance

## Goal
- Enable this extension to temporarily disable any cache flush from the Magento backend or
  frontend. Useful for moments when large traffic amounts are expected and the performance needs
  to be optimal.
- If enabled, there is a cronjob that reindexes and flushes all caches at midnight around 03:00. (Optional setting)

## Installation / Setup
- Install the module using the command `composer require hypershop/module-spike-performance`
- After installing, run a bin/magento setup:upgrade to add it to the Magento module list.

## Usage / Settings
- Settings can be found under `Hyperstack > Spike Performance`

## Plugins
- Potato Crawler plugin to to crawl the webshop after the cronjob is ready: [Hypershop_SpikePerformancePotatoCrawler](https://github.com/hypershopbv/Hypershop_SpikePerformancePotatoCrawler)

## Common issues
- None known so far.
