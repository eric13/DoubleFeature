<?php
/**
 * The loop that displays a single post
 *
 * The loop displays the posts and the post content. See
 * https://codex.wordpress.org/The_Loop to understand it and
 * https://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-single.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */

// OPTIONS
	// Show the author?
	$author=false;
?>


<?php
	if ( have_posts() ) while ( have_posts() ) : the_post();
?>
								<div id="nav-above" class="navigation">
										<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentyten' ) . '</span> %title' ); ?></div>
										<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '</span>' ); ?></div>
								</div><!-- #nav-above -->

								<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


										<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>

										<h1 class="entry-title"><?php the_title(); ?></h1>

										<div class="entry-meta">
											<?php if(!has_category('podcast') ){ twentyten_posted_on(); }  ?>
										</div><!-- .entry-meta -->

										<div class="entry-content">
												<?php
													// Main Info and Links
													if(is_single() && has_category('podcast')) {
														echo dfEpA("top");
													}
													// Wordpress - The Content
													the_content();
													// Bottom Covers
													if(is_single() && has_category('podcast')) {
														echo dfEpA("bottom");
													}
												?>
												<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
												</div><!-- .entry-content -->
												<?php
													function showAuthor(){
														 // If a user has filled out their description, show a bio on their entries
														if (get_the_author_meta('description')){
															/** This filter is documented in author.php */
															$theAvatar = get_avatar(get_the_author_meta('user_email'),apply_filters('twentyten_author_bio_avatar_size',60));
															$theAuthor = get_the_author;
															$theDesc = get_the_author_meta('description');
															$theURL = esc_url(get_author_posts_url(get_the_author_meta('ID')));
															$return = "
																<div id='entry-author-info'>
																	<div id='author-avatar'>$theAvatar</div>
																	<div id='author-description'>
																		<h2>About $theAuthor</h2>
																		$theDescription
																		<div id='author-link'>
																			<a href='$theURL' rel='author'>View all posts by $theAuthor <span class='meta-nav'>&rarr;</span></a>
																		</div>
																	</div>
																</div>";
															return $return;
														}
													}
													// Print out the author information
													if($author){ echo showAuthor(); }
												?>
										<div class="entry-utility"><?php twentyten_posted_in(); ?></div>
								</div><!-- #post-## -->

								<div id="nav-below" class="navigation">
									<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentyten' ) . '</span> %title' ); ?></div>
									<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '</span>' ); ?></div>
								</div><!-- #nav-below -->

								<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>
