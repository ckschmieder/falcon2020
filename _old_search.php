<?php
/**
 * The template for displaying search results pages.
 *
 * @package storefront
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

        <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <h1 class="page-title"><?php printf( esc_attr__( 'Search Results for: %s', 'storefront' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </header><!-- .page-header -->

                    <?php
                    $product_search = new WP_Query(
                        array(
                           'meta_query' => array(
                              'key' => '_sku',
                              'value' => sanitize_text_field($_GET['s']),
                              'compare' => 'IN',
                           ),
                           'post_type' => 'product',
                           'posts_per_page' => 5,
                           )
                   );
                   
                   if($product_search->have_posts()):
                   ?>
                   <section id="products-results" class="results">
            	       <h3>Products</h3>
            	       <ul class="products">
            	       <?php
            	       while ( $product_search->have_posts() ) :
            	            $product_search->the_post();
            	           
            	            do_action( 'woocommerce_shop_loop' );
            	            wc_get_template_part( 'content', 'product' );
            	        endwhile;
            	        ?>

            	        </ul>
            	    </section>
            	        <?php
            	        wp_reset_postdata();

            	        
            	   endif;
            	   ?>





	            <section id="content-results" class="results">
		            <h3>Related Content</h3>
		            <?php get_template_part( 'loop' ); ?>
		         </section>
	        <?php
	        else :

	            get_template_part( 'content', 'none' );

	        endif;
	        ?>
	       
        

	      	
	
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();