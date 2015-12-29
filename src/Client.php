<?php
namespace Prometheus;

require_once(dirname(__FILE__) . '/PrometheusException.php');
require_once(dirname(__FILE__) . '/Metric.php');
require_once(dirname(__FILE__) . '/Counter.php');
require_once(dirname(__FILE__) . '/Gauge.php');
require_once(dirname(__FILE__) . '/Histogram.php');
require_once(dirname(__FILE__) . '/Registry.php');

class Client {
	private $registry;
	private $options;
	private $base_uri;

	public function __construct(array $options = []) {
		$this->registry = new Registry;
		$this->options = $options;
	}

	public function newCounter(array $opts = []) {
		return $this->register(new Counter($opts));
	}

	public function newGauge(array $opts = []) {
		return $this->register(new Gauge($opts));
	}

	public function newHistogram(array $opts = []) {
		return $this->register(new Histogram($opts));
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
