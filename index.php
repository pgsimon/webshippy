<?php

require __DIR__ . '/vendor/autoload.php';

use Webshippy\FulfillableOrderService;

$fulfillableOrderService = new FulfillableOrderService($argc, $argv, 'files/orders.csv');
if ($fulfillableOrderService->execute() == false) {
    echo $fulfillableOrderService->validator->getError();
    exit(1);
}

foreach ($fulfillableOrderService->formatter->getResult() as $row) {
    foreach ($row as $column) {
        echo $column;
    }
    echo "\n";
}
