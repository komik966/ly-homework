<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Builder;

use LyHomeworkBundle\Model\Image;

class TransformedImageBuilder
{
    /**
     * @var Image
     */
    private $baseImage;

    /**
     * @var Image
     */
    private $resultImage;

    /**
     * @var string
     */
    private $webDir;

    /**
     * @var string
     */
    private $imagesPath;

    public function __construct(string $webDir, string $imagesPath)
    {
        $this->webDir = $webDir;
        $this->imagesPath = $imagesPath;
    }

    public function prepareBuilder(Image $baseImage): TransformedImageBuilder
    {
        $this->baseImage = $baseImage;
        $this->resultImage = new Image();
        return $this;
    }

    public function resizeAndFlip(): TransformedImageBuilder
    {
        $imagick = new \Imagick($this->baseImage->getImageFile()->getPathname());
        $imagick->flipImage();
        $imagick->thumbnailImage($this->baseImage->getScaledWidth(), $this->baseImage->getScaledHeight());

        $imagePath = $this->imagesPath . '/'. uniqid() . '.jpg';
        $this->resultImage->setTransformedImagePath($imagePath);
        $imagick->writeImage($this->webDir . '/' . $imagePath);
        return $this;
    }

    public function putImageInfo(): TransformedImageBuilder
    {
        $dimensions = (new \Imagick($this->baseImage->getImageFile()->getPathname()))->getImageGeometry();
        $this->resultImage
            ->setMimeType($this->baseImage->getImageFile()->getMimeType())
            ->setHumanReadableFileSize($this->humanFileSize($this->baseImage->getImageFile()->getSize()))
            ->setOriginalWidth($dimensions['width'])
            ->setOriginalHeight($dimensions['height']);
        return $this;
    }

    /**
     * https://gist.github.com/gladx/62fa307eb65586b6dbaaad75273c653d
     */
    private function humanFileSize(int $bytes, int $decimals = 2): string
    {
        if ($bytes < 1024) {
            return $bytes . ' B';
        }

        $factor = floor(log($bytes, 1024));
        return sprintf("%.{$decimals}f ", $bytes / pow(1024, $factor)) . ['B', 'KB', 'MB', 'GB', 'TB', 'PB'][$factor];
    }

    public function getResultImage(): Image
    {
        return $this->resultImage;
    }
}
