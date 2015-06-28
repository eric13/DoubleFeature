<?php
/**
 *
 * Custom RSS by Eric Thirteen.
 * 2013-10-19
 *
 */

function fixer($in) {
	$in = str_replace("&#8220;", '"', $in);
	$in = str_replace("&#8221;", '"', $in);
	$in = str_replace("&#8217;", "'", $in);
	$in = str_replace("&#8216;", "'", $in);
	$in = str_replace("&#8211;", "-", $in);
	$in = str_replace("&#8230;", "...", $in);
	$in = str_replace("\xC2\xA0",' ',$in);
	$in = str_replace("\xE2\x80\x99","'",$in);
	$in = str_replace("\xE2\x80\x9C",'"',$in);
	$in = str_replace("\xE2\x80\x9D",'"',$in);
	$in = str_replace("\xE2\x80\x93",'-',$in);
	$in = substr($in, 0, strpos($in, "&"));
	If (strpos($in, " <") > 0) { 
		$in = substr($in, 0, strpos($in, " <"));
		$in = substr_replace($in, "", -3); }
	$in = trim($in) . "...";
	return $in;
}

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$more = 1;

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
	<?php do_action('rss2_ns'); ?>
>

<channel>
	<title><?php bloginfo_rss('name'); ?></title>
	<link><?php bloginfo_rss('url') ?></link>
	<language><?php bloginfo_rss( 'language' ); ?></language>
	<copyright>Creative Commons 3.0 Attribution</copyright>
	<itunes:subtitle>Two films, back to back!</itunes:subtitle>
	<itunes:author><?php bloginfo_rss('name'); ?></itunes:author>
	<itunes:summary><?php bloginfo_rss("description") ?></itunes:summary>
	<description><?php bloginfo_rss("description") ?></description>
	<itunes:owner>
		<itunes:name><?php bloginfo_rss('name'); ?></itunes:name>
		<itunes:email>doublefeatureshow@icloud.com</itunes:email>
	</itunes:owner>
	<itunes:image href="http://doublefeature.fm/images/podcastart.jpg" />
	<itunes:category text="TV &amp; Film" />
	<itunes:explicit>yes</itunes:explicit>
	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>

	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
	<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
	<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
	<?php do_action('rss2_head'); ?>

	<?php while( have_posts()) : the_post(); ?>
	<item>
		<title><?php the_title_rss() ?></title>
		<itunes:author><?php bloginfo_rss('name'); ?></itunes:author>
		<itunes:subtitle><?php echo substr(fixer( get_the_excerpt() ),0,251 ). "..."; ?></itunes:subtitle>
		<itunes:summary><?php echo fixer( get_the_excerpt() ); ?></itunes:summary>
		<description><?php echo fixer( get_the_excerpt() ); ?></description>
		<itunes:image href="http://doublefeature.fm/images/podcastart.jpg" />
		<?php rss_enclosure(); ?>
		<guid isPermaLink="false"><?php the_guid(); ?></guid>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
		<itunes:duration><?php echo gc(duration); ?></itunes:duration>
		<link><?php the_permalink_rss() ?></link>
	<?php do_action('rss2_item'); ?>
	</item>
	<?php endwhile; ?>
</channel>
</rss>
