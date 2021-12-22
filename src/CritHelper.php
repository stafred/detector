<?php

namespace Critbackup;

/**
 * Class CritHelper
 * @package Critbackup
 */
class CritHelper
{
    /**
     * @var ZipArchive|null
     */
    protected $zip = NULL;

    /**
     * @throws Exception
     */
    protected function initZip()
    {
        if ($this->isExtZipLoad()) {
            $this->zip = new ZipArchive();
        } else {
            throw new Exception("Zip initialization error.", 500);
        }
    }

    /**
     * @return bool
     */
    protected function isExtZipLoad(): bool
    {
        return extension_loaded('zip');
    }

    /**
     * #2 - project
     * @return mixed
     */
    protected function getPathProject()
    {
        return str_replace("\\", "/", dirname(__DIR__, 2));
    }

    /**
     * @return mixed
     */
    protected function getPathBackup()
    {
        return str_replace("\\", "/", dirname(__DIR__, 3));
    }

    /**
     * @return string
     */
    protected function makeNameZip(): string
    {
        return 'backup_critical_' . date("Ymd") . '.zip';
    }

    protected function getZipPath($path)
    {
        $source = $this->getPathProject();
        $path = str_replace("\\", "/", $path);
        return str_replace($source, '', $path);
    }

    /**
     * @return RecursiveIteratorIterator
     */
    protected function getRecursiveSources()
    {
        $iterator = new RecursiveDirectoryIterator($this->getPathProject());
        $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
        return $iterator;
    }

    protected function addResource()
    {
        $path = $this->getPathProject();
        $sources = $this->getRecursiveSources();
        foreach ($sources as $elem) {
            $elemName = ltrim($elem->getPathname(), '\\');
            if (is_dir($elem->getPathname())) {
                $this->zip->addEmptyDir(str_replace($path, '', $elemName . '/'));
            } else {
                if (is_file($elem->getPathname())) {
                    $this->zip->addFromString(str_replace($path, '', $elemName), file_get_contents($elemName));
                }
            }
        }
    }

    /**
     * @param bool $run
     */
    final public function clear(bool $run = false)
    {
        if(!$run) return;

        $sources = $this->getRecursiveSources();
        foreach ($sources as $elem) {
            $path = $elem->getPathname();
            if (is_file($path)) {
                unlink($path);
            }
        }

        foreach ($sources as $elem) {
            $path = $elem->getPathname();
            if (is_dir($path)) {
                unlink($path);
            }
        }
    }
}