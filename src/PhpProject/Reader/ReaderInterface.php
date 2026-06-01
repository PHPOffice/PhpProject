<?php

declare(strict_types=1);

namespace PhpOffice\PhpProject\Reader;

interface ReaderInterface
{
    /**
     * Can the current ReaderInterface read the file?
     *
     * @param  string $pFilename
     * @return bool
     */
    public function canRead(string $pFilename): bool;

    /**
     * Loads PHPProject from file
     *
     * @param  string $pFilename
     * @return \PhpOffice\PhpProject\PhpProject
     */
    public function load(string $pFilename): \PhpOffice\PhpProject\PhpProject;
}
