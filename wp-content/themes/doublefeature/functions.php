<?php
/*
 Plugin Name: Double Feature
 Plugin URI: http://doublefeature.fm
 Description: Adds scripts needed for the Double Feature site.
 Version: 2.1
 Author: Eric Thirteen
 Author URI: https://ericthirteen.com
 License: CC3.0
 */

/**
 * Previously the Double Feature Plugin, now folded into the Double Feature theme.
 * Optimized for mobile,but would be a good idea to consolidate this and wptouch scripts.
 *
 * Requires wptouch/core/theme.php to demand include
 */

// Run jQuery for Free Download
if( !function_exists("run_scripts") ){
    function run_scripts() {
        
        // Script, location, list of script dependencies
        wp_register_script('jscript', get_theme_root_uri().'/doublefeature/jscript.js', array('jquery'));
        wp_enqueue_script('jscript');
        
    } add_action('wp_enqueue_scripts','run_scripts');
}

if( !function_exists("set_viewport") ){
	function set_viewport() {

		echo "<meta name='viewport' content='width=device-width'>";

	}
	add_action('wp_head', 'set_viewport');
}

// Removes styles invoked by previous plugins
if( !function_exists("remove_default_stylesheet") ){

	function remove_default_stylesheet() {

		wp_dequeue_style('contact-form-7');
		wp_deregister_style('wpdreams-asl-basic');
		wp_dequeue_style('wpdreams-asl-basic');
		wp_dequeue_style('wpdreams-ajaxsearchlite');
		wp_deregister_style('wpdreams-gf-opensans');
		wp_dequeue_style('wpdreams-gf-opensans');

	} add_action( 'wp_enqueue_scripts', 'remove_default_stylesheet', 999 );

}

// Purchase functions
if( !function_exists("hook_apple_pay") ){

	// Hooked by WP to run store JS andfunctions during wp_footer
	function hook_apple_pay() {

		// Use only on the Store page
		if( get_the_ID() == 10293 ){

			$output="

<script type='text/javascript' src='https://js.stripe.com/v2/'></script>
<script type='text/javascript'>

Stripe.setPublishableKey('pk_live_KRUHPzbRZhmwZ4mj7GuImk9b');
Stripe.applePay.checkAvailability(function(available) {
if (available) {
	document.getElementById('apple-pay-001').style.display = 'block';
	document.getElementById('apple-pay-002').style.display = 'block';
	document.getElementById('apple-pay-003').style.display = 'block';
	document.getElementById('apple-pay-004').style.display = 'block';
}
});

document.getElementById('apple-pay-001').addEventListener('click', function() { beginApplePay(001); });
document.getElementById('apple-pay-002').addEventListener('click', function() { beginApplePay(002); });
document.getElementById('apple-pay-003').addEventListener('click', function() { beginApplePay(003); });
document.getElementById('apple-pay-004').addEventListener('click', function() { beginApplePay(004); });

function beginApplePay(item) {

var dfLabel, dfAmount;
var dfCom = '/delivery?id=';

switch(item) {
	case 001:
		dfLabel ='Double Feature: Additional Content Y6';
		dfAmount = '9.99';
		dfCom += '48151623';
		break;
	case 002:
		dfLabel ='Double Feature: Additional Content Y7';
		dfAmount = '9.99';
		dfCom += '72218417';
		break;
	case 003:
		dfLabel ='Double Feature: Additional Content Y8';
		dfAmount = '9.99';
		dfCom += '73627820';
		break;
	case 004:
		dfLabel ='Double Feature: Additional Content Y9';
		dfAmount = '9.99';
		dfCom += '27577000';
		break;
}

dfCom += '&ap=1';

var paymentRequest = {
	countryCode: 'US',
	currencyCode: 'USD',
	total: {
		label: dfLabel,
		amount: dfAmount
	}
};

var session = Stripe.applePay.buildSession(paymentRequest,function(result, completion) {

	jQuery.post('https://doublefeature.fm/wp-content/themes/doublefeature/charge.php', { token: result.token.id }).done(function() {
		completion(ApplePaySession.STATUS_SUCCESS);
		window.location.href = dfCom;
	}).fail(function() {
		completion(ApplePaySession.STATUS_FAILURE);
	});
}, function(error) { console.log(error.message); });

session.begin();
}
</script>

			";
				echo $output;
			} else {
			return false;
		}

	}

	// Hook store function with wp_footer
	add_action('wp_footer','hook_apple_pay');

}

// Free AC Redirect for Mobile
if( !function_exists("free_ac_mobile") ){

	// Hooked by WP to run store JS andfunctions during wp_footer
	function free_ac_mobile($content) {

		// Use only on the Store page
		if( get_the_ID() == 10354 ){

			$userAgent = mobile_user_agent_switch();
			if ($userAgent != 0) {
				$return = "
					<script type='text/javascript'>
				if (document.getElementById('wptouch-search-inner')!=null) { window.location = 'https://doublefeature.fm/free-ac-episode?wptouch_switch=desktop'; }
					</script>";
			} else {
				$return = "";
			}

			return $return.$content;

		} else {
			return $content;
		}

	}

	// Add filter function to the hook
	add_action('the_content', 'free_ac_mobile');

}

// Use custom variables
if( !function_exists("add_query_vars_filter") ) {
	function add_query_vars_filter( $vars ){
		$vars[] = "id";
		$vars[] = "ap";
		$vars[] = "charge";
		return $vars;
	}
	add_filter('query_vars', 'add_query_vars_filter');
}

// Change all that wp-content stuff to "images" which will redirect form htaccess
if( !function_exists("urlImager") ) {
	function urlImager($img){
		return str_replace("wp-content/uploads/sites/8", "images", "$img");
	}
}

