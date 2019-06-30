<?php

namespace Macpaw\Test;

use Macpaw\AbTestManager;
use Macpaw\ArrayStorage;
use Macpaw\User;
use Macpaw\AbTestCases;

use PHPUnit\Framework\TestCase;

class AbTestManagerDistributionTest extends TestCase
{
    const AB_TEST = '30%/70%';

    public function testAbDistribution()
    {
        $values = [];
        $total = 10000;

        $values['a'] = 0;
        $values['b'] = 0;
        $storage = new ArrayStorage();
        $abTestManager = new AbTestManager($storage, self::AB_TEST);

        for($i = 0; $i < $total; $i++) {
            $user = new User();
            $abValue = $abTestManager->getTestValue($user);

            if ($abValue === AbTestCases::AB_CASES['a']) {
                $values['a']++;
            } else {
                $values['b']++;
            }
        }

        $aCaseFault = round($values['a'] / 100);
        $bCaseFault = round($values['b'] / 100);

        //вычисление погрешности
        $this->assertTrue($aCaseFault >= 29 && $aCaseFault <= 31);
        $this->assertTrue($bCaseFault >= 69 && $bCaseFault <= 71);
    }
}