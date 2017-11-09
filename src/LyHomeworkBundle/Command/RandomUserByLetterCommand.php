<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Command;

use LyHomeworkBundle\Factory\RandomUserByLetterMatrixFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RandomUserByLetterCommand extends Command
{
    /**
     * @var RandomUserByLetterMatrixFactory
     */
    private $randomUserByLetterMatrixFactory;

    public function __construct(RandomUserByLetterMatrixFactory $randomUserByLetterMatrixFactory)
    {
        $this->randomUserByLetterMatrixFactory = $randomUserByLetterMatrixFactory;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName("ly-homework:random-user-by-letter")
            ->setDescription("Prints random users first names grouped by first letter");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);
        $table
            ->setHeaders(["Letter", "Occurrence count", "First names"])
            ->setRows($this->randomUserByLetterMatrixFactory->create())
            ->render();
    }
}
