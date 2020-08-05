<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="hero sec">
				<div class="container sec-inner">
					<div class="row">
						<div class="col-sm-12">
							<h2>Alarming Safety</h2>
							<p>Be prepared on the water and off.</p>
							<a href="/shop" class="button wc-forward">Start shopping</a>
						</div>
					</div>
				</div>
			</section>
			<section class="sec menu-section">
				<div class="sec-inner">
					<?php wp_nav_menu( array( 'theme_location' => 'homepage-menu', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
				</div>
			</section>

			<section class="content sec">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-6">

							<?php while ( have_posts() ) : the_post();

								do_action( 'storefront_page_before' );

								get_template_part( 'content', 'page' );

								/**
								 * Functions hooked in to storefront_page_after action
								 *
								 * @hooked storefront_display_comments - 10
								 */
								do_action( 'storefront_page_after' );

							endwhile; // End of the loop. ?>

						</div>

					</div>
				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
