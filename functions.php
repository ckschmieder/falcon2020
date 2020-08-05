<?php

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */

function randjsc_custom_style() {
	wp_enqueue_style('randj-styles', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css', array(), 'screen' );
	wp_enqueue_style('rj-ubermenu', get_stylesheet_directory_uri() .'/css/rj-ubermenu.css', array());


    // wp_enqueue_style('randj-styles', CHILD_THEME_URI . '/builds/development/css/style.min.css', array(), null, 'screen' );
    // wp_enqueue_script( 'jqry', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js' );
    // wp_enqueue_script( 'particles', 'http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js' );
    // wp_enqueue_script( 'randj-script', CHILD_THEME_URI . '/builds/development/js/scripts.js', array('jquery'), '1.12.4' );
}
add_action( 'wp_enqueue_scripts', 'randjsc_custom_style' );

function register_my_menu() {
  register_nav_menu('homepage-menu',__( 'Hopepage Menu' ));
}
add_action( 'init', 'register_my_menu' );

// Add image size for homepage featured menu
add_image_size( 'homepage-menu', 450, 450, true );

add_filter( 'image_size_names_choose', 'my_custom_sizes' );

function my_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'homepage-menu' => __('Homepage Menu'),
    ) );
}

// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');


add_action( 'after_setup_theme', 'rnj_remove_parent_theme_stuff', 0 );

function rnj_remove_parent_theme_stuff() {

	remove_action( 'storefront_footer', 'storefront_credit', 20);
	remove_action( 'storefront_header', 'storefront_header_cart', 60);
	remove_action( 'storefront_loop_post', 'storefront_post_content', 30);
	remove_action( 'storefront_loop_post', 'storefront_post_meta', 20);
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'storefront_header', 'storefront_site_branding', 20);
	// add_action( 'storefront_header', 'storefront_header_cart', 39);
	add_action( 'storefront_footer', 'rnj_storefront_credit', 20);
}

/**********************************
// Customize Product Page
*********************************/

// Remove Image Zoom on hover
add_action( 'after_setup_theme', 'remove_image_zoom_from_child_theme', 11 ); 

function remove_image_zoom_from_child_theme() {

	remove_theme_support( 'wc-product-gallery-zoom' );
	// add_theme_support( 'wc-product-gallery-lightbox' );

}



// Remove Additional Information Tab
add_filter( 'woocommerce_product_tabs', 'bbloomer_remove_product_tabs', 98 );
 
function bbloomer_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] ); 
    return $tabs;
}

/*--------------------
// Customize Header
----------------------------*/
add_action( 'storefront_header','show_title_intro_TEST', 10);
function show_title_intro_TEST() {
   ?>
   <div class="site-branding">
   <a href=“<?php bloginfo( 'url' ); ?>“><?php bloginfo( 'name' ); ?></a>
   <?php bloginfo( 'description' ); ?>
   <?php the_custom_logo(); ?>
   </div>
   <?php
}

add_action( 'woocommerce_before_add_to_cart_form','read_more_link', 10);
function read_more_link() {
   ?>
   <p><a href='#tab-title-description' class="ps2id">Read More</a></p>
   <?php
}



/*--------------------
// Customize Category Pages
----------------------------*/


