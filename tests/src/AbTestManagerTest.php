<?php

namespace Macpaw\Test;

use Macpaw\AbTestManager;
use Macpaw\ArrayStorage;
use Macpaw\User;

use PHPUnit\Framework\TestCase;

class AbTestManagerTest extends TestCase
{
    const USER_ID = 'test_user_id';
    const AB_TEST = '50%/50%';

    public function testAbContains() {
        $storage = new ArrayStorage();
        $user = new User(self::USER_ID);
        $abTestManager = new AbTestManager($storage, self::AB_TEST);
        $abValue = $abTestManager->getTestValue($user);

        $this->assertStringContainsString('link', $abValue);
    }
}
