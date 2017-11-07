<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Command;

use LyHomeworkBundle\Factory\EvenDaysCollectionFactory;
use Symfony\Component\Console\Command\Command;

class EvenDaysCommand extends Command
{
    /**
     * @var EvenDaysCollectionFactory
     */
    private $evenDaysCollectionFactory;

    public function __construct(EvenDaysCollectionFactory $evenDaysCollectionFactory)
    {
        $this->evenDaysCollectionFactory = $evenDaysCollectionFactory;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName("ly-homework:even-days")
            ->setDescription("Prints even days in 2021");
    }
}
