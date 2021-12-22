<?php

namespace Critbackup;

/**
 * Class CritBackup
 * @package Critbackup
 */
class CritBackup extends CritHelper
{
    /**
     * CritBackup constructor.
     */
    public function __construct()
    {
        $this->initZip();
        $this->zip->open(
            $this->getPathBackup() . DIRECTORY_SEPARATOR . $this->makeNameZip(),
            ZipArchive::CREATE
        );
        $this->addResource();
        $this->zip->close();
    }
}