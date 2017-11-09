<?php

namespace Tests\LyHomeworkBundle\Integration\Command;

use GuzzleHttp\Psr7\Response;
use Http\Adapter\Guzzle6\Client;
use LyHomeworkBundle\Command\RandomUserByLetterCommand;
use LyHomeworkBundle\Factory\RandomUserByLetterMatrixFactory;
use Psr\Http\Message\StreamInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class RandomUserByLetterCommandTest extends KernelTestCase
{
    public function testExecute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $application->add(new RandomUserByLetterCommand(
            new RandomUserByLetterMatrixFactory($this->mockClient())
        ));

        $command = $application->find("ly-homework:random-user-by-letter");
        $commandTester = new CommandTester($command);
        $commandTester->execute(["command" => $command->getName()]);

        $this->assertContains(<<<EOF
+--------+------------------+------------------------------+
| Letter | Occurrence count | First names                  |
+--------+------------------+------------------------------+
| a      | 1                | amanda                       |
| c      | 2                | cindy, carl                  |
| e      | 2                | enni, elizabeth              |
| g      | 1                | gabrielle                    |
| h      | 1                | harry                        |
EOF
            , $commandTester->getDisplay());
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
