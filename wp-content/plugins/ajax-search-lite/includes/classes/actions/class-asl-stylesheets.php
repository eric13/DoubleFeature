<?php
	if (!defined('ABSPATH')) die('-1');

	// Handles the non-ajax searches if activated
	if (!class_exists("WD_ASL_StyleSheets_Action")) {

		class WD_ASL_StyleSheets_Action extends WD_ASL_Action_Abstract {

			// Holds the inline CSS (@var string)
			private static $inline_css = "";

			// Bound as the handler
			public function handle() {
				if (function_exists('get_current_screen')) {
					$screen = get_current_screen();
					if (isset($screen) && isset($screen->id) && $screen->id == 'widgets')
						return;
				}

				add_action('wp_head', array($this, 'inlineCSS'), 10, 0);

				// Don't print if on the back-end
				if ( !is_admin() ) {
					$inst = wd_asl()->instances->get(0);
					$asl_options = $inst['data'];
					wp_register_style('wpdreams-asl-basic', ASL_URL.'css/style.basic.css', array(), ASL_CURR_VER_STRING);
					wp_enqueue_style('wpdreams-asl-basic');
					wp_enqueue_style('wpdreams-ajaxsearchlite', ASL_URL.'css/style-'.$asl_options['theme'].'.css', array(), ASL_CURR_VER_STRING);
				}

				self::$inline_css = "
				@font-face {
					font-family: 'aslsicons2';
					src: url('".str_replace('http:',"",plugins_url())."/ajax-search-lite/css/fonts/icons2.eot');
					src: url('".str_replace('http:',"",plugins_url())."/ajax-search-lite/css/fonts/icons2.eot?#iefix') format('embedded-opentype'),
						 url('".str_replace('http:',"",plugins_url())."/ajax-search-lite/css/fonts/icons2.woff2') format('woff2'),
						 url('".str_replace('http:',"",plugins_url())."/ajax-search-lite/css/fonts/icons2.woff') format('woff'),
						 url('".str_replace('http:',"",plugins_url())."/ajax-search-lite/css/fonts/icons2.ttf') format('truetype'),
						 url('".str_replace('http:',"",plugins_url())."/ajax-search-lite/css/fonts/icons2.svg#icons') format('svg');
					font-weight: normal;
					font-style: normal;
				}
				div[id*='ajaxsearchlite'].wpdreams_asl_container {
					width: ".$asl_options['box_width'].";
					margin: ".wpdreams_four_to_string($asl_options['box_margin']).";
				}
				div[id*='ajaxsearchliteres'].wpdreams_asl_results div.resdrg span.highlighted {
					font-weight: bold;
					color: ".$asl_options['highlight_color'].";
					background-color: ".$asl_options['highlight_bg_color'].";
				}
				div[id*='ajaxsearchliteres'].wpdreams_asl_results .results div.asl_image {
					width: ". $asl_options['image_width'] . "px;
					height: " . $asl_options['image_height'] . "px;
				}
				";
			}

			// Echos inline CSS if available
			public function inlineCSS() {
				if (self::$inline_css != "") {
					echo "
						<style type='text/css'>
							<!--
							" . self::$inline_css . "
							-->
						</style>";
				}

				// AJAX Page loader compatibility
				// If _ASL var is defined at this point, means the page was already loaded & the header script is executed again - but also means that ASL var is reset (due to localization script) and that page contend has changed, so ajax search pro is not initialized.
?>
				<script type="text/javascript">
					if (typeof _ASL !== "undefined" && _ASL !== null && typeof _ASL.initialize !== "undefined") {
						_ASL.initialize();
					}
				</script>
<?php
			}

			// Singleton Specific
			public static function getInstance() {
				if ( ! ( self::$_instance instanceof self ) ) {
					self::$_instance = new self();
				}
				return self::$_instance;
			}
		}
	}
?>