// Delivery page
if( !function_exists("deliverProduct") ){

	function deliverProduct($content) {

		if( get_the_ID() == 10186 ){

			$id = get_query_var('id');
			$ap = get_query_var('ap');
			$charge = get_query_var('charge');
			$default = "<script>window.location.href='/store';</script>There are no goods avalible for delivery. Items can be purchased from the Double Feature <a href=/store>store</a>.";
			if ( (!empty($charge) || !empty($ap)) && !empty($id) ){
				switch ($id){
					case 48151623:
						$item='Additional Content Y6';
						$img='double-feature-additional-content-6';
						$url='b4815162342-b8a';
						$price = '9.99';
						break;
					case 72218417:
						$item='Additional Content Y7';
						$img='double-feature-additional-content-7';
						$url='j7221ax8417-i6xt';
						$price = '9.99';
						break;
					case 73627820:
						$item='Additional Content Y8';
						$img='double-feature-additional-content-8';
						$url='_ety7362heuyw782';
						$price = '9.99';
						break;
					case 27577000:
						$item='Additional Content Y9';
						$img='double-feature-additional-content-9';
						$url='_kdu275cnthstw77';
						$price = '9.99';
						break;
					default:
						$return = $default;
				}
				if ( isset($ap) ) {
					$return = "Congratulations. Your payment went through!<br><br>Here's what you purchased:<br>". $item . "<br>From: Double Feature<br><br><strong>Total Paid: $price USD</strong><br><br>";
				}
				$return .= "<div class='storePic'><img src='/images/$img.jpg' alt='$item' style='height: 100px; width: 100px;' /></div><div class='storeInfo'><strong>$item</strong><br>Format: Digital<br><strong>Save your URL:</strong><br><a href='/$url' target='_blank'>https://doublefeature.fm/$url</a></div><p>Above is the delivery link for your purchase. The files are DRM free and can be re-downloaded an unlimited number of time. Please save the URL so you can return in the future. Thanks again for supporting the show!</p>";
			} else {

				$return = $default;

			}

			return $content.$return;


		} else {
			return $content;
		}
	}

	// Add filter function to the hook
	add_action('the_content', 'deliverProduct');

}

// Clean certain characters from the title
if( !function_exists("cleanTitle")){
	function cleanTitle($s) {
		$s = strtolower($s);
		$s = str_replace(":", "", "$s");
		$s = str_replace(".", "", "$s");
		$s = str_replace("?", "", "$s");
		$s = str_replace("!", "", "$s");
		$s = str_replace("'", "", "$s");
		$s = str_replace("’", "", "$s");
		$s = str_replace(",", "", "$s");
		$s = str_replace("(", "", "$s");
		$s = str_replace(")", "", "$s");
		$s = str_replace("…", "", "$s");
		$s = str_replace("/", "", "$s");
		$s = str_replace("\\", "", "$s");
		$s = str_replace(" ", "-", "$s");
		// Catch characters after encoding
		$s = urlencode($s);
		$s = str_replace("%26%238230%3B", "", "$s");
		$s = str_replace("%26%238216%3B", "", "$s");
		$s = str_replace("%26%238217%3B", "", "$s");
		$s = str_replace("%28", "", "$s");
		$s = str_replace("%29", "", "$s");
		$s = str_replace("%2F", "", "$s");
		return $s;
	}
}

// Killapalooza image urls don't have word Killapalooza or show number in URL
if( !function_exists("killapaloozaFixer")){
	function killapaloozaFixer($return) {
		$killapaloozaFixer = explode("-",$return);
		if ($killapaloozaFixer[0] == "killapalooza") {
			unset($killapaloozaFixer[0]);
			unset($killapaloozaFixer[1]);
			$return = implode("-",$killapaloozaFixer);
		}
		return $return;
	}
}

// Detects Mobile type. Redundant with a wptouch function, clean this up
if( !function_exists("mobile_user_agent_switch") ){
	function mobile_user_agent_switch($type="os") {
		$device = 0;

		// Returns numbers for easier case statement use

		// 0 = Other
		// 1 = iPhone
		// 2 = iPad
		// 3 = iPod touch
		// 4 = Android
		// 5 = Windows Phone
		// 6 = Blackberry

		// 0 = Other
		// 1 = iOS
		// 4 = Android
		// 5 = Windows Phone
		// 6 = Blackberry

		if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
			$device = 1;
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
			$device = 2;
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'ipod') ) {
			$device = 3;
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
			$device = 4;
		} else if( stristr($_SERVER['HTTP_USER_AGENT'],'windows phone') ) {
			$device = 5;
		} else if ( stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') ) {
			$device = 6;
		}

		switch ($device) {
			case 1:
			case 2:
			case 3:
				$os = 1;
				break;
			case 4:
				$os = 4;
				break;
			case 5:
				$os = 5;
				break;
			case 6:
				$os = 6;
				break;
			default:
				$os = 0;
		}

		if ($type=="device"){
			return $device;
		} else {
			return $os;
		}
	}
}

