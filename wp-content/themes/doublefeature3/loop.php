<?

// Remove Posted in "Category, Tags, Etc" from main page but not individual.

/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content. See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

<? /* Display navigation to next/previous pages when applicable */ ?>
<? if ( $wp_query->max_num_pages > 1 ) : ?>
	<div id="nav-above" class="navigation">
		<div class="nav-previous"><? next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyten' ) ); ?></div>
		<div class="nav-next"><? previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
	</div><!-- #nav-above -->
<? endif; ?>

<? /* If there are no posts to display, such as an empty archive page */ ?>
<? if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><? _e( 'Not Found', 'twentyten' ); ?></h1>
		<div class="entry-content">
			<p><? _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyten' ); ?></p>
			<? get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<? endif; ?>

<?
	/* Start the Loop.
	 *
	 * In Twenty Ten we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>
<? while ( have_posts() ) : the_post(); ?>

<? /* How to display posts of the Gallery format. The gallery category is the old way. */ ?>

	<? if ( ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) || in_category( _x( 'gallery', 'gallery category slug', 'twentyten' ) ) ) : ?>
		<div id="post-<? the_ID(); ?>" <? post_class(); ?>>
			<h2 class="entry-title"><a href="<? the_permalink(); ?>" title="<? echo esc_attr( sprintf( __( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><? the_title(); ?></a></h2>

			<div class="entry-meta">
				<? twentyten_posted_on(); ?>
			</div><!-- .entry-meta -->

			<div class="entry-content">
<? if ( post_password_required() ) : ?>
				<? the_content(); ?>
<? else : ?>
				<?
					$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
					if ( $images ) :
						$total_images = count( $images );
						$image = array_shift( $images );
						$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
				?>
						<div class="gallery-thumb">
							<a class="size-thumbnail" href="<? the_permalink(); ?>"><? echo $image_img_tag; ?></a>
						</div><!-- .gallery-thumb -->
						<p><em><? printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'twentyten' ),
								'href="' . get_permalink() . '" title="' . esc_attr( sprintf( __( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ) ) . '" rel="bookmark"',
								number_format_i18n( $total_images )
							); ?></em></p>
				<? endif; ?>
						<? the_excerpt(); ?>
