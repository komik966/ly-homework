<?php
declare(strict_types=1);

namespace LyHomeworkBundle\Factory;

use GuzzleHttp\Psr7\Request;
use Http\Adapter\Guzzle6\Client;

class RandomUserByLetterMatrixFactory
{
    private const LOWER_A_ASCII_CODE = 97;
    private const LOWER_Z_ASCII_CODE = 122;

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns array, sorted by key in form of:
     * [
     *     <first_letter_ascii_code> => [<letter>,<occurrences_count>,<first_names>]
     * ]
     * @return array
     */
    public function create(): array
    {
        //TODO: Catch api failure
        $response = $this->client->sendRequest(new Request('get', 'https://randomuser.me/api/?results=100'));
        $decoded = json_decode($response->getBody()->getContents());

        $result = [];
        foreach ($decoded->results as $user) {
            $firstName = mb_strtolower($user->name->first);
            $firstLetter = mb_substr($firstName, 0, 1);
            $firstLetterAsciiCode = ord($firstLetter);
            if ($firstLetterAsciiCode < self::LOWER_A_ASCII_CODE || $firstLetterAsciiCode > self::LOWER_Z_ASCII_CODE) {
                continue;
            }
            if (!isset($result[$firstLetterAsciiCode])) {
                $result[$firstLetterAsciiCode] = [$firstLetter, 1, $firstName];
            } else {
                $result[$firstLetterAsciiCode][1] += 1;
                $result[$firstLetterAsciiCode][2] .= ', '. $firstName;
            }
        }
        ksort($result);
        return $result;
    }
}
