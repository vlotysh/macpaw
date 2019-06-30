<?php

require __DIR__ . '/../vendor/autoload.php';

use Macpaw\AbTest;
use Macpaw\FileStorage;
use Macpaw\User;

$abString = '50% / 50%';
$storage = new FileStorage();
$user = new User('tesstrd');
$ab = new AbTest($storage, $abString);

$abvalue = $ab->getTestValue($user);
var_dump($abvalue);
$ab->store($user, $abvalue);