add_action( 'woocommerce_archive_description','show_category_intro' );
function show_category_intro() {
	// the_field('product_category_header_image');

	if ( is_shop() ) {
		// get the current taxonomy term
		// $term_1 = get_queried_object();


		// vars
		// $image_1 = get_field('header_image', $term_1);
		// $shop_image = get_field('header_image');
		?>		
		<div class="category-header-img" style="background-image: url('/wp-content/uploads/Falcon-Category-All-opt.jpg'); height:0;padding-top: 31.125%; background-size: cover; background-position: center;"></div>
		<?php echo category_description(); 
	}
	if ( is_product_category() ) {
		// get the current taxonomy term
		$term = get_queried_object();


		// vars
		$image = get_field('product_category_header_image', $term);
		?>		
		<div class="category-header-img" style="background-image: url('<?php echo $image['url']; ?>'); height:0;padding-top: 33.333%; background-size: cover; background-position: center;"></div>
		<?php echo category_description(); 
	}
	

	/*if ( is_product_category( 'horns' ) ) {
		?>
		<div class="category-header-img"><img src="/wp-content/uploads/images/category-headers/Falcon-Category-Horns-opt.jpg"></div>
		<?php echo category_description(); ?>
		<?php
	}
	if ( is_product_category( 'dusters' ) ) {
		?>
		<div class="category-header-img"><img src="/wp-content/uploads/images/category-headers/Falcon-Category-Dusters-opt.jpg"></div>
		<?php echo category_description(); ?>
		<?php
	}
	if ( is_product_category( 'marine-accessories' ) ) {
		?>
		<div class="category-header-img"><img src="/wp-content/uploads/images/category-headers/Falcon-Category-Marine-opt.jpg"></div>
		<?php echo category_description(); ?>
		<?php
	}
	if ( is_product_category( 'wet-wipes' ) ) {
		?>
		<div class="category-header-img"><img src="/wp-content/uploads/Falcon-Category-Wipes.jpg"></div>
		<?php echo category_description(); ?>
		<?php
	}
	if ( is_product_category( 'screen-care' ) ) {
		?>
		<div class="category-header-img"><img src="/wp-content/uploads/images/category-headers/Falcon-Category-Screen-Care-opt.jpg"></div>
		<?php echo category_description(); ?>
		<?php
	}*/

}
// Remove "Category:" prefix from title of category pages
add_filter( 'get_the_archive_title', function ($title) {
    if ( is_category() ) {
            $title = single_cat_title( '', false );

        } elseif ( is_tag() ) {
            $title = single_tag_title( '', false );

        } elseif ( is_author() ) {
            $title = '<span class="vcard">' . get_the_author() . '</span>' ;
        }

    return $title;
});


function rj_add_google_fonts() {
 
wp_enqueue_style( 'rj-google-fonts', 'https://fonts.googleapis.com/css?family=Noto+Serif:400,700', false ); 
}
 
add_action( 'wp_enqueue_scripts', 'rj_add_google_fonts' );

// Register Custom Menus
function register_rj_menus() {
  register_nav_menus(
    array(
      'legal-menu' => __( 'Copyright Footer Menu' )
    )
  );
}
add_action( 'init', 'register_rj_menus' );


// Custom Footer Credit Bar
function rnj_storefront_credit() {
	?>
	<div class="footer-cred site-info">
		<span>&copy; Falcon Safety <?php echo date( 'Y' ); ?></span>
		<?php wp_nav_menu( array( 'theme_location' => 'legal-menu' ) ); ?>
	</div>

	<?php
}

/*----------------------
// Register Custom Post Type
----------------------------*/

function custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Use', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Uses', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( '101 Uses', 'text_domain' ),
		'name_admin_bar'        => __( '101 Uses', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Use', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Use', 'text_domain' ),
		'edit_item'             => __( 'Edit Use', 'text_domain' ),
		'update_item'           => __( 'Update Use', 'text_domain' ),
		'view_item'             => __( 'View Use', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Use', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Uses list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( '101 Use', 'text_domain' ),
		'description'           => __( '101 Product Uses', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( '101_uses', $args );

}
add_action( 'init', 'custom_post_type', 0 );

/*----------------------
// Register SDS Custom Post Type
----------------------------*/

function custom_post_type_sds() {

	$labels = array(
		'name'                  => _x( 'SDS', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'SDS', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'SDS', 'text_domain' ),
		'name_admin_bar'        => __( 'SDS', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New SDS', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New SDS', 'text_domain' ),
		'edit_item'             => __( 'Edit SDS', 'text_domain' ),
		'update_item'           => __( 'Update SDS', 'text_domain' ),
		'view_item'             => __( 'View SDS', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search SDS', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Uses list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'SDS', 'text_domain' ),
		'description'           => __( 'Safety Data Sheets', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'sds', $args );

}
add_action( 'init', 'custom_post_type_sds', 0 );

/*----------------------
// Add SDS Tab to products
----------------------------*/

add_filter( 'woocommerce_product_tabs', 'rj_new_product_tab' );
function rj_new_product_tab( $tabs ) {

	$file = get_field('sds_download'); 

	if( $file ):

	    // Add the new tab
	    $tabs['sds-tab'] = array(
	        'title'       => __( 'SDS Download', 'text-domain' ),
	        'priority'    => 50,
	        'callback'    => 'rj_new_product_tab_content'
	    );

	endif;

	return $tabs;

}
 
function rj_new_product_tab_content() {
    // The new tab content

    // load selected file (from post)
    $file = get_field('sds_download'); 

    if( $file ): 
    	echo '<h2>Safety Data Sheet</h2>';
    	?>
    	<div class="file">
    		<a href="<?php echo $file['url']; ?>" target="_blank">
    			<span>Download</span>
    		</a>
    	</div>
    <?php endif;
}

// Customizer Settings
/**
 * Theme Options Customizer Implementation.
 *
 * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 *
 * @param WP_Customize_Manager $wp_customize Object that holds the customizer data.
 */
function sk_register_theme_customizer( $wp_customize ){

	/*
	 * Failsafe is safe
	 */
	if ( ! isset( $wp_customize ) ) {
		return;
	}

	/**
	 * Add 'Homepage Settings' Section.
	 */
	$wp_customize->add_section(
		// $id
		'sk_section_homepage_settings',
		// $args
		array(
			'title'			=> __( 'HomePage Settings', 'theme-slug' ),
			// 'description'	=> __( 'Some description for the options in the Homepage', 'theme-slug' ),
			'active_callback' => 'is_front_page',
		)
	);

	/**
	 * Add 'Home Hero Background Image' Setting.
	 */
	$wp_customize->add_setting(
		// $id
		'sk_homepage_settings_background_image',
		// $args
		array(
			'default'		=> get_stylesheet_directory_uri() . '/images/falcon-default-hero-bg.jpg',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'		=> 'postMessage'
		)
	);

	/**
	 * Add 'Home Hero Background Image' image upload Control.
	 */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			// $wp_customize object
			$wp_customize,
			// $id
			'sk_homepage_settings_background_image',
			// $args
			array(
				'settings'		=> 'sk_homepage_settings_background_image',
				'section'		=> 'sk_section_homepage_settings',
				'label'			=> __( 'Hero Section Background Image', 'theme-slug' ),
				'description'	=> __( 'Select the image to be used for Hero Section Background.', 'theme-slug' )
			)
		)
	);


	/* ---------------------------------------
	 * Add Homepage Feature-1 Menu Settings
	 * ---------------------------------------*/
	$wp_customize->add_setting(
		// $id
		'rj_homepage_featured1_background_image',
		// $args
		array(
			'default'		=> get_stylesheet_directory_uri() . '/images/falcon-default-hero-bg.jpg',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'		=> 'postMessage'
		)
	);

	/* ---------------------------------------------------
	 * Add Homepage Feature-1 Menu image upload Control.
	 * ---------------------------------------------------*/
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			// $wp_customize object
			$wp_customize,
			// $id
			'rj_homepage_featured1_background_image',
			// $args
			array(
				'settings'		=> 'rj_homepage_featured1_background_image',
				'section'		=> 'sk_section_homepage_settings',
				'label'			=> __( 'Featured Menu Item #1 Background Image', 'theme-slug' ),
				'description'	=> __( 'Select the image to be used for the first feature item background.', 'theme-slug' )
			)
		)
	);

	/* ---------------------------------------
	 * Add Homepage Feature-2 Menu Settings
	 * ---------------------------------------*/
	$wp_customize->add_setting(
		// $id
		'rj_homepage_featured2_background_image',
		// $args
		array(
			'default'		=> get_stylesheet_directory_uri() . '/images/falcon-default-hero-bg.jpg',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'		=> 'postMessage'
		)
	);

	/* ---------------------------------------------------
	 * Add Homepage Feature-2 Menu image upload Control.
	 * ---------------------------------------------------*/
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			// $wp_customize object
			$wp_customize,
			// $id
			'rj_homepage_featured2_background_image',
			// $args
			array(
				'settings'		=> 'rj_homepage_featured2_background_image',
				'section'		=> 'sk_section_homepage_settings',
				'label'			=> __( 'Featured Menu Item #2 Background Image', 'theme-slug' ),
				'description'	=> __( 'Select the image to be used for the second feature item background.', 'theme-slug' )
			)
		)
	);

	/* ---------------------------------------
	 * Add Homepage Feature-3 Menu Settings
	 * ---------------------------------------*/
	$wp_customize->add_setting(
		// $id
		'rj_homepage_featured3_background_image',
		// $args
		array(
			'default'		=> get_stylesheet_directory_uri() . '/images/falcon-default-hero-bg.jpg',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'		=> 'postMessage'
		)
	);

	/* ---------------------------------------------------
	 * Add Homepage Feature-3 Menu image upload Control.
	 * ---------------------------------------------------*/
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			// $wp_customize object
			$wp_customize,
			// $id
			'rj_homepage_featured3_background_image',
			// $args
			array(
				'settings'		=> 'rj_homepage_featured3_background_image',
				'section'		=> 'sk_section_homepage_settings',
				'label'			=> __( 'Featured Menu Item #3 Background Image', 'theme-slug' ),
				'description'	=> __( 'Select the image to be used for the thrid feature item background.', 'theme-slug' )
			)
		)
	);

}

