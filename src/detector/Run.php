<?php
namespace Detector;

/**
 * Run Detector for Activate Filp/Whoops
 * @package Detector
 */
final class Run extends Register
{
    /**
     * Run constructor.
     */
    public function __construct()
    {
        $this->error();
        $this->exception();
        $this->shutdown();
    }

    /**
     * @return bool
     */
    public function isDetect(): bool
    {
        return $this->detect;
    }
}