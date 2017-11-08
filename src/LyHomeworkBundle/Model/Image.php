<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Model;

class Image
{
    private $mirrored;
    private $width;
    private $height;
    private $humanReadableFileSize;
    private $mimeType;

    public function getMirrored(): string
    {
        return $this->mirrored;
    }

    public function setMirrored(string $mirrored): Image
    {
        $this->mirrored = $mirrored;
        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): Image
    {
        $this->width = $width;
        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): Image
    {
        $this->height = $height;
        return $this;
    }

    public function getHumanReadableFileSize(): string
    {
        return $this->humanReadableFileSize;
    }

    public function setHumanReadableFileSize(string $humanReadableFileSize): Image
    {
        $this->humanReadableFileSize = $humanReadableFileSize;
        return $this;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): Image
    {
        $this->mimeType = $mimeType;
        return $this;
    }
}
