<?php
declare(strict_types=1);

namespace Tests\LyHomeworkBundle\Integration\Factory;

use LyHomeworkBundle\Factory\RandomUserByLetterMatrixFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RandomUserByLetterMatrixFactoryTest extends WebTestCase
{

    public function testCreate(): void
    {
        $kernel = self::bootKernel();
        $factory = $kernel->getContainer()->get(RandomUserByLetterMatrixFactory::class);
    }
}
