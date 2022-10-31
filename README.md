# Hypershop_SpikePerformance

## Goal
- Enable this extension to temporarily disable any cache flush from the Magento backend or
  frontend. Useful for moments when large traffic amounts are expected and the performance needs
  to be optimal.
- If enabled, there is a cronjob that reindexes and flushes all caches at midnight around 03:00. (Optional setting)

## Setup
- After install this module through composer, run a bin/magento setup:upgrade to add it to the Magento module list.

## Usage / Settings
- Settings can be found under `Hyperstack > Spike Performance`

## Common issues
- None known so far.