// Custom information and layout for posts (Mobile Version)
if( !function_exists("dfEpA")){

	function dfEpA($which){
		// Change only the content of posts, no pages
		if( is_single() && has_category('podcast') ){

			$episode = get_the_title();
			$episode = strtolower($episode);
			$episode = str_replace(" + ", "-", "$episode");
			$episode = str_replace(" ", "-", "$episode");
			$episode = str_replace("'", "", "$episode");
			$episode = str_replace("’", "", "$episode");
			$episode = str_replace(":", "", "$episode");
			$episode = str_replace("?", "", "$episode");
			$episode = str_replace(".", "", "$episode");
			$episode = str_replace(",", "", "$episode");
			$episode = str_replace("!", "", "$episode");
			$episode = str_replace("…", "", "$episode");
			$episode = str_replace("/", "", "$episode");
			$episode = str_replace("\\", "", "$episode");

			// Catch characters after encoding
			$episode = urlencode($episode);
			$episode = str_replace("%26%238230%3B", "", "$episode");
			$episode = str_replace("%26%238216%3B", "", "$episode");
			$episode = str_replace("%26%238217%3B", "", "$episode");
			$episode = str_replace("%28", "", "$episode");
			$episode = str_replace("%29", "", "$episode");
			$episode = str_replace("%2F", "", "$episode");

			$tracking = "http://media.blubrry.com/doublefeature/";
			$domain = "media.doublefeature.fm/";

			$fn = the_title("", "", false);
			$fn = explode(" + ", $fn);

			// Determine which year
			$cat = get_the_category();
			for ($i = 0; $i <count($cat); $i++) { $nn[$i] = $cat[$i]->category_nicename; }
			if (in_array("year1", $nn)) {

				// Year 1 episode on iTunes
				$newContent = "<div id='podcastStore'><a href='https://itunes.apple.com/album/year-1/id1017126800?app=itunes' target='_blank'><img src='/images/coverart-year-1_small.jpg' /></a><div>".get_the_title()."<br><a href='https://itunes.apple.com/album/year-1/id1017126800?app=itunes' target='_blank'>Available on iTunes</a><br>Double Feature | Year 1 (2009)</div></div>";

			} else if (in_array("year2", $nn)) {

				// Year 2 episode are offline
				$newContent = "<div id='podcastStore'><img src='/images/coverart-year-1_small.jpg' style='opacity: .3' /><div>".get_the_title()."<br>Year 2 (2010)<br>Currently offliine. Coming Soon to iTunes!</div></div>";

			} else if (in_array("year3", $nn)) {

				// Year 3 episode are offline
				$newContent = "<div id='podcastStore'><img src='/images/coverart-year-1_small.jpg' style='opacity: .3' /><div>".get_the_title()."<br>Year 3 (2011)<br>Currently offliine. Coming Soon to iTunes!</div></div>";

			} else {

				// iTunes ID
				$postID = get_the_ID();
				// Get itms post metadata
				$itmsEp = get_post_meta($postID,'itms',true);
				// Set the itms link
				$itms = "itms://itunes.apple.com/us/podcast/";
				$itms .= (empty($itmsEp)) ?  "id285298251" : $episode."/id285298251?i=".$itmsEp;

				// Create the full itms link
				$itms = "itms://itunes.apple.com/us/podcast/".$episode."/id285298251".$itms;

				// Create a simple 'tag' list which is actually from categories
				$categories = get_the_category();
				$separator = '';
				$output = '';
				if ( !empty($categories) ) {
					foreach($categories as $category) {
						$output .= "<a href='".esc_url(get_category_link($category->term_id))."' class='a-cat'>".esc_html($category->name)."</a>";
					}
					$list_of_cats = trim($output,$separator);
				}

				$my_ex = get_the_content();
				$my_ex = strip_tags($my_ex);
				$my_ex = substr($my_ex, 0, 140)."...";
				$the_post_date = get_the_date();

				$userAgent = mobile_user_agent_switch();

				// Start the podcast block content
				$newContent .= "<div style='float:left;display:inline-block;'>";

				if (has_post_thumbnail()) {

					// Set the featured image
					$featuredImageArray = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
					$featuredImage = $featuredImageArray['0'];
					$featuredImage = urlImager("$featuredImage");
					// Set the featured image thumbnail
					$featuredImageArray = wp_get_attachment_image_src( get_post_thumbnail_id(),'large' );
					$featuredImageThumb = $featuredImageArray['0'];
					$featuredImageThumb = urlImager($featuredImageThumb);

					$newContent .= "<a href='". $featuredImage ."' target='_blank' rel='lightbox'><img src='". $featuredImageThumb ."' alt='". get_the_title() ."' class='cvr2'/></a>";

				}
				$newContent .= "</div>";

				switch ($userAgent){
					case 1:
						$newContent .= "
						<div class='episodeActions'>
						<a href='$itms' rel='nofollow' class='ep-button icon-podcast'>Open in Podcasts App</a>
						</div>";
						break;
					case 4:
						$newContent .= "
						<div class='episodeActions'>
						<a href='https://play.google.com/music/m/Ik2rgchlg6ki33p5euheh2mbayu?t=Double_Feature.m4a' rel='nofollow' class='ep-button icon-gp'>Podcast on Google Play</a>
						<a href='". $tracking . $domain . $episode .".m4a' rel='nofollow' class='ep-button icon-stream'>Stream Episode</a>
						<a href='". $tracking . $domain . $episode .".m4a' rel='nofollow' class='ep-button icon-dl'>Download Episode</a>
						<a href='". $tracking . $domain . $episode .".m4a' rel='nofollow' class='ep-button icon-rss'>Subscribe</a>
						</div>";
						break;
					case 5:
					case 6:
						$newContent .= "
						<div class='episodeActions'>
						<a href='". $tracking . $domain . $episode .".m4a' rel='nofollow' class='ep-button icon-stream'>Stream Episode</a>
						<a href='". $tracking . $domain . $episode .".m4a' rel='nofollow' class='ep-button icon-dl'>Download Episode</a>
						<a href='". $tracking . $domain . $episode .".m4a' rel='nofollow' class='ep-button icon-rss'>Subscribe</a>
						</div>";
						break;
					default:

						$newContent .= "
						<div style='float: right; width: 330px;'>Podcast: Double Feature<br>
						<a href='$itms' rel='nofollow' class='ep-button icon-podcast'>Play in iTunes</a><a href='". $tracking . $domain . $episode .".m4a' rel='nofollow' class='ep-button icon-cloud'>Stream Episode</a><br>
						$my_ex<br><br>
						<span class='pod-date'>Posted $the_post_date</span><br>
						Hosted by Eric Thirteen & Michael Koester<br>
                        Tags:$list_of_cats</div>
						<h3>Episode Notes</h3>";
				}

				if ($userAgent != 0) {
					$newContent .= "$my_ex<br><br>
					<span class='pod-date'>Posted $the_post_date</span><br>
					Hosted by Eric Thirteen &amp; Michael Koester<br>
					<div class='someTags'>Tags: $list_of_cats</div></div>
                    <h3>Episode Notes</h3>";
				}


			}

			if ( !in_array("finale", $nn) && in_array("podcast", $nn) && $which=="bottom" ) {

				function gc($key, $echo = TRUE) {
					global $post;
					$custom_field = get_post_meta($postID, $key, true);
					if ($echo == FALSE) return $custom_field;
					echo $custom_field;
				}

				function gc_return($key, $echo = TRUE) {
					global $post;
					$custom_field = get_post_meta($postID, $key, true);
					if ($echo == FALSE) return $custom_field;
					return $custom_field;
				}

				function amazonLinker($s) {
					$s = str_replace("-", "+", "$s");
					$a = "https://amazon.com/gp/search?index=dvd&tag=tbmchicago-20&keywords=$s";
					return $a;
				}

				function iTunesLinker($s,$id="") {
					$a = "https://geo.itunes.apple.com/us/movie/".$s."/id".$id."?mt=6&at=10ln87";
					return $a;
				}

				// Creates the movie object with IMDB info
				class Movie {
					public $gctitle;
					public $gcimdb;
					public $gcwiki;
					public $amzn;
					public $itns;
					public $writers;
					public $director;
					public $desc;
					public $release;
					public $short;
					public $cast;
					public $ft = "jpg";

					public function __construct($i) {

						// Sets up the postID
						$postID = get_the_ID();

						// Figures out film titles based on episode title
						$f = the_title("", "", false);
						$f = explode(" + ", $f);
						$this->gctitle = $f[$i-1];

						// Wordpress stores information in variables labeled with a 1 or 2 instead of in an array.
						if ($i=="1") {
							$this->gcimdb = get_post_meta($postID, 'imdb1',true);
							$this->gcwiki = get_post_meta($postID, 'wiki1',true);
							$this->amzn = get_post_meta($postID, 'amzn1',true);
							$this->itns = get_post_meta($postID, 'itns1',true);
							$this->writers = get_post_meta($postID, 'write1',true);
							$this->director = get_post_meta($postID, 'dire1',true);
							$this->release = get_post_meta($postID, 'rele1',true);
							$this->cast = get_post_meta($postID, 'cast1',true);
							$this->desc = get_post_meta($postID, 'desc1',true);
						} else {
							$this->gcimdb = get_post_meta($postID, 'imdb2',true);
							$this->gcwiki = get_post_meta($postID, 'wiki2',true);
							$this->amzn = get_post_meta($postID, 'amzn2',true);
							$this->itns = get_post_meta($postID, 'itns2',true);
							$this->writers = get_post_meta($postID, 'write2',true);
							$this->director = get_post_meta($postID, 'dire2',true);
							$this->release = get_post_meta($postID, 'rele2',true);
							$this->cast = get_post_meta($postID, 'cast2',true);
							$this->desc = get_post_meta($postID, 'desc2',true);
						}

						// If the entry didn't finish getting filled out, try using an API for lookup
//						if ( empty($this->gcimdb) || empty($this->writers) || empty($this->director) || empty($this->cast) ||  empty($this->desc) ){

							// Query a third party IMDB API which retrieves a JSON
//							if ($this->gcimdb) {
//								$q = file_get_contents("http://www.omdbapi.com/?i=$this->gcimdb");
//							} else {
								// Don't have an IMDB? Let's try looking it up by title
//								$srchr = str_replace(" ", "%20", $this->gctitle);
//								$srchr = str_replace("’", "", $srchr);
//								$q = file_get_contents("http://www.omdbapi.com/?t=$srchr");
								// The search returns the json with brackets, even with only one result.  Remove the brackets.
//							}
//							$m = json_decode($q, true);

							// Prep other attributes
//							$this->writers = $m['Writer'];
//							$this->director = $m['Director'];
//							$this->desc = $m['Plot'];
//							$this->release = date("F j, Y", strtotime($m['Released']));
//							$this->cast = $m['Actors'];
//							$this->runtime = $m['Runtime'];

							// Alright, if we didn't have the IMDB to begin with let's set it.
//							if (!$this->gcimdb) { $this->gcimdb = $m['imdbID']; }

//						}

						$this->short = cleanTitle($this->gctitle);

						if (!$this->gcwiki) { $this->gcwiki = str_replace("-", "_", $this->short); }

						// Annoying exception if the jpg filetype just didn't cut it
						if ($this->short == "the-king-of-kong") { $this->ft = "png"; }

						// Make Amazon if it wasn't provided
						if (empty($this->amzn)) { $this->amzn = amazonLinker($this->short); }

						// Make iTunes Link
						$this->itns = (!empty($this->itns)) ? iTunesLinker($this->short,$this->itns) : NULL;

					}

					// Generates Director tag links if they have more than 1 tagged
					public function dlnk() {
						$d = $this->director;
						$tags = get_tags(array('name__like' => "$d"));
						$slugs = $tags[0]->slug;
						$nums = $tags[0]->count;
						if ($nums>1) { return "<a href=\"/tag/$slugs\">$d</a>"; } else { return $d; }
					}
				}

				// Create movie objects in an array
				if (in_array("killapalooza", $nn)){
					$mov = array(new Movie(1));
				} else {
					$mov = array(new Movie(1), new Movie(2));
				}

				$bottomContent =
				"<h3>Covers</h3>
				Click on a cover to view/download high resolution version.<br><br>";

				// Do a loop for each movie
				$i=0; while ($i < count($mov)){

					// Determine if it's the first or second box on the row
					if($i&1) { $whichbox = "b"; } else { $whichbox = "a";}

					$url = killapaloozaFixer($mov[$i]->short);

					// Create the moviebox
					$bottomContent .=  "<div id='movie-box-" . $whichbox . "'>";

					if (!empty($url)){
						$bottomContent .= "
						<a href='/images/covers/" .
						$url . "." . $mov[$i]->ft . "' rel='lightbox'><img src='/images/covers/thumbnails/thumbnail-" .
						$url . "." . $mov[$i]->ft . "' alt='" . $mov[$i]->gctitle . "' class='lbc' /></a>

						<h3>" . $mov[$i]->gctitle . "</h3>";

						if (!empty($mov[$i]->itns)) {
							$bottomContent .= "<a href='" . $mov[$i]->itns . "' target='_blank' class='boxLink'><button class='store-button'><div class='store-itunes-button'></div></button></a>";
						}

						$bottomContent .= "<a href='" . $mov[$i]->amzn . "' target='_blank' class='boxLink'><button class='store-button'><div class='store-amazon-button'></div></button></a>

						<br>";
					}

					// Since empty release defaults to January 1, 1970, assume no runtime means no release
					if ($mov[$i]->runtime != "") {
                        $bottomContent .= "Released: " . $mov[$i]->release . "<br>Runtime: ". $mov[$i]->runtime . " | ";
                    } elseif ($mov[$i]->release != "") {
                        $bottomContent .= "Released: " . $mov[$i]->release . "<br>";
                    }

					// Create IMDB and Wiki links
					if (!in_array("killapalooza", $nn)) {
						// Normal instance
						if (!empty($mov[$i]->gcimdb)) {
							$bottomContent .=  "
							<a href='http://imdb.com/title/" . $mov[$i]->gcimdb . "' rel='nofollow' target='_blank'>IMDB</a>";
						}
						if (!empty($mov[$i]->gcimdb) && !empty($mov[$i]->gcwiki)) {
							$bottomContent .= " | ";
						}
						if (!empty($mov[$i]->gcwiki)) {
							$bottomContent .= "
							<a href='https://wikipedia.org/wiki/" . $mov[$i]->gcwiki . "' rel='nofollow' target='_blank'>Wikipedia</a>";
						}
						if (!empty($mov[$i]->gcimdb) || !empty($mov[$i]->gcwiki)) {
							$bottomContent .= "<br><br>";
						}
					} else {
						// Killapalooza instance
						$franchise = the_title("", "", false);
						// If there actually is one!
						if (!empty($franchise)) {
							$franchise = explode(": ", $franchise);
							$franchise = $franchise[1];
							$bottomContent .= "
							<a href='http://imdb.com/find?q=" . str_replace(" ","+", $franchise) . "&s=tt&ttype=ft' rel='nofollow' target='_blank'>IMDB</a> |
							<a href='https://wikipedia.org/wiki/" . str_replace(" ","_", $franchise) . "_(franchise)' rel='nofollow' target='_blank'>Wikipedia</a>";
						}
					}

					// Generate director links
					$director = $mov[$i]->dlnk();

					if ($mov[$i]->director != "") { $bottomContent .= "Director: " . $mov[$i]->dlnk() . "<br>"; }
					if ($mov[$i]->writers != "") { $bottomContent .= "Writer: " . $mov[$i]->writers . "<br>"; }
					if ($mov[$i]->cast != "") { $bottomContent .= "Starring: " . $mov[$i]->cast . "<br><br>"; }
					if ($mov[$i]->desc != "") { $bottomContent .= $mov[$i]->desc . "<br><br>";}

					$bottomContent .= "</div>";

					$i++;
				}

			}

			// Add newContent to the original content
			if ($which == "top") {
				return $newContent;
			} elseif ($which == "bottom") {
				return $bottomContent . "<div style='clear: both;'>&nbsp;</div>";
			}

		} else {
			// Pages return only their original content
			return false;
		}
	}

}

