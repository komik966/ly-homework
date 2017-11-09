<?php
declare(strict_types=1);

namespace Tests\LyHomeworkBundle\Unit\Builder;

use LyHomeworkBundle\Builder\TransformedImageBuilder;
use LyHomeworkBundle\Model\Image;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TransformedImageBuilderTest extends TestCase
{
    public function testPrepareBuilder(): void
    {
        $builder = new TransformedImageBuilder('foo', 'bar');
        $builder->prepareBuilder(new Image());
        $firstResultImage = $builder->getResultImage();
        $builder->prepareBuilder(new Image());

        $this->assertNotSame($firstResultImage, $builder->getResultImage());
    }

    public function testResizeAndFlip(): void
    {
        $baseImage = (new Image())
            ->setImageFile($this->mockUploadedFile())
            ->setScaledWidth(50)
            ->setScaledHeight(50);
        $resultImage = (new TransformedImageBuilder(getenv('FIXTURES_PATH'), '/images'))
            ->prepareBuilder($baseImage)
            ->resizeAndFlip()
            ->getResultImage();

        $this->assertStringEndsWith('.jpg', $resultImage->getTransformedImagePath());
    }

    public function testPutImageInfo()
    {
        $baseImage = (new Image())->setImageFile($this->mockUploadedFile());
        $resultImage = (new TransformedImageBuilder('foo', 'bar'))
            ->prepareBuilder($baseImage)
            ->putImageInfo()
            ->getResultImage();

        $this->assertEquals(100, $resultImage->getOriginalWidth());
        $this->assertEquals(100, $resultImage->getOriginalHeight());
        $this->assertEquals('image/jpg', $resultImage->getMimeType());
        $this->assertEquals('4.00 KB', $resultImage->getHumanReadableFileSize());
    }

    private function mockUploadedFile(): UploadedFile
    {
        $mock = $this->createMock(UploadedFile::class);
        $mock->method('getPathname')->willReturn(getenv('FIXTURES_PATH') . '/images/pets.jpg');
        $mock->method('getMimeType')->willReturn('image/jpg');
        $mock->method('getSize')->willReturn(4096);
        /**
         * @var UploadedFile $mock
         */
        return $mock;
    }
}
