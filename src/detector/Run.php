<?php
namespace Detector;

/**
 * Run Detector
 * @package Detector
 */
final class Run extends DetectorHelper
{
    /**
     * @param string|bool $defined_error_debug
     */
    public function setErrorDebug($defined_error_debug): void
    {
        $this->error_debug = $this->getDefinedBool($defined_error_debug);
    }

    /**
     * @param string|bool $defined_error_info
     */
    public function setErrorInfo($defined_error_info): void
    {
        $this->error_info = $this->getDefinedBool($defined_error_info);
    }

    /**
     * @param string|bool $defined_name_log
     */
    public function setErrorNameLog($defined_name_log): void
    {
        $this->error_name_log = $this->getDefinedString($defined_name_log);
    }

    /**
     * @param string|bool $defined_path_log
     */
    public function setErrorPathLog($defined_path_log): void
    {
        $this->error_path_log = $this->getDefinedString($defined_path_log);
    }

    /**
     * @param callable|null $fn
     */
    public function make(callable $fn = null)
    {
        if($this->getDebug() AND !is_null($fn))
        {
	        $fn();
        }
        else {
            $this->setError();
            $this->setException();
        }
    }
}