// Create Member Login Window
function createLoginBox() {
	$return = "
			<div id='memberBox' style='text-align: center;'>
				<h3 style='font-size:2em;font-weight: 400;'>Members</h3>
				<p style='margin: 12px 0; font-size: 1.05em;display:block;'>Access the Double Feature cloud library.</p>
				<div class='swpm-login-widget-form'>
					<form id='swpm-login-form' name='swpm-login-form' method='post' action=''>
						<div class='swpm-login-form-inner'>
							<div class='swpm-username-label'>
								<label for='swpm_user_name' class='swpm-label'>Email Address</label>
							</div>
							<div class='swpm-username-input'>
								<input type='text' class='swpm-text-field swpm-username-field' id='swpm_user_name' value='' size='25' name='swpm_user_name' placeholder='Email Address'>
							</div>
							<div class='swpm-password-label'>
								<label for='swpm_password' class='swpm-label'>Password</label>
							</div>
							<div class='swpm-password-input'>
								<input type='password' class='swpm-text-field swpm-password-field' id='swpm_password' value='' size='25' name='swpm_password' placeholder='Password'>
							</div>
							<div class='swpm-remember-me'>
								<span class='swpm-remember-checkbox'><input type='checkbox' name='rememberme' value='checked='checked''></span><span class='swpm-rember-label'> Remember Me</span>
							</div>
							<div class='swpm-before-login-submit-section'></div>
							<div class='swpm-login-submit'>
								<input type='submit' class='swpm-login-form-submit' name='swpm-login' value=' '>
							</div>
							<div class='swpm-forgot-pass-link'>
								<a id='forgot_pass' class='swpm-login-form-pw-reset-link' href='https://doublefeature.fm/members/reset-password' sl-processed='1'>Reset Password</a>
							</div>
							<div class='swpm-login-action-msg'>
								<span class='swpm-login-widget-action-msg'></span>
							</div>
						</div>
					</form>
				</div>
				<p style='text-align:left; font-size: 1.05em;'><a href='https://patreon.com/doublefeature'>Join us!</a> DoubleFeature.fm members can login and gain access to the entire podcast library for stream or download. There are numerous bonus content, themes, commentarys, videos and more avalible when you sign up! <a href='https://patreon.com/doublefeature'>Register on Patreon</a> for ongoing access to the entire cloud library and exclusives only avaliable to members.</p>
				</div>
	";
	return $return;
}

