<?php
declare(strict_types=1);

namespace Tests\LyHomeworkBundle\Integration\Factory;

use LyHomeworkBundle\Factory\EvenFridaysCollectionFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EvenFridaysCollectionFactoryTest extends WebTestCase
{
    public function testGetFromDiContainer(): void
    {
        $kernel = static::bootKernel();
        $this->assertInstanceOf(
            EvenFridaysCollectionFactory::class,
            $kernel->getContainer()->get(EvenFridaysCollectionFactory::class)
        );
    }
}
