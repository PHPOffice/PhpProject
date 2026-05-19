<?php

namespace PhpOffice\PhpProject\Reader;

interface ReaderInterface
{
    /**
     * Can the current ReaderInterface read the file?
     *
     * @param  string $pFilename
     * @return bool
     */
    public function canRead($pFilename);

    /**
     * Loads PHPProject from file
     *
     * @param  string $pFilename
     * @return \PhpOffice\PhpProject\PhpProject
     */
    public function load($pFilename);
}
