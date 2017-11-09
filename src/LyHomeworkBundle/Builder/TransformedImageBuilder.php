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

    public function prepareBuilder(Image $baseImage): TransformedImageBuilder {
        $this->baseImage = $baseImage;
        $this->resultImage = new Image();
        return $this;
    }

    public function resizeAndFlip(): TransformedImageBuilder
    {
        return $this;
    }

    public function putImageInfo(): TransformedImageBuilder
    {
        $this->resultImage
            ->setMimeType($this->baseImage->getImageFile()->getMimeType())
            ->setHumanReadableFileSize($this->humanFileSize($this->baseImage->getImageFile()->getSize()))
            ->setTransformedImagePath('foo')
            ->setOriginalWidth(100)
            ->setOriginalHeight(100);
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
