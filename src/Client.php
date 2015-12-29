<?php
namespace Prometheus;

require_once(dirname(__FILE__) . '/PrometheusException.php');
require_once(dirname(__FILE__) . '/Metric.php');
require_once(dirname(__FILE__) . '/Counter.php');
require_once(dirname(__FILE__) . '/Gauge.php');
require_once(dirname(__FILE__) . '/Metric.php');
require_once(dirname(__FILE__) . '/Registry.php');

class Client {
	private $registry;
	private $options;
	private $base_uri;

	public function __construct(array $options = []) {
		$this->registry = new Registry;

		$this->options = $options;

		if (empty($this->options['base_uri']))
			throw new PrometheusException("Prometheus requires a base_uri option, which points to the pushgateway");

		$this->base_uri = $options['base_uri'];

		// TODO: Allow option for requiring http basic authentication
	}

	public function newCounter(array $opts = []) {
		return $this->register(new Counter($opts));
	}

	public function newGauge(array $opts = []) {
		return $this->register(new Gauge($opts));
	}

	private function register(Metric $metric) {
		return $this->registry->register($metric);
	}

	public function serialize() {
		$body = "";

		foreach ($this->registry->getMetrics() as $metric) {
			$body .= $metric->serialize() . "\n";
		}

		return $body;
	}
}
