<?php
	if (!defined('ABSPATH')) die('-1');

	// An abstract for shortcode handlers
	if (!class_exists("WD_ASL_Shortcode_Abstract")) {
		abstract class WD_ASL_Shortcode_Abstract {

			// Static instance storage @var self
			protected static $_instance;

			// Get the instance
			public static function getInstance() {}

			// Called by the appropriate handler (@param $atts array|null)
			abstract public function handle( $atts );

			// Cloning disable
			protected function __clone() {}

			// Serialization disabled
			protected function __sleep() {}

			// De-serialization disabled
			protected function __wakeup() {}

		}
	}
?>
