<?php

namespace Macpaw\Test;

use Macpaw\AbTestManager;
use Macpaw\ArrayStorage;
use Macpaw\User;
use Macpaw\AbTestCases;

use PHPUnit\Framework\TestCase;

class AbTestManagerDistributionTest extends TestCase
{
    const AB_TEST_1 = '30%/70%';
    const AB_TEST_2 = '50%/50%';
    const AB_TEST_3 = '10%/90%';

    public function testAb3070Distribution()
    {
        $values = [];
        $total = 10000;

        $values['a'] = 0;
        $values['b'] = 0;
        $storage = new ArrayStorage();
        $abTestManager = new AbTestManager($storage, self::AB_TEST_1);

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
        $this->assertTrue(($aCaseFault >= 30 - 1) && ($aCaseFault <=  30 + 1));
        $this->assertTrue(($bCaseFault >= 70 - 1) && ($bCaseFault <= 70 + 1));
    }

    public function testAb5050Distribution()
    {
        $values = [];
        $total = 10000;

        $values['a'] = 0;
        $values['b'] = 0;
        $storage = new ArrayStorage();
        $abTestManager = new AbTestManager($storage, self::AB_TEST_2);

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
        $this->assertTrue(($aCaseFault >= 50 - 1) && ($aCaseFault <=  50 + 1));
        $this->assertTrue(($bCaseFault >= 50 - 1) && ($bCaseFault <= 50 + 1));
    }

    public function testAb1090Distribution()
    {
        $values = [];
        $total = 10000;

        $values['a'] = 0;
        $values['b'] = 0;
        $storage = new ArrayStorage();
        $abTestManager = new AbTestManager($storage, self::AB_TEST_3);

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
        $this->assertTrue(($aCaseFault >= 10 - 1) && ($aCaseFault <=  10 + 1));
        $this->assertTrue(($bCaseFault >= 90 - 1) && ($bCaseFault <= 90 + 1));
    }
}