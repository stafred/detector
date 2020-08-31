<?php

namespace Detector;

/**
 * Class DetectorHelper
 * @package Detector
 */
class DetectorHelper
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
     * @var bool
     */
    protected $error_info = true;
    /**
     * @var bool
     */
    protected $error_debug = true;
    /**
     * @var null
     */
    protected $error_name_log = NULL;
    /**
     * @var null
     */
    protected $error_path_log = NULL;

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @throws \Exception
     */
    final public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        $this->makeLog($errstr, $errfile, $errline);
        $code = \IApp::ERROR_SERVER;
        $error = $this->getErrorInfo($errstr);
        $this->buffer($this->addResorce($error, $code, $errstr));
    }

    /**
     * @param \Exception $e
     * @throws \Exception
     */
    final public function exceptionHandler($e)
    {
        $this->makeLog($e->getMessage(), $e->getFile(), $e->getLine());
        $code = $e->getCode() == 0 ? \IApp::ERROR_SERVER : $e->getCode();
        $error = $this->getErrorInfo($e->getMessage());
        $this->buffer($this->addResorce($error, $code, $e->getMessage()));
    }

    /**
     * @return bool
     */
    protected function getDebug(): bool
    {
        return $this->error_debug;
    }

    protected function setError()
    {
        set_error_handler([$this, 'errorHandler']);
    }

    protected function setException()
    {
        set_exception_handler([$this, 'exceptionHandler']);
    }

    /**
     * @param string $error
     * @param string $file
     * @param int $line
     * @throws \Exception
     */
    protected function makeLog(string $error, string $file, int $line): void
    {
        $dir = '..';
        $delimeter = '/';
        $path = $dir . $this->getPathLog();
        if(!file_exists($path)){
            if(!is_dir("../error")) mkdir("../error");
            $path = "../error/error_app.log";
        }
        else {
            $path .= $delimeter . $this->getNameLog();
        }
        file_put_contents($path,  $this->format(
            $error, $file, $line
        ), FILE_APPEND);
    }

    /**
     * @param string $error
     * @param string $file
     * @param int $line
     * @return string
     */
    protected function format(string $error, string $file, int $line): string
    {
        return
            '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . PHP_EOL .
            '>>>>>' . PHP_EOL .
            '>>>>> ERROR [' . date("H:m:s Y-m-d") . ']' . PHP_EOL .
            '>>>>>' . PHP_EOL .
            '> | URI: ' . (
                !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on'
                    ? 'http' : 'https'
            ) . '://' .
            $_SERVER['SERVER_NAME'] .
            $_SERVER['REQUEST_URI'] . PHP_EOL .
            '> | Protocol: ' . $_SERVER['SERVER_PROTOCOL'] . PHP_EOL .
            '> | Method: ' . $_SERVER['REQUEST_METHOD'] . PHP_EOL .
            '> | Client: ' . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL .
            '> | IP: ' . $_SERVER['REMOTE_ADDR'] . PHP_EOL .
            '> | Text: ' . $error . PHP_EOL .
            '> | File: ' . $file . PHP_EOL .
            '> | Line: ' . $line . PHP_EOL .
            '>>>>>' . PHP_EOL;
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getPathLog(): string
    {
        return empty($this->error_path_log) ? self::LOG_PATH : $this->error_path_log;
    }

    /**
     * @return string
     */
    protected function getNameLog()
    {
        return empty($this->error_name_log)
            ? self::LOG_NAME
            : $this->error_name_log;
    }

    /**
     * @param $error
     * @param $code
     * @param $status
     * @return mixed
     */
    protected function addResorce($error, $code, $status)
    {
        $this->setHeader($code, $status);
        return require_once self::ERROR_PATH;
    }

    /**
     * @param string $info
     * @param int $code
     * @return string
     */
    protected function getErrorInfo(string $info): string
    {
        return (!defined('ERROR_INFO') OR ERROR_INFO === false) ? '' : $info;
    }

    /**
     * @param string|bool $define
     * @return bool
     */
    protected function getDefinedBool($define)
    {
        return defined(strval($define))
            ? boolval(constant($define))
            : boolval($define);
    }

    /**
     * @param string|bool $define
     * @return string
     */
    protected function getDefinedString($define)
    {
        return defined(strval($define))
            ? strval(constant($define))
            : strval($define);
    }

    /**
     * @param $content
     */
    protected function buffer($content)
    {
        ob_start(function() use ($content){
            return $content;
        });
        echo ob_get_contents();
        ob_end_clean();
    }

    /**
     * @param int $code
     * @param string $statustext
     */
    protected function setHeader(int $code = 200, string $statustext = 'test'){
        header("HTTP/1.1 $code", true);
        header("StatusText: $statustext");
    }
}