<? endif; ?>
			</div><!-- .entry-content -->

			<div class="entry-utility">
			<? if ( function_exists( 'get_post_format' ) && 'gallery' == get_post_format( $post->ID ) ) : ?>
				<a href="<? echo get_post_format_link( 'gallery' ); ?>" title="<? esc_attr_e( 'View Galleries', 'twentyten' ); ?>"><? _e( 'More Galleries', 'twentyten' ); ?></a>
				<span class="meta-sep">|</span>
			<? elseif ( in_category( _x( 'gallery', 'gallery category slug', 'twentyten' ) ) ) : ?>
				<a href="<? echo get_term_link( _x( 'gallery', 'gallery category slug', 'twentyten' ), 'category' ); ?>" title="<? esc_attr_e( 'View posts in the Gallery category', 'twentyten' ); ?>"><? _e( 'More Galleries', 'twentyten' ); ?></a>
				<span class="meta-sep">|</span>
			<? endif; ?>
				<span class="comments-link"><? comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?></span>
				<? edit_post_link( __( 'Edit', 'twentyten' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->

<? /* How to display posts of the Aside format. The asides category is the old way. */ ?>

	<? elseif ( ( function_exists( 'get_post_format' ) && 'aside' == get_post_format( $post->ID ) ) || in_category( _x( 'asides', 'asides category slug', 'twentyten' ) )  ) : ?>
		<div id="post-<? the_ID(); ?>" <? post_class(); ?>>

		<? if ( is_archive() || is_search() ) : // Display excerpts for archives and search. ?>
			<div class="entry-summary">
				<? the_excerpt();  ?>
			</div><!-- .entry-summary -->
		<? else : ?>
			<div class="entry-content">
				<? the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?>
			</div><!-- .entry-content -->
		<? endif; ?>

			<div class="entry-utility">
				<? twentyten_posted_on(); ?>
				<span class="meta-sep">|</span>
				<span class="comments-link"><? comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?></span>
				<? edit_post_link( __( 'Edit', 'twentyten' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-utility -->
		</div><!-- #post-## -->

<? /* How to display all other posts. */ ?>

	<? else : ?>
		<div id="post-<? the_ID(); ?>" <? post_class(); ?>>
			<h2 class="entry-title"><a href="<? the_permalink(); ?>" title="<? echo esc_attr( sprintf( __( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><? the_title(); ?></a></h2>

			<div class="entry-meta">
				<? twentyten_posted_on(); ?>
			</div><!-- .entry-meta -->

	<? if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
			<div class="entry-summary">
				<div id="categories-and-search">
				<? 
				
				// Returns shortened result in categories-and-search id, where CSS shrinks thumbnails.
				
				// Create a variable $dc for the content summary.
				$dc = get_the_content();
				// The summary needs to be about 320 characters, but we want to start that
				// count AFTER the HTML for the image at the beginning of each episode's entry.
				$dc = substr($dc, 0, 320+strpos($dc, "</a>") );
				// Cut off the summary at the last space so you don't get half a word.
				$dc = substr($dc, 0, strripos($dc, " "));
				// Display the summary
				echo "$dc...";
				// echo '... <a href=\"'; echo the_permalink(); echo '\">Continue reading <span class="meta-nav">&rarr;</span></a>';

				?>
				</div>
			</div><!-- .entry-summary -->
	<? else : ?>
			<div class="entry-content">
				<? 
				
				// Main page displays shorter content if it's on on iOS
					$isiPad = (bool) strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'ipad');
					$isiPhone = (bool) strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'iphone');
					$isiPod = (bool) strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'ipod');
					if ($isiPod) { $isiPhone = 0; }
				
				// If it's iOS				
					if ($isiPod || $isiPad || $isiPhone) {

						// Create a variable $dc for the content summary.
						$dc = get_the_content();
						// The summary needs to be about 400 characters, but we want to start that
						// count AFTER the HTML for the image at the beginning of each episode's entry.
						$dc = substr($dc, 0, 400+strpos($dc, "</a>") );
						// Cut off the summary at the last space so you don't get half a word.
						$dc = substr($dc, 0, strripos($dc, " "));
						// Display the summary
						echo "$dc...";
						// echo '... <a href=\"'; echo the_permalink(); echo '\">Continue reading <span class="meta-nav">&rarr;</span></a>';
				
				// If it's not iOS
					} else {
				
						the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); 
					}
				
				?>
				<? wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
	<? endif; ?>


<!--
			<div class="entry-utility">
				<? if ( count( get_the_category() ) ) : ?>
					<span class="cat-links">
						<? printf( __( '<span class="%1$s">Posted in</span> %2$s', 'twentyten' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
					</span>
					<span class="meta-sep">|</span>
				<? endif; ?>
				<?
					$tags_list = get_the_tag_list( '', ', ' );
					if ( $tags_list ):
				?>
					<span class="tag-links">
						<? printf( __( '<span class="%1$s">Tagged</span> %2$s', 'twentyten' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
					</span>
					<span class="meta-sep">|</span>
				<? endif; ?>
				<span class="comments-link"><? comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?></span>
				<? edit_post_link( __( 'Edit', 'twentyten' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</div>
-->


<!-- .entry-utility -->

		</div><!-- #post-## -->

		<? comments_template( '', true ); ?>

	<? endif; // This was the if statement that broke the loop into three parts based on categories. ?>

<? endwhile; // End the loop. Whew. ?>

<? /* Display navigation to next/previous pages when applicable */ ?>

<? if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><? next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyten' ) ); ?></div>
					<div class="nav-next"><? previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
				</div><!-- #nav-below -->
<? endif; ?>