// Settings API options initilization and validation.
add_action( 'customize_register', 'sk_register_theme_customizer' );

/**
 * Writes the Home Hero background image out to the 'head' element of the document
 * by reading the value from the theme mod value in the options table.
 */
function sk_customizer_css() {
?>
	<style type="text/css">
		<?php
			if ( get_theme_mod( 'sk_homepage_settings_background_image' ) ) {
				$homepage_settings_background_image_url = get_theme_mod( 'sk_homepage_settings_background_image' );
			} else {
				$homepage_settings_background_image_url = get_stylesheet_directory_uri() . '/images/falcon-default-hero-bg.jpg';
			}

			// if ( 0 < count( strlen( ( $homepage_settings_background_image_url = get_theme_mod( 'sk_homepage_settings_background_image', sprintf( '%s/images/minimography_005_orig.jpg', get_stylesheet_directory_uri() ) ) ) ) ) ) { ?>
			.hero.sec {
				background-image: url( <?php echo $homepage_settings_background_image_url; ?> );
			}
		<?php // } // end if ?>


		/* Featured Menu Image #1 */
		<?php 
			if ( get_theme_mod( 'rj_homepage_featured1_background_image' ) ) {
				$homepage_settings_background_image_url = get_theme_mod( 'rj_homepage_featured1_background_image' );
			} else {
				$homepage_settings_background_image_url = get_stylesheet_directory_uri() . '/images/falcon-default-hero-bg.jpg';
			}
			// if ( 0 < count( strlen( ( $homepage_settings_background_image_url = get_theme_mod( 'rj_homepage_featured1_background_image', sprintf( '%s/images/minimography_005_orig.jpg', get_stylesheet_directory_uri() ) ) ) ) ) ) { ?>
			#menu-homepage li:first-child {
				background-image: url( <?php echo $homepage_settings_background_image_url; ?> );
			}
		<?php // } // end if ?>
		/* Featured Menu Image #1 */
		<?php 
			if ( get_theme_mod( 'rj_homepage_featured2_background_image' ) ) {
				$homepage_settings_background_image_url = get_theme_mod( 'rj_homepage_featured2_background_image' );
			} else {
				$homepage_settings_background_image_url = get_stylesheet_directory_uri() . '/images/falcon-default-hero-bg.jpg';
			}
			// if ( 0 < count( strlen( ( $homepage_settings_background_image_url = get_theme_mod( 'rj_homepage_featured1_background_image', sprintf( '%s/images/minimography_005_orig.jpg', get_stylesheet_directory_uri() ) ) ) ) ) ) { ?>
			#menu-homepage li:nth-child(2) {
				background-image: url( <?php echo $homepage_settings_background_image_url; ?> );
			}
		<?php // } // end if ?>
		/* Featured Menu Image #1 */
		<?php 
			if ( get_theme_mod( 'rj_homepage_featured3_background_image' ) ) {
				$homepage_settings_background_image_url = get_theme_mod( 'rj_homepage_featured3_background_image' );
			} else {
				$homepage_settings_background_image_url = get_stylesheet_directory_uri() . '/images/falcon-default-hero-bg.jpg';
			}
			// if ( 0 < count( strlen( ( $homepage_settings_background_image_url = get_theme_mod( 'rj_homepage_featured1_background_image', sprintf( '%s/images/minimography_005_orig.jpg', get_stylesheet_directory_uri() ) ) ) ) ) ) { ?>
			#menu-homepage li:nth-child(3) {
				background-image: url( <?php echo $homepage_settings_background_image_url; ?> );
			}
		<?php // } // end if ?>


	 </style>