//  Check Login, supply jQuery and Box if needed
if( !function_exists("memberLoginWidget")){

	// Hooked by WP to run gallery code during the_content
	function memberLoginWidget($content){

			// Check if user logged in
			$auth = SwpmAuth::get_instance();
			$level = $auth->get('membership_level');

			// User isn't logged in. Disable members link and show login popup instead
			if (!$level){
				$return = "
					<script>
					jQuery('#menu-item-11649 a').click(function() { return false; });
					jQuery('#menu-item-11649 a').click(function() {
						jQuery('#blackestOut').fadeIn(200,function(){});
						jQuery('#memberOuter').fadeIn(200, function() {
							jQuery('#swpm_user_name').focus();
							jQuery('#blackestOut').click(function() {
								jQuery('#blackestOut').fadeOut(50,function(){});
								jQuery('#memberOuter').fadeOut(50, function(){});
							});
						});
					});
					</script>
					<div id='memberOuter'><div id='memberArea'>
				";
				$return .= createLoginBox();
				$return .= "<div id='blackestOut'></div></div></div>";
			} else {
				$return = false;
			}

			return $content.$return;
	}

	// Add function to the hook
	add_action('the_content', 'memberLoginWidget');
}

// Shortcode [showloginwindow]
function funct_showloginwindow() {
	// If used as a shotcode, needs some style tweaks
	$return = "
		<style>
			#content .entry-title {
				display:none;
			}
			#content #memberBox {
				position: initial;
				border: none;
				font-size: 1em;
				width: initial;
				padding: 0;
				margin-top: -24px;
			}
			#content #memberArea {
				display:none;
			}
			#content #memberOut {
				z-index: 0;
			}
		</style>
	";
	$return .= createLoginBox();
	return $return;
} add_shortcode('showloginwindow','funct_showloginwindow');
    
