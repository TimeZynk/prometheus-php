Prometheus-PHP
==============

Library for registering, collecting and serializing metrics for the Prometheus monitoring tool.

It currently only does serialization and lets you decide if you want to post the serialized result to the
pushgateway or provide a HTTP endpoint where prometheus can access it.

It implements three metric types: Gauge, Counter and Histogram. To use it, instantiate the Client class:

```PHP
$client = new Prometheus\Client();

$session_updated_ago = $client->newHistogram(array(
    'namespace' => 'intellitime',
    'subsystem' => 'session',
    'name' => 'updated_ago',
    'help' => 'Number of seconds since the session was last updated',
    'buckets' => [500,600,700,800,900]
));

$session_updated_ago->observe(array('uid' => 1234), time() - $timestamp);

print $client->serialize();
```