<?php
} // end sk_customizer_css

add_action( 'wp_head', 'sk_customizer_css');

/**
 * Registers the Theme Customizer Preview with WordPress.
 *
 * @package    sk
 * @since      0.3.0
 * @version    0.3.0
 */
function sk_customizer_live_preview() {
	wp_enqueue_script(
		'sk-theme-customizer',
		get_stylesheet_directory_uri() . '/js/theme-customizer.js',
		array( 'customize-preview' ),
		'0.1.0',
		true
	);
} // end sk_customizer_live_preview
add_action( 'customize_preview_init', 'sk_customizer_live_preview' );

// Link media to the file itself rather than the attachment page in media search results page
function my_get_attachment_url( $url, $post_id ) {

    $url = wp_get_attachment_url( $post_id );

    return $url;
}
add_filter( 'mse_get_attachment_url', 'my_get_attachment_url', 10, 2 );

/**
 * This function replaces Storefront's product search function.
 * It will render the WooCommerce Product Search widget instead of
 * the default widget when the extension is enabled.
 */
function storefront_product_search() {
  if ( function_exists('storefront_is_woocommerce_activated' ) ) {
    if ( storefront_is_woocommerce_activated() ) { ?>
      <div class="site-search">
      <?php
      if ( class_exists( 'WooCommerce_Product_Search_Widget' ) ) {
        the_widget( 'WooCommerce_Product_Search_Widget', 'title=' );
      } else {
        the_widget( 'WC_Widget_Product_Search', 'title=' );
      }
      ?>
      </div>
    <?php
    }
  }
}

add_action( 'init', 'jk_remove_storefront_header_search' );
function jk_remove_storefront_header_search() {
remove_action( 'storefront_header', 'storefront_product_search', 	40 );
}


// ----------------------------------
// 1. ADD SEARCH TO STOREFRONT HEADER
 
add_action('storefront_header','add_search_to_header');
 
function add_search_to_header() {
get_search_form();
}

// ----------------------------------
// Custom Search Query for SDS search

/**
 * Register custom query vars
 *
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
 */
function sm_register_query_vars( $vars ) {
	$vars[] = 'sku';
	$vars[] = 'sds';
	return $vars;
}
add_filter( 'query_vars', 'sm_register_query_vars' );


// Enable short code for SDS search form
function sm_setup() {
	add_shortcode( 'sm_search_form', 'sm_search_form' );
}
add_action( 'init', 'sm_setup' );

// the callback function that will produce the HTML SDS search form 
function sm_search_form( $args ){

	// Output the form
	$output = '<form action="' . esc_url( get_permalink() ) . '" method="GET" role="search">';
	$output .= '<label class="smtextfield"><input type="text" name="sku" placeholder="Search Model # or CAS #..." value="" /></label>';
	$output .= '<input type="hidden" name="sds" value="find" />';
	$output .= '<input type="submit" value="Find SDS" class="button search-submit" /></form>';

	return $output;

}

// add page-sds.php template
add_filter( 'template_include', 'sku_page_template', 99 );

function sku_page_template( $template ) {

	if ( get_query_var('sds') ) {
		$new_template = locate_template( array( 'sds-results.php' ) );
		if ( '' != $new_template ) {
			return $new_template;
		}
	}

	return $template;
}

/**
* Preview WooCommerce Emails.
* @author WordImpress.com
* @url https://github.com/WordImpress/woocommerce-preview-emails
* If you are using a child-theme, then use get_stylesheet_directory() instead
*/

$preview = get_stylesheet_directory() . '/woocommerce/emails/woo-preview-emails.php';

if(file_exists($preview)) {
    require $preview;
}

function custom_my_account_menu_items( $items ) {
    unset($items['downloads']);
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items' );