// Shortcode [twitter (status,date,status,text) user,at,type]
function funct_twitter($atts) {
    $t = shortcode_atts(array('status'=>'','date'=>'','user'=>'Eric Thirteen','at'=>'eric_x13','type'=>'tweet'),$atts,'twitter' );
    if ($t['type'] != 'video') { $t['type']='tweet'; }
	$return = "<blockquote class='twitter-". $t['type'] ."' data-lang='en'><p lang='en' dir='ltr'>". $t['text'] ."</p>&mdash; ". $t['user'] ." (@". $t['at'] .") <a href='https://twitter.com/". $t['at'] ."/status/". $t['status'] ."'>". $t['date'] ."</a></blockquote> <script async src='//platform.twitter.com/widgets.js' charset='utf-8'></script>";
	return $return;
} add_shortcode('twitter','funct_twitter');

// Shortcode [showgallery (view=az)]
function funct_showgallery($atts){
	$v = shortcode_atts( array('kind' => 'gv'), $atts );
	// Clean up a title type string
	function prettyString($string) {

		// Correct for starting with "The " or "A "
		if ( substr($string, 0, 4) == "The " ){
			$return = substr($string, 4);
			$return .= ", The";
		} else if ( substr($string, 0, 2) == "A " ){
			$return = substr($string, 2);
			$return .= ", A";
		} else {
			$return = $string;
		}

		// Correct for Killapalooza
		if ( substr($return, 0, 13) == "Killapalooza " ){
			$return = substr($return, 16);
			$return = trim($return, " ");
			// Add to titles
			if ($return=="Child's Play"){ $return = "Child's Play (Chucky Series)"; }
			else if ($return=="Friday the 13th"){ $return = "Friday the 13th (Jason Series)"; }
			else if ($return=="A Nightmare on Elm Street"){ $return = "A Nightmare on Elm Street (Freddy Krueger Series)"; }
			else if ($return=="Texas Chainsaw Massacre"){ $return = "Texas Chainsaw Massacre (Leatherface Series)"; }
			else if ($return=="Halloween"){ $return = "Halloween (Michael Myers Series)"; }
			else if ($return=="Hellraiser"){ $return = "Hellraiser (Pinhead Series)"; }
			else if ($return=="Alien + Predator"){ $return = "Predator (Series)"; }
			else { $return="$return (Series)"; }
		}

		return $return;

	}

	// Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
	global $wpdb;
	$ars = $wpdb->get_results( "SELECT * FROM wp_8_posts WHERE post_type='post' AND post_status='publish' ORDER BY post_title ASC", OBJECT );

	$array = array();

	for ($i = 0; $i < count($ars); $i++){

		// Set up a first name
		$name = $ars[$i]->post_title;
		$name1 = strtok($name, "+");
		$name1 = trim($name1, " ");
		$echo1 = prettyString($name1);

		// Set up a second name
		$name2 = str_replace("$name1 + ", "", "$name");
		$echo2 = prettyString($name2);

		// Forms the URL to permalink style domain.com/year/short
		$url_date = $ars[$i]->post_date;
		$url_date = substr($url_date, 0, 4);
		$url_date = str_replace("-", "/", "$url_date");
		$url_short = $ars[$i]->post_name;
		$url = "/$url_date/$url_short";

		// Put entry 1 in array
		$array[$i][1] = $echo1;
		$array[$i][2] = $url;
		$array[$i][3] = $name1;

		// Put entry 2 in array
		$fi = $i+count($ars);
		$array[$fi][1] = $echo2;
		$array[$fi][2] = $url;
		$array[$fi][3] = $name2;

	}

	sort($array);

	for ($i = 0; $i < (count($ars)*2); $i++){
		// Exceptions that don't have gallery images
		if ($array[$i][1] != $array[$i-1][1]
			&& substr($array[$i][1], 0, 18) != "Music Box Massacre"
			&& substr($array[$i][1], 0, 15) != "Double Feature ") {

			if( $v['kind'] != "az"){
				// Show images on Gallery page

				$eurl = $array[$i][3];
				$eurl = strtolower($eurl);
				$eurl = cleanTitle($eurl);
				
				// Add extension
				if ($eurl == "the-king-of-kong") {
					$eurl .= ".png";
				} else {
					$eurl .= ".jpg";
				}
				
				// Correct Killapalooza Links
				$eurl = killapaloozaFixer($eurl);
				
				$return .= "<a href=". $array[$i][2] ."><img src=/images/covers/tiny/tiny-$eurl alt=\"" . $array[$i][1] . "\"  class='galThumb' align='left' /></a>";


			} else {
				// Show text links on Gallery (A-Z) page
				$return .= "<a href=". $array[$i][2] .">".$array[$i][1]."</a><br>";
				
			}
		}
	}
	
	$return .= '<div style="clear: both;"">&nbsp;</div>';
	
	return $content . $return;

} add_shortcode('showgallery','funct_showgallery');

