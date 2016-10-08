<?php
	/*
	 Plugin Name: Double Feature
	 Plugin URI: http://doublefeature.fm
	 Description: Adds scripts needed for the Double Feature site.
	 Version: 2.0
	 Author: Eric Thirteen
	 Author URI: https://ericthirteen.com
	 License: CC3.0
	 */

	/**
	 * wp-content/plugins/double-feature-scripts/double-feature-scripts.php
	 *
	 * The cleanest version of the Double Feature script, currently in use as
	 * its own plugin and in the Double Feature theme. Optimized for mobile,
	 * but would be a good idea to consolidate these three scripts.
	 *
	 * Requires wptouch/core/theme.php to demand include
	 */

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
			$s = str_replace(" ", "-", "$s");
			// Catch characters after encoding
			$s = urlencode($s);
			$s = str_replace("%26%238230%3B", "", "$s");
			$s = str_replace("%26%238216%3B", "", "$s");
			$s = str_replace("%26%238217%3B", "", "$s");
			$s = str_replace("%28", "", "$s");
			$s = str_replace("%29", "", "$s");
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
	if( !function_exists('mobile_user_agent_switch') ){
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

				// Catch characters after encoding
				$episode = urlencode($episode);
				$episode = str_replace("%26%238230%3B", "", "$episode");
				$episode = str_replace("%26%238216%3B", "", "$episode");
				$episode = str_replace("%26%238217%3B", "", "$episode");
				$episode = str_replace("%28", "", "$episode");
				$episode = str_replace("%29", "", "$episode");

				$tracking = "http://media.blubrry.com/doublefeature/";
				$domain = "doublefeature.fm/media/";

				$fn = the_title("", "", false);
				$fn = explode(" + ", $fn);

				// Determine which year
				$cat = get_the_category();
				for ($i = 0; $i <count($cat); $i++) { $nn[$i] = $cat[$i]->category_nicename; }
				if (in_array("year1", $nn)) {

					// Year 1 episode on iTunes
					$newContent = "<div id='podcastStore'><a href='https://itunes.apple.com/us/album/year-1/id1017126800' target='_blank'><img src='/images/coverart-year-1_small.jpg' /></a><div>".get_the_title()."<br /><a href='https://itunes.apple.com/us/album/year-1/id1017126800' target='_blank'>Available on iTunes</a><br />Double Feature | Year 1 (2009)</div></div>";

				} else if (in_array("year2", $nn)) {

					// Year 2 episode are offline
					$newContent = "<div id='podcastStore'><img src='/images/coverart-year-1_small.jpg' style='opacity: .3' /><div>".get_the_title()."<br />Year 2 (2010)<br />Currently offliine. Coming Soon to iTunes!</div></div>";

				} else if (in_array("year3", $nn)) {

					// Year 3 episode are offline
					$newContent = "<div id='podcastStore'><img src='/images/coverart-year-1_small.jpg' style='opacity: .3' /><div>".get_the_title()."<br />Year 3 (2011)<br />Currently offliine. Coming Soon to iTunes!</div></div>";

				} else {

					// If there's no specific itms number, use the generic one
					$postID = get_the_ID();
					$itms = "?i=".get_post_meta($postID, 'itms',true);
					if (!$itms) { $itms = ""; }

					// Create the full itms link
					$itms = "itms://itunes.apple.com/us/podcast/".$episode."/id285298251".$itms;

					// Create a simple 'tag' list which is actually from categories
					$categories = get_the_category();
					$separator = ' ';
					$output = '';
					if ( ! empty( $categories ) ) {
						foreach( $categories as $category ) {
							$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator ;
						}
						$list_of_cats =  trim( $output, $separator );
					}

					$my_ex = get_the_content();
					$my_ex = strip_tags($my_ex);
					$my_ex = substr($my_ex, 0, 140)."...";
					$the_post_date = get_the_date();

					$userAgent = mobile_user_agent_switch();

					// Different output for different devices
					if ($userAgent != 0) {
						$newContent = "
							<div class='playStream post-page-thumbnail'><a href='". $tracking . $domain . $episode .".m4a' rel='nofollow'><img src='/images/playStream.png' class='playStream post-thumbnail wp-post-image wp-post-image' alt='Play Episode'></a>
							</div>";
					} else {
						$newContent = "";
					}

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
								<style type='text/css'>img.cvr { display: none; }</style>
								<div style='float: left; display: inline-block;'><a href='/images/episodes/$episode.jpg' target='_blank' rel='lightbox'><img src='/images/episodes/small/sm_$episode.jpg' alt='". get_the_title() ."' class='cvr2'/></a></div>
								<div style='float: right; width: 330px;'>Podcast: Double Feature<br>
								<a href='$itms' rel='nofollow' class='ep-button icon-podcast'>Play in iTunes</a><a href='". $tracking . $domain . $episode .".m4a' rel='nofollow' class='ep-button icon-cloud'>Stream Episode</a><br>
								$my_ex<br><br>
								<span class='pod-date'>Posted $the_post_date</span><br>
								Hosted by Eric Thirteen & Michael Koester<br>
								Tags: $list_of_cats</div>
								<h3>Episode Notes</h3>";
					}

					if ($userAgent != 0) {
						$newContent .= "$my_ex<br><br>
						<span class='pod-date'>Posted $the_post_date</span><br>
						Hosted by Eric Thirteen & Michael Koester<br>
						<div class='someTags'>Tags: $list_of_cats</div></div>";
					}


				}

				if ( !in_array("finale", $nn) && $which=="bottom" ) {

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

					function iTunesLinker($s) {
						$s = str_replace("-", "", "$s");
						$a = "https://itunes.com/movie/$s";
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

							// Figures out film titles based on episode title
							$f = the_title("", "", false);
							$f = explode(" + ", $f);
							$this->gctitle = $f[$i-1];

							// Wordpress stores information in variables labeled with a 1 or 2 instead of in an array.
							if ($i=="1") {
								$this->gcimdb = gc_return(imdb1);
								$this->gcwiki = gc_return(wiki1);
								$this->amzn = gc_return(amzn1);
								$this->itns = gc_return(itns1);
							} else {
								$this->gcimdb = gc_return(imdb2);
								$this->gcwiki = gc_return(wiki2);
								$this->amzn = gc_return(amzn2);
								$this->itns = gc_return(itns2);
							}

							// Query a third party IMDB API which retrieves a JSON
							if ($this->gcimdb) {
								$q = file_get_contents("http://www.omdbapi.com/?i=$this->gcimdb");
							} else {
								// Don't have an IMDB? Let's try looking it up by title
								$srchr = str_replace(" ", "%20", $this->gctitle);
								$srchr = str_replace("’", "", $srchr);
								$q = file_get_contents("http://www.omdbapi.com/?t=$srchr");
								// The search returns the json with brackets, even with only one result.  Remove the brackets.
							}
							$m = json_decode($q, true);

							// Prep other attributes
							$this->writers = $m['Writer'];
							$this->director = $m['Director'];
							$this->desc = $m['Plot'];
							$this->release = date("F j, Y", strtotime($m[Released]));
							$this->short = cleanTitle($this->gctitle);
							$this->cast = $m[Actors];
							$this->runtime = $m[Runtime];

							// Alright, if we didn't have the IMDB to begin with let's set it.
							if (!$this->gcimdb) { $this->gcimdb = $m['imdbID']; }
							if (!$this->gcwiki) { $this->gcwiki = str_replace("-", "_", $this->short); }

							// Annoying exception if the jpg filetype just didn't cut it
							if ($this->short == "the-king-of-kong") { $this->ft = "png"; }

							// Make Amazon and iTunes links if they weren't provided
							if (!$this->amzn) { $this->amzn = amazonLinker($this->short); }
							if (!$this->itns) { $this->itns = iTunesLinker($this->short); }

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
					Click on a cover to view/download high resolution version.<br /><br />";

					// Do a loop for each movie
					$i=0; while ($i < count($mov)){

						// Determine if it's the first or second box on the row
						if($i&1) { $whichbox = "b"; } else { $whichbox = "a";}

						$url = killapaloozaFixer($mov[$i]->short);

						// Create the moviebox
						$bottomContent .=  "
						<div id='movie-box-" . $whichbox . "'>

						<a href='/images/covers/" .
						$url . "." . $mov[$i]->ft . "' rel='lightbox'><img src='/images/covers/thumbnails/thumbnail-" .
						$url . "." . $mov[$i]->ft . "' alt='" . $mov[$i]->gctitle . "' class='lbc' /></a>

						<h3>" . $mov[$i]->gctitle . "</h3>

						<a href='" . $mov[$i]->itns . "' target='_blank' class='itns_btn' > </a>
						<a href='" . $mov[$i]->amzn . "' target='_blank' class='amazn_btn' > </a>

						<br />";

						// Since empty release defaults to January 1, 1970, assume no runtime means no release
						if ($mov[$i]->runtime != "") { $bottomContent .= "Released: " . $mov[$i]->release . "<br />Runtime: ". $mov[$i]->runtime . " | "; }

						// Create IMDB and Wiki links
						if (!in_array("killapalooza", $nn)) {
							// Normal instance
							$bottomContent .=  "
							<a href='http://imdb.com/title/" . $mov[$i]->gcimdb . "' rel='nofollow' target='_blank'>IMDB</a> |
							<a href='https://wikipedia.org/wiki/" . $mov[$i]->gcwiki . "' rel='nofollow' target='_blank'>Wikipedia</a><br /><br />";
						} else {
							// Killapalooza instance
							$franchise = the_title("", "", false);
							$franchise = explode(": ", $franchise);
							$franchise = $franchise[1];
							$bottomContent .= "
							<a href='http://imdb.com/find?q=" . str_replace(" ","+", $franchise) . "&s=tt&ttype=ft' rel='nofollow' target='_blank'>IMDB</a> |
							<a href='https://wikipedia.org/wiki/" . str_replace(" ","_", $franchise) . "_(franchise)' rel='nofollow' target='_blank'>Wikipedia</a>";
						}

						// Generate director links
						$director = $mov[$i]->dlnk();

						if ($mov[$i]->director != "") { $bottomContent .= "Director: " . $mov[$i]->dlnk() . "<br />"; }
						if ($mov[$i]->writers != "") { $bottomContent .= "Writer: " . $mov[$i]->writers . "<br />"; }
						if ($mov[$i]->cast != "") { $bottomContent .= "Starring: " . $mov[$i]->cast . "<br /><br />"; }
						if ($mov[$i]->desc != "") { $bottomContent .= $mov[$i]->desc . "<br /><br />";}

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

	//  Creat the A-Z list or Gallery List
	if( !function_exists("dfGalleryGenerator")){

		function dfGalleryGenerator($content){
			// Use only on the Gallery page

			if( get_the_ID() == 1774 || get_the_ID() == 662 ){

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
					if ($array[$i][1] != $array[$i-1][1]
						&& substr($array[$i][1], 0, 18) != "Music Box Massacre"
						&& substr($array[$i][1], 0, 15) != "Double Feature ") {

						// Show images on Gallery page
						if( get_the_ID() == 1774){

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

							// Show text links on Gallery (List) page
						} else {

							$return .= "<a href=". $array[$i][2] .">".$array[$i][1]."</a><br />";

						}
					}
				}

				$return .= '<div style="clear: both;"">&nbsp;</div>';

				return $content . $return;

			} else {
				return $content;
			}

		}

		// Add filter function to the hook
		add_filter('the_content', 'dfGalleryGenerator');
	}

?>
