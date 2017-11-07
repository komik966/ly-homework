<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Command;

use LyHomeworkBundle\Factory\EvenFridaysCollectionFactory;
use Symfony\Component\Console\Command\Command;

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
}
