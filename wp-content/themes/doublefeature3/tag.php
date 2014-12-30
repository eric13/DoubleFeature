<?php

// To add data and styling to tag pages for director proiles

/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php 
/*

$tag = wp_tag_cloud('format=array');			// Tag Array with Formating
$tagc = $tag;								// Tag Array without Formatting

// A similar array with clean tags
for ( $i=0; $i<count($tagc); $i++) {
	$tagc[$i] = strtolower(strip_tags($tagc[$i]));
	$tagc[$i] = str_replace(" ", "-", "$tagc[$i]");
}

$url = substr($_SERVER["REQUEST_URI"], 5);

$i = 0;
while ($tagc[$i] != $url && $i < count($tag) ) {
	$link=$i;
    $i++;
}

$link1 = $tag[$link];
$link2 = $tag[$link+2];

if ($link1){ echo "<div class='cusflt' style='float: left;'> $link1</div>"; }
if ($link2){ echo "<div class='cusflt' style='float: right;'>$link2</div>"; }

*/
?>

<h1 class="page-title"><?php
	printf( __( 'Director: %s', 'twentyten' ), '<span>' . single_tag_title( '', false ) . '</span>' );
?></h1>

<div class="tag-description">
	<?php echo tag_description(); ?><div class="dcb">&nbsp;</div>
</div>

<?php
/* Run the loop for the tag archive to output the posts
 * If you want to overload this in a child theme then include a file
 * called loop-tag.php and that will be used instead.
 */
 get_template_part( 'loop', 'tag' );
?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
