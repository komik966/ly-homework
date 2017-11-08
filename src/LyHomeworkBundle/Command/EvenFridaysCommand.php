<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Command;

use LyHomeworkBundle\Factory\EvenFridaysCollectionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EvenFridaysCommand extends Command
{
    /**
     * @var EvenFridaysCollectionFactory
     */
    private $evenFridaysCollectionFactory;

    public function __construct(EvenFridaysCollectionFactory $evenFridaysCollectionFactory)
    {
        $this->evenFridaysCollectionFactory = $evenFridaysCollectionFactory;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName("ly-homework:even-fridays")
            ->setDescription("Prints even fridays in 2021");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);
        $rows = [];
        foreach ($this->evenFridaysCollectionFactory->create() as $date) {
            $rows[] = [$date];
        }
        $table
            ->setHeaders(["Date"])
            ->setRows($rows)
            ->render();
    }
}
