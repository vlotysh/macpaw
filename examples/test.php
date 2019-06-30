<?php

require __DIR__ . '/../vendor/autoload.php';

use Macpaw\AbTestManager;
use Macpaw\FileStorage;
use Macpaw\User;

$abString = '50% / 50%';
$storage = new FileStorage();
$user = new User();
$ab = new AbTestManager($storage, $abString);

$abvalue = $ab->getTestValue($user);

$ab->store($user, $abvalue);

echo "{$abvalue} for user with id {$user->getId()} " . PHP_EOL;

$abvalue = $ab->getTestValue($user);

echo "User with id {$user->getId()} get the same a/b case {$abvalue}". PHP_EOL;;