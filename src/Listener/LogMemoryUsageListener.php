<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Monolog\Listener;

use Zend\EventManager\EventInterface;

/**
 * Class LogMemoryUsageListener
 * @package MSBios\Monolog\Listener
 */
class LogMemoryUsageListener extends AbstractTimemableListener
{

    /** @const APPLICATION_MEMORY */
    const APPLICATION_MEMORY = 1;

    /** @const SYSTEM_MEMORY */
    const SYSTEM_MEMORY = 2;

    /**
     * @param EventInterface $e
     */
    public function onFinish(EventInterface $e)
    {
        switch ($this->getOptions()->get('type')) {
            case self::SYSTEM_MEMORY:
                 // Memory usage: 4.55 GiB / 23.91 GiB (19.013557664178%)
                 $memUsage = $this->getServerMemoryUsage(false);
                 $this->getLogger()->info(sprintf(
                     "Memory usage: %s / %s (%s%%)",
                     $this->getNiceFileSize($memUsage["total"] - $memUsage["free"]),
                     $this->getNiceFileSize($memUsage["total"]),
                     $this->getServerMemoryUsage(true)
                 ));
                break;

            case self::APPLICATION_MEMORY:
            default:
                /** @var int $size */
                $size = memory_get_usage(true);

                /** @var array $unit */
                $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
                $this->getLogger()->info(
                    @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i]
                );
                break;
        }
    }

    /**
     * Returns used memory (either in percent (without percent sign) or free and overall in bytes)
     *
     * @param bool $getPercentage
     * @return array|int|null
     */
    private function getServerMemoryUsage($getPercentage = true)
    {
        $memoryTotal = null;
        $memoryFree = null;

        if (stristr(PHP_OS, "win")) {
            // Get total physical memory (this is in bytes)
            $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
            @exec($cmd, $outputTotalPhysicalMemory);

            // Get free physical memory (this is in kibibytes!)
            $cmd = "wmic OS get FreePhysicalMemory";
            @exec($cmd, $outputFreePhysicalMemory);

            if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
                // Find total value
                foreach ($outputTotalPhysicalMemory as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $memoryTotal = $line;
                        break;
                    }
                }

                // Find free value
                foreach ($outputFreePhysicalMemory as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $memoryFree = $line;
                        $memoryFree *= 1024;  // convert from kibibytes to bytes
                        break;
                    }
                }
            }
        } else {
            if (is_readable("/proc/meminfo")) {
                $stats = @file_get_contents("/proc/meminfo");

                if ($stats !== false) {
                    // Separate lines
                    $stats = str_replace(["\r\n", "\n\r", "\r"], "\n", $stats);
                    $stats = explode("\n", $stats);

                    // Separate values and find correct lines for total and free mem
                    foreach ($stats as $statLine) {
                        $statLineData = explode(":", trim($statLine));

                        //
                        // Extract size (TODO: It seems that (at least) the two values for total and free memory have the unit "kB" always. Is this correct?
                        //

                        // Total memory
                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemTotal") {
                            $memoryTotal = trim($statLineData[1]);
                            $memoryTotal = explode(" ", $memoryTotal);
                            $memoryTotal = $memoryTotal[0];
                            $memoryTotal *= 1024;  // convert from kibibytes to bytes
                        }

                        // Free memory
                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                            $memoryFree = trim($statLineData[1]);
                            $memoryFree = explode(" ", $memoryFree);
                            $memoryFree = $memoryFree[0];
                            $memoryFree *= 1024;  // convert from kibibytes to bytes
                        }
                    }
                }
            }
        }

        if (is_null($memoryTotal) || is_null($memoryFree)) {
            return null;
        } else {
            if ($getPercentage) {
                return (100 - ($memoryFree * 100 / $memoryTotal));
            } else {
                return [
                    "total" => $memoryTotal,
                    "free" => $memoryFree,
                ];
            }
        }
    }

    /**
     * @param $bytes
     * @param bool $binaryPrefix
     * @return string
     */
    private function getNiceFileSize($bytes, $binaryPrefix = true)
    {
        if ($binaryPrefix) {
            $unit = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];
            if ($bytes == 0) {
                return '0 ' . $unit[0];
            }
            return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . ' ' . (isset($unit[$i]) ? $unit[$i] : 'B');
        } else {
            $unit = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
            if ($bytes == 0) {
                return '0 ' . $unit[0];
            }
            return @round($bytes / pow(1000, ($i = floor(log($bytes, 1000)))), 2) . ' ' . (isset($unit[$i]) ? $unit[$i] : 'B');
        }
    }
}
