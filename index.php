<?php

require __DIR__.'/vendor/autoload.php';

use Calculator\Calculator;

$calculator = new Calculator();

$result = $calculator->sum(2, 4);

print_r($result);

echo("\n");