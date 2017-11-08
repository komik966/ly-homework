<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class Image
{
    public const GROUP_REQUEST = 'request';
    public const GROUP_RESPONSE = 'response';

    /**
     * @Groups({Image::GROUP_REQUEST})
     * @Assert\NotBlank()
     * @Assert\File(maxSize="5M")
     * @var UploadedFile
     */
    private $image;

    /**
     * @Groups({Image::GROUP_RESPONSE})
     * @var int
     */
    private $originalWidth;

    /**
     * @Groups({Image::GROUP_RESPONSE})
     * @var int
     */
    private $originalHeight;

    /**
     * @Groups({Image::GROUP_RESPONSE})
     * @var string
     */
    private $humanReadableFileSize;

    /**
     * @Groups({Image::GROUP_RESPONSE})
     * @var string
     */
    private $mimeType;

    /**
     * @Groups({Image::GROUP_REQUEST})
     * @Assert\NotBlank()
     * @Assert\Type(type="int")
     * @Assert\GreaterThanOrEqual(value="16")
     * @Assert\LessThanOrEqual(value="1024")
     * @var int
     */
    private $scaledWidth;

    /**
     * @Groups({Image::GROUP_REQUEST})
     * @Assert\NotBlank()
     * @Assert\Type(type="int")
     * @Assert\GreaterThanOrEqual(value="16")
     * @Assert\LessThanOrEqual(value="1024")
     * @var int
     */
    private $scaledHeight;

    /**
     * @Groups({Image::GROUP_RESPONSE})
     * @var string
     */
    private $mirroredImagePath;

    /**
     * @return UploadedFile
     */
    public function getImage(): UploadedFile
    {
        return $this->image;
    }

    public function setImage($image): Image
    {
        $this->image = $image;
        return $this;
    }

    public function getOriginalWidth(): int
    {
        return $this->originalWidth;
    }

    public function setOriginalWidth(int $originalWidth): Image
    {
        $this->originalWidth = $originalWidth;
        return $this;
    }

    public function getOriginalHeight(): int
    {
        return $this->originalHeight;
    }

    public function setOriginalHeight(int $originalHeight): Image
    {
        $this->originalHeight = $originalHeight;
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

    public function getScaledWidth(): int
    {
        return $this->scaledWidth;
    }

    public function setScaledWidth($scaledWidth): Image
    {
        $this->scaledWidth = (int)$scaledWidth;
        return $this;
    }

    public function getScaledHeight(): int
    {
        return $this->scaledHeight;
    }

    public function setScaledHeight($scaledHeight): Image
    {
        $this->scaledHeight = (int)$scaledHeight;
        return $this;
    }

    public function getMirroredImagePath(): string
    {
        return $this->mirroredImagePath;
    }

    public function setMirroredImagePath(string $mirroredImagePath): Image
    {
        $this->mirroredImagePath = $mirroredImagePath;
        return $this;
    }
}
