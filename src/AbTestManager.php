<?php

namespace Macpaw;

use \Exception;

/**
 * Class AbTestManager
 * @package Macpaw
 */
class AbTestManager
{
    /**
     * @var array
     */
    private $testList = ['a', 'b', 'c'];

    /**
     * @var array
     */
    private $abParams = [];

    /**
     * @var StorageInterface|null
     */
    private $storage = null;

    /**
     * AbTest constructor.
     *
     * @param StorageInterface $storage
     * @param string $abValues
     *
     * @throws Exception
     */
    public function __construct(StorageInterface $storage, string $abValues)
    {
        if (!$abValues) {
            throw new Exception('ab test string needed!');
        }

        $this->abParams = $this->parseAbString($abValues);
        $this->storage = $storage;
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function getTestValue(User $user)
    {
        if ($storedValue = $this->retrive($user)) {
            return $storedValue;
        }

        $priority = [];
        foreach($this->abParams AS $testKey => $percent){
            if($percent > 0){
                for($index = 0; $index < $percent; $index++){
                    $priority[] = $testKey;
                }
            }
        }

        $randomValue = rand(0, 9);
        $position = $priority[$randomValue];

        return AbTestCases::AB_CASES[$position];
    }

    /**
     * @param User $user
     * @param string $abCase
     *
     * @return mixed
     */
    public function store(User $user, string $abCase)
    {
        return $this->storage->store([
            'user' => $user,
            'ab_case' => $abCase
        ]);
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function retrive(User $user)
    {
        return $this->storage->retrieve([
            'user' => $user
        ]);
    }

    /**
     * @param string $abValue
     *
     * @return array
     *
     * @throws Exception
     */
    private function parseAbString(string $abValue): array
    {
        $percents = array_map(function($percentString) {
            return (int) str_replace('%', '', trim($percentString)) / 10;
        }, explode('/',$abValue));

        if (!$this->validatedPersents($percents)) {
            throw new Exception('Sum of A\B cases percentage must be 100');
        }

        return array_combine(array_slice($this->testList, 0 , count($percents)), $percents);
    }

    /**
     * @param array $percents
     *
     * @return bool
     */
    private function validatedPersents(array $percents): bool
    {
        $summ = 0;

        foreach ($percents as $percent) {
            $summ += $percent;
        }

        if ($summ === 10) {
            return true;
        }

        return false;
    }
}