// Shortcode [showmemberpage]
function funct_showmemberpage() {

	// Incomplete
	// To do: Throw in a 'if this year-x ac page doesn't exist, go to its permanant counterpart.''

	$auth = SwpmAuth::get_instance();
	$level = $auth->get('membership_level');

	function make_div_by_slug($slug,$enabler=TRUE){
		$page = get_page_by_path("/members/content/".$slug);
		$title = get_the_title($page->ID);
		$thumbID = get_post_thumbnail_id($page->ID,'thumbnail');
		$thumbArray = wp_get_attachment_image_src( $thumbID,'thumbnail' );
		if ($enabler){
			$return = "<div class='memThumb'><a href='/members/content/$slug'><img src='".$thumbArray[0]."' alt='$title'></a><div>$title</div></div>";
		} else {
			$return = "<div class='memThumb disabled'><img src='".$thumbArray[0]."' alt='$title'><div>$title</div></div>";
		}
		return $return;
	}

	// Function processes an array of items and if they're enabled or not.
	function runThe($jewels) {
		foreach ($jewels as $jewel) {
			$item = $jewel[0];
			$enabler = isset($jewel[1]) && $jewel[1]==0 ? FALSE : TRUE;

			if ($item=="LEGACY"){
				// Give user upgrade message
				$send .= "<p>Thanks for supporting previous Kickstarters. We wanted to say thank you, so we moved all your content into a Double Feature account.</p><a href='https://patreon.com/doublefeature' style='text-decoration:none;font-weight:500;font-size:1em;padding:10px 20px;background:#36E;color:#FFF;border-radius:4px;cursor:pointer;'>Upgrade to Full Account</a><p style='margin-top:24px;'>If you want to unlock the remaining content, you can <a href='https://patreon.com/doublefeature'>upgrade</a> for a few dollars via Patreon. Use the same email address at checkout and we'll apply the changes here!</p>";
			} elseif ($item[0]=="<") {
				// Probably a Header instead of content
				$send .=  $item;
			} elseif ($item[0]=="Y") {
				// Probably a Double Feature Year
				$send .= make_div_by_slug('double-feature-year-'.substr($item,1),$enabler);
			} elseif (substr($item,0,2)=="AC") {
				// Probably Double Feature Additional Content
				$send .= make_div_by_slug('additional-content-year-'.substr($item,2),$enabler);
			} else {
				// Some other content item to show
				$send .= make_div_by_slug($item,$enabler);
			}
		}
		return $send;
	}

	// Switch creates multidimensional array full of "[name or abbreviate of content][enabled]" arrays
	switch ($level) {
		case 2:
			// Admin
		case 3:
			// Showrunner
			$jewels = [
				array('Y1'),
				array('Y2'),
				array('Y3'),
				array('Y4'),
				array('Y5'),
				array('Y6'),
				array('Y7'),
				array('Y8'),
				array('Y9'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8'),
				array('_kdu275cnthstw77'),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary')
			];
			break;
		case 4:
			// Executive Producer
			$jewels = [
				array('Y1'),
				array('Y2'),
				array('Y3'),
				array('Y4'),
				array('Y5'),
				array('Y6'),
				array('Y7'),
				array('Y8'),
				array('Y9'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8'),
				array('_kdu275cnthstw77'),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('<h3>Unlockable Content</h3>'),
				array('themes-and-commentary',0)
			];
			break;
		case 5:
			// Additional Content Tier Member
			$jewels = [
				array('Y1'),
				array('Y2'),
				array('Y3'),
				array('Y4'),
				array('Y5'),
				array('Y6'),
				array('Y7'),
				array('Y8'),
				array('Y9'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8'),
				array('_kdu275cnthstw77'),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('<h3>Unlockable Content</h3>'),
				array('themes-and-commentary',0)
			];
			break;
		case 6:
			// Cloud tier Member
			$jewels = [
				array('Y1'),
				array('Y2'),
				array('Y3'),
				array('Y4'),
				array('Y5'),
				array('Y6'),
				array('Y7'),
				array('Y8'),
				array('Y9'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8'),
				array('AC9'),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('<h3>Unlockable Content</h3>'),
				array('AC9',0),
				array('themes-and-commentary',0)
			];
			break;
		case 7:
			// Subscriber
			$jewels = [
				array('Y1'),
				array('Y2'),
				array('Y3'),
				array('Y4'),
				array('Y5'),
				array('Y6'),
				array('Y7'),
				array('Y8'),
				array('Y9'),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('<h3>Unlockable Content</h3>'),
				array('AC6',0),
				array('AC7',0),
				array('AC8',0),
				array('AC9',0),
				array('AC10',0),
				array('themes-and-commentary',0)
			];
			break;
		case 8:
			// LEGACY-Y9A-Y8A-Y7A-Y6A-Y1-Y2-Y3-C
			$jewels = [
				array('LEGACY'),
				array('Y1'),
				array('Y2'),
				array('Y3'),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8'),
				array('_kdu275cnthstw77'),
				array('AC10',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary')
			];
			break;
		case 9:
			// LEGACY-Y9A-Y8A-Y7A-Y6A-Y1-Y2-Y3
			$jewels = [
				array('LEGACY'),
				array('Y1'),
				array('Y2'),
				array('Y3'),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8'),
				array('_kdu275cnthstw77'),
				array('AC10',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 10:
			// LEGACY-Y9A-Y8A-Y7A-Y6A-Y1
			$jewels = [
				array('LEGACY'),
				array('Y1'),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8'),
				array('_kdu275cnthstw77'),
				array('AC10',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 11:
			// LEGACY-Y9A-Y8A-Y7A-Y6A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8'),
				array('_kdu275cnthstw77'),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 12:
			// LEGACY-Y9A-Y8A-Y7A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6',0),
				array('AC7'),
				array('AC8'),
				array('_kdu275cnthstw77'),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 13:
			// LEGACY-Y9A-Y8A-Y6A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7',0),
				array('AC8'),
				array('_kdu275cnthstw77'),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 14:
			// LEGACY-Y9A-Y8A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6',0),
				array('AC7',0),
				array('AC8'),
				array('_kdu275cnthstw77'),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 15:
			// LEGACY-Y9A-Y6A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7',0),
				array('AC8',0),
				array('_kdu275cnthstw77'),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 16:
			// LEGACY-Y9A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6',0),
				array('AC7',0),
				array('AC8',0),
				array('_kdu275cnthstw77'),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 17:
			// LEGACY-Y8A-Y7A-Y6A-Y3-Y2-Y1
			$jewels = [
				array('LEGACY'),
				array('Y1'),
				array('Y2'),
				array('Y3'),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8'),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 18:
			// LEGACY-Y8A-Y7A-Y6A-Y1
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8'),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1'),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 19:
			// LEGACY-Y8A-Y7A-Y6A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8'),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 20:
			// LEGACY-Y8A-Y7A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6',0),
				array('AC7'),
				array('AC8'),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 21:
			// LEGACY-Y8A-Y6A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7',0),
				array('AC8'),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 22:
			// LEGACY-Y8A-Y1
			$jewels = [
				array('LEGACY'),
				array('Y1'),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>Additional Content</h3>'),
				array('AC6',0),
				array('AC7',0),
				array('AC8'),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 23:
			// LEGACY-Y8A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6',0),
				array('AC7',0),
				array('AC8'),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 24:
			// LEGACY-Y7A-Y6A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8',0),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 25:
			// LEGACY-Y7A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6',0),
				array('AC7'),
				array('AC8',0),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 26:
			// LEGACY-Y6A-Y1
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7',0),
				array('AC8',0),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1'),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 27:
			// LEGACY-Y6A
			$jewels = [
				array('LEGACY'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7',0),
				array('AC8',0),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>Full Library</h3>'),
				array('Y1',0),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
		case 28:
			// LEGACY-Y1-Y2-Y3
			$jewels = [
				array('LEGACY'),
				array('Y1'),
				array('Y2'),
				array('Y3'),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>Additional Content</h3>'),
				array('AC6',0),
				array('AC7',0),
				array('AC8',0),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 29:
			// LEGACY-Y1
			$jewels = [
				array('LEGACY'),
				array('Y1'),
				array('Y2',0),
				array('Y3',0),
				array('Y4',0),
				array('Y5',0),
				array('Y6',0),
				array('Y7',0),
				array('Y8',0),
				array('Y9',0),
				array('<h3>Additional Content</h3>'),
				array('AC6',0),
				array('AC7',0),
				array('AC8',0),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
		case 30:
			// Subscriber+Y7+Y6
			$jewels = [
				array('Y1'),
				array('Y2'),
				array('Y3'),
				array('Y4'),
				array('Y5'),
				array('Y6'),
				array('Y7'),
				array('Y8'),
				array('Y9'),
				array('<h3>Additional Content</h3>'),
				array('AC6'),
				array('AC7'),
				array('AC8',0),
				array('_kdu275cnthstw77',0),
				array('AC10',0),
				array('<h3>More Access</h3>'),
				array('extra-bonuses'),
				array('themes-and-commentary',0)
			];
			break;
	}
	// Returns
	if ($level){
		return runThe($jewels)."<h3 style='margin-top:50px'>Settings</h3><a href=/members/profile>Go to Profile</a>";
	} else {
		// Using shortcode version so on-page style is included
		return funct_showloginwindow();
	}

} add_shortcode('showmemberpage','funct_showmemberpage');

?>
