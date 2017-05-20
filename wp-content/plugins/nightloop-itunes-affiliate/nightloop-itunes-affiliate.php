<?php
	/*
	 Plugin Name: Nightloop iTunes Affiliate
	 Plugin URI: http://doublefeature.fm
	 Description: Adds a function to create iTunes affiliate javascript on every page.
	 Version: 1.0
	 Author: Eric Thirteen
	 Author URI: https://ericthirteen.com
	 License: CC3.0
	 */

	/**
	 * wp-content/plugins/nightloop-itunes-affiliate/nightloop-itunes-affiliate.php
	 */

add_action('wp_head','hook_itunes_affiliate');

function hook_itunes_affiliate() {
	$output="<script type='text/javascript'>var _merchantSettings=_merchantSettings || [];_merchantSettings.push(['AT', '10ln87']);(function(){var autolink=document.createElement('script');autolink.type='text/javascript';autolink.async=true; autolink.src= ('https:' == document.location.protocol) ? 'https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js' : 'http://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(autolink, s);})();</script>";
	echo $output;
}
