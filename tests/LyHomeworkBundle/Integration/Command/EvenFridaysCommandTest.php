<?php

namespace Tests\LyHomeworkBundle\Integration\Command;

use LyHomeworkBundle\Command\EvenFridaysCommand;
use LyHomeworkBundle\Factory\EvenFridaysCollectionFactory;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class EvenFridaysCommandTest extends KernelTestCase
{
    public function testExecute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $application->add(new EvenFridaysCommand(new EvenFridaysCollectionFactory()));

        $command = $application->find("ly-homework:even-fridays");
        $commandTester = new CommandTester($command);
        $commandTester->execute(["command" => $command->getName()]);

        $this->assertContains(<<<EOF
+------------+
| Date       |
+------------+
| 08-01-2021 |
| 22-01-2021 |
| 12-02-2021 |
EOF
            , $commandTester->getDisplay());
    }
}
