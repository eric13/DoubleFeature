<?php

// Incomplete
// To do: Throw in a 'if this year-x ac page doesn't exist, go to its permanant counterpart.''
// Make div by slug function could be refactored
// Profile Infomration shortcode probably doesn't go on this page
// Style is pretty shoddy
// Cloud member should get AC Recent (Pack), everyobe else should get AC Recent 
// System needs to makesure login comes back to this page on normal login
// Show disabled content for lower members? With Patreon unlock information?
// Also still a little wet in switch
// Ultimately, how much of this should be wrapped in plugin instead? Probably...most.

$auth = SwpmAuth::get_instance();
$level = $auth->get('membership_level');

function get_ID_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}

function make_div_by_slug($slug){
	$path = "/members/content/".$slug;
	$pageID = get_ID_by_slug($path);
	$title = get_the_title($pageID);
	$thumbID = get_post_thumbnail_id($pageID,'thumbnail');
	$thumbArray = wp_get_attachment_image_src( $thumbID,'thumbnail' );
	$imageThumb = $thumbArray[0];
	$return = "<div class='memThumb'><a href='https://doublefeature.fm/$path'><img src='$imageThumb' alt='$title'></a><div>$title</div></div>";
	echo $return;
}

?>

<h3>Profile Information</h3>
[swpm_profile_form]

<?php

	switch ($level) {
		case 2:
			// Admin
				make_div_by_slug('double-feature-year-1');
				make_div_by_slug('double-feature-year-2');
				make_div_by_slug('double-feature-year-3');
				make_div_by_slug('double-feature-year-4');
				make_div_by_slug('double-feature-year-5');
				make_div_by_slug('double-feature-year-6');
				make_div_by_slug('double-feature-year-7');
				make_div_by_slug('double-feature-year-8');
				make_div_by_slug('double-feature-year-9');
				echo "<h3>Additional Content</h3>";
				make_div_by_slug('additional-content-year-6');
				make_div_by_slug('additional-content-year-7');
				make_div_by_slug('additional-content-year-8');
				make_div_by_slug('additional-content-year-9');
				echo "<h3>More Access</h3>";
				make_div_by_slug('extra-bonuses');
				make_div_by_slug('themes-and-commentary');
			break;
		case 3:
			// Showrunner
				make_div_by_slug('double-feature-year-1');
				make_div_by_slug('double-feature-year-2');
				make_div_by_slug('double-feature-year-3');
				make_div_by_slug('double-feature-year-4');
				make_div_by_slug('double-feature-year-5');
				make_div_by_slug('double-feature-year-6');
				make_div_by_slug('double-feature-year-7');
				make_div_by_slug('double-feature-year-8');
				make_div_by_slug('double-feature-year-9');
				echo "<h3>Additional Content</h3>";
				make_div_by_slug('additional-content-year-6');
				make_div_by_slug('additional-content-year-7');
				make_div_by_slug('additional-content-year-8');
				make_div_by_slug('additional-content-year-9');
				echo "<h3>More Access</h3>";
				make_div_by_slug('extra-bonuses');
				make_div_by_slug('themes-and-commentary');
			break;
		case 4:
			// Executive Producer
				make_div_by_slug('double-feature-year-1');
				make_div_by_slug('double-feature-year-2');
				make_div_by_slug('double-feature-year-3');
				make_div_by_slug('double-feature-year-4');
				make_div_by_slug('double-feature-year-5');
				make_div_by_slug('double-feature-year-6');
				make_div_by_slug('double-feature-year-7');
				make_div_by_slug('double-feature-year-8');
				make_div_by_slug('double-feature-year-9');
				echo "<h3>Additional Content</h3>";
				make_div_by_slug('additional-content-year-6');
				make_div_by_slug('additional-content-year-7');
				make_div_by_slug('additional-content-year-8');
				make_div_by_slug('additional-content-year-9');
				echo "<h3>More Access</h3>";
				make_div_by_slug('extra-bonuses');
			break;
		case 5:
			// Additional Content Tier Member
				make_div_by_slug('double-feature-year-1');
				make_div_by_slug('double-feature-year-2');
				make_div_by_slug('double-feature-year-3');
				make_div_by_slug('double-feature-year-4');
				make_div_by_slug('double-feature-year-5');
				make_div_by_slug('double-feature-year-6');
				make_div_by_slug('double-feature-year-7');
				make_div_by_slug('double-feature-year-8');
				make_div_by_slug('double-feature-year-9');
				echo "<h3>Additional Content</h3>";
				make_div_by_slug('additional-content-year-6');
				make_div_by_slug('additional-content-year-7');
				make_div_by_slug('additional-content-year-8');
				make_div_by_slug('additional-content-year-9');
				echo "<h3>More Access</h3>";
				make_div_by_slug('extra-bonuses');
				make_div_by_slug('themes-and-commentary');
			break;
		case 6:
			// Cloud tier Member
				make_div_by_slug('double-feature-year-1');
				make_div_by_slug('double-feature-year-2');
				make_div_by_slug('double-feature-year-3');
				make_div_by_slug('double-feature-year-4');
				make_div_by_slug('double-feature-year-5');
				make_div_by_slug('double-feature-year-6');
				make_div_by_slug('double-feature-year-7');
				make_div_by_slug('double-feature-year-8');
				make_div_by_slug('double-feature-year-9');
				echo "<h3>Additional Content</h3>";
				make_div_by_slug('additional-content-year-6');
				make_div_by_slug('additional-content-year-7');
				make_div_by_slug('additional-content-year-8');
				make_div_by_slug('additional-content-year-9');
				echo "<h3>More Access</h3>";
				make_div_by_slug('extra-bonuses');
			break;
		case 7:
			// Subscriber
				make_div_by_slug('double-feature-year-1');
				make_div_by_slug('double-feature-year-2');
				make_div_by_slug('double-feature-year-3');
				make_div_by_slug('double-feature-year-4');
				make_div_by_slug('double-feature-year-5');
				make_div_by_slug('double-feature-year-6');
				make_div_by_slug('double-feature-year-7');
				make_div_by_slug('double-feature-year-8');
				make_div_by_slug('double-feature-year-9');
				echo "<h3>More Access</h3>";
				make_div_by_slug('extra-bonuses');
			break;
		default:
			exit;
	}
?>

<h3>Content Library</h3>


<h3>Profile Information</h3>
[swpm_profile_form]
