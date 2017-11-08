<?php
declare(strict_types=1);

namespace Tests\LyHomeworkBundle\Unit\Factory;

use LyHomeworkBundle\Factory\EvenFridaysCollectionFactory;
use PHPUnit\Framework\TestCase;

class EvenFridaysCollectionFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $result = (new EvenFridaysCollectionFactory())->create();
        $expectedHead = ["08-01-2021", "22-01-2021", "12-02-2021"];
        $expectedTail = ["26-11-2021", "10-12-2021", "24-12-2021"];
        $this->assertEquals($expectedHead, array_slice($result, 0, 3));
        $this->assertEquals($expectedTail, array_slice($result, -3, 3));
    }
}
