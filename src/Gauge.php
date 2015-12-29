<?php

namespace Prometheus;

require_once(dirname(__FILE__) . '/Metric.php');

class Gauge extends Metric {
	public function __construct(array $opts = []) {
		parent::__construct($opts);
	}

	public function type() {
		return "gauge";
	}

	public function defaultValue() {
		return 0;
	}

	public function set($val) {
		$hash = $this->hashLabels($labels);
		if (!isset($this->values[$hash]))
			$this->values[$hash] = $this->defaultValue();

		$this->values[$hash] = $val;
	}
}
