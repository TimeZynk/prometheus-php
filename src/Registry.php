<?php
namespace Prometheus;

require_once(dirname(__FILE__) . '/PrometheusException.php');

class Registry {
	private $metrics = [];

	public function register(Metric $metric) {
		$name = $metric->full_name;

		if (isset($this->metrics[$name])) {
			throw new PrometheusException("Metric name must be unique");
		}

		$this->metrics[$name] = $metric;

		return $metric;
	}

	public function getMetrics() {
		return $this->metrics;
	}
}
