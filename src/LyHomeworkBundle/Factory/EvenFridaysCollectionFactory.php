<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Factory;

class EvenFridaysCollectionFactory
{
    public function create(): array
    {
        $firstFriday = new \DateTimeImmutable("01-01-2021");
        $lastFriday = new \DateTimeImmutable("31-12-2021");
        $interval = new \DateInterval("P7D");
        $period = new \DatePeriod($firstFriday, $interval, $lastFriday);

        $result = [];
        foreach ($period as $friday) {
            /** @var \DateTimeImmutable $friday */
            if(0 === $friday->format("j") % 2) {
                $result[] = $friday->format("d-m-Y");
            }
        }
        return $result;
    }
}
