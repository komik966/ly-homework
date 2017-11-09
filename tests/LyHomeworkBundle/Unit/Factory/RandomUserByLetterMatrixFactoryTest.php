<?php
declare(strict_types=1);

namespace Tests\LyHomeworkBundle\Unit\Factory;

use Http\Adapter\Guzzle6\Client;
use LyHomeworkBundle\Factory\RandomUserByLetterMatrixFactory;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;

class RandomUserByLetterMatrixFactoryTest extends TestCase
{

    public function testCreate(): void
    {
        $factory = new RandomUserByLetterMatrixFactory($this->mockClient());
        $expected = [
            97 => ["a", 1, "amanda"],
            99 => ["c", 2, "cindy, carl"],
            101 => ["e", 2, "enni, elizabeth"],
            103 => ["g", 1, "gabrielle"],
            104 => ["h", 1, "harry"],
            106 => ["j", 1, "jake"],
            107 => ["k", 1, "kayra"],
            108 => ["l", 4, "louise, lisa, lucas, leiloca"],
            109 => ["m", 3, "maélie, marvin, margarita"],
            110 => ["n", 1, "nolan"],
            115 => ["s", 1, "silje"],
            118 => ["v", 2, "viola, victoria"]
        ];


        $this->assertEquals($expected, $factory->create());
    }

    private function mockClient(): Client
    {
        $mock = $this->createMock(Client::class);
        $mock->method('sendRequest')->willReturn(new Response(200, [], $this->mockBody()));

        /** @var Client $mock */
        return $mock;
    }

    private function mockBody(): StreamInterface
    {
        $mock = $this->createMock(StreamInterface::class);
        $mock->method('getContents')->willReturn(
            file_get_contents(getenv('FIXTURES_PATH') . '/random-user.json')
        );

        /** @var StreamInterface $mock */
        return $mock;
    }
}
