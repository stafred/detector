<?php
namespace Detector;

/**
 * Class DecectorConfiguration
 * @package Detector
 */
class DecectorConfiguration
{
    /**
     * @const string
     */
    const LOG_PATH = '/factory/log/error';
    /**
     * @const string
     */
    const LOG_NAME = 'error_app.log';
    /**
     * @const string
     */
    const ERROR_PATH = '../vendor/stafred/detector/src/detector/resource/error.php';
    /**
     * @const int
     */
    const ERROR_SERVER = 500;

    /**
     * @const bool
     */
    const DEBUG_TEXT = true;
}