<?php

$token = getenv('BOT_TOKEN');
$tokenArr = explode(':', $token);
$partOfToken = $tokenArr[0];

echo "Welcome to /test/" . PHP_EOL;
