<?php

require_once dirname(__FILE__) . '/../src/Client.php';

$client = new Prometheus\Client();

$counter = $client->newCounter([
	'namespace' => 'louddoor',
	'subsystem' => 'promotions',
	'name' => 'TestCounter',
	'help' => 'Some testing counter',
]);

$counter->increment(['promo' => 'ABC']);
$counter->increment(['promo' => 'ABC']);
$counter->increment(['promo' => 'ABC']);
$counter->increment(['promo' => 'ABC']);

$counter->increment(['promo' => 'CDE']);
$counter->increment(['promo' => 'CDE']);

$counter->increment(['promo' => 'EFG']);
$counter->increment(['promo' => 'HIJ'], 3); // Increment by 3 instead

print $client->serialize();
