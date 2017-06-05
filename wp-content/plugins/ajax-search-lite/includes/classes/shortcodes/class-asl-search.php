<?php
	if (!defined('ABSPATH')) die('-1');

	// [Shortcode] Search bar
	if (!class_exists("WD_ASL_Search_Shortcode")) {

		class WD_ASL_Search_Shortcode extends WD_ASL_Shortcode_Abstract {

			// Overall instance count (@var int)
			private static $instanceCount = 0;

			// Used in views, true if data view is printed
			private static $dataPrinted = false;

			// Instance count per search ID (@var array)
			private static $perInstanceCount = array();

			// Performs shortcode functionalisty (@param array|null $atts) @return string|void
			public function handle($atts) {
				$style = null;
				self::$instanceCount++;

				extract(shortcode_atts(array(
					'id' => 'something'
				), $atts));

				$inst = wd_asl()->instances->get(0);
				$style = $inst['data'];

				// Set the "_fo" item to indicate that the non-ajax search was made via this form, and save the options there
				if (isset($_POST['p_asl_data']) || isset($_POST['np_asl_data'])) {
					$_p_data = isset($_POST['p_asl_data']) ? $_POST['p_asl_data'] : $_POST['np_asl_data'];
					parse_str($_p_data, $style['_fo']);
				}

				$settingsHidden = ((
					w_isset_def($style['show_frontend_search_settings'], 1) == 1
				) ? false : true);

				do_action('asl_layout_before_shortcode', $id);

				$out = "";
				ob_start();
				include(ASL_PATH."includes/views/asl.shortcode.php");
				$out = ob_get_clean();

				do_action('asl_layout_after_shortcode', $id);

				return $out;
			}

			// Importing fonts does not work correctly it appears. Instead adding the links directly to the header is the best way to go.
			// EDIT: Do not do this. -Eric

			public function fonts() {
				$imports = array('https://fonts.googleapis.com/css?family=Open+Sans');
				$imports = apply_filters('asl_custom_fonts', $imports);

				foreach ($imports as $import) {
					$import = trim(str_replace(array("@import url(", ");", "https:", "http:"), "", $import));
					// echo "<link href='" . $import . "' rel='stylesheet' type='text/css'>";
				}
			}

			// Singleton specific
			public static function getInstance() {
				if ( ! ( self::$_instance instanceof self ) ) {
					self::$_instance = new self();
				}
				return self::$_instance;
			}
		}
	}
?>
