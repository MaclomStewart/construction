<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.upwork.com/fl/rayhan1
 * @since      1.0.0
 *
 * @package    Different_Menus_For_Different_Page
 * @subpackage Different_Menus_For_Different_Page/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Different_Menus_For_Different_Page
 * @subpackage Different_Menus_For_Different_Page/admin
 * @author     RAYHAN KABIR <rayhankabir1000@gmail.com>
 */
class Different_Menus_For_Different_Page_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;



    	add_filter( 'wp_nav_menu_args', array( $this, 'change_nav_menu_arguments'), 99 );

    	add_filter( 'after_menu_locations_table', array( $this, 'after_menu_locations_table') );

    	add_action( 'after_setup_theme', array( $this, 'remove_default_menu' ) );

    	if ( strpos($_SERVER['PHP_SELF'], "nav-menus.php")) {
    		add_filter( 'admin_footer', array($this, 'goto_different_menu_page') );
    	}
    	

    	add_action('admin_menu', array($this, 'different_menus_create_menu') );
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/metabox.php';

		//Adding premium link to plugin action row
		add_filter( 'plugin_row_meta', array( $this, 'custom_plugin_row_meta'), 10, 2 );


		add_action('wp_ajax_create_duplicate_menu', array( $this, 'create_duplicate_menu'));
		add_action('wp_ajax_nopriv_create_duplicate_menu', array( $this, 'create_duplicate_menu'));


		if ( strpos($_SERVER['PHP_SELF'], 'plugins.php') !== false ) {
			add_action('admin_footer', array( $this, 'dmidp_deactivate_reason'));
		}

		add_action('wp_ajax_dmidp_trial_dismiss_ajax', array( $this, 'dmidp_trial_dismiss_ajax'));
		add_action('wp_ajax_nopriv_dmidp_trial_dismiss_ajax', array( $this, 'dmidp_trial_dismiss_ajax'));

		add_action('admin_footer', array($this, 'dmidp_trial_dismiss_scripts'));
		

	add_action('wp_ajax_dmidp_notice_has_clicked', array( $this, 'dmidp_notice_has_clicked' ));
	add_action('wp_ajax_nopriv_dmidp_notice_has_clicked', array( $this, 'dmidp_notice_has_clicked' ));

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */


	public function menu_settings_enqueue_styles() {
		wp_enqueue_style( 'menu-settings-bootstrap-min', plugin_dir_url( __FILE__ ) . 'css/settings-bootstrap.min.css', array(), '4.3.1', 'all' );

		wp_enqueue_style( 'menu_page', plugin_dir_url( __FILE__ ) . 'css/menu-page.css', array(), '4.3.1', 'all' );
	}

	public function menu_settings_enqueue_scripts() {
		wp_enqueue_script( 'poper-min', 'https://unpkg.com/popper.js@1.15.0/dist/umd/popper.min.js', array( 'jquery' ), '4.3.1', true );

		wp_enqueue_script( 'bootstrap-min', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery', 'poper-min' ), '4.3.1', true );

		wp_enqueue_script( 'velocity-min', plugin_dir_url( __FILE__ ) . 'js/velocity.min.js', array( 'jquery', 'bootstrap-min' ), '1.2.2', true );

		wp_enqueue_script( 'valocity-ui-min', plugin_dir_url( __FILE__ ) . 'js/velocity-ui.min.js', array( 'jquery', 'velocity-min' ), '1.2.2', true );


		wp_enqueue_script( 'bootstrap-notify', plugin_dir_url( __FILE__ ) . 'js/bootstrap-notify.js', array( 'bootstrap-min' ), '1.2.2', true );
	}

	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Different_Menus_For_Different_Page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Different_Menus_For_Different_Page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/different-menus-for-different-page-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'bootstrap-min', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), '4.3.1', 'all' );

		wp_enqueue_style( 'animate-css', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'recorp-fontawesome-min', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css', array(), '5.13.0', 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */



	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Different_Menus_For_Different_Page_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Different_Menus_For_Different_Page_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/different-menus-in-different-page-admin.js', array( 'jquery', 'bootstrap-min', 'valocity-ui-min' ), $this->version, true );

		wp_enqueue_script( 'poper-min', 'https://unpkg.com/popper.js@1.15.0/dist/umd/popper.min.js', array( 'jquery' ), '4.3.1', true );

		wp_enqueue_script( 'bootstrap-min', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery', 'poper-min' ), '4.3.1', true );

		wp_enqueue_script( 'velocity-min', plugin_dir_url( __FILE__ ) . 'js/velocity.min.js', array( 'jquery', 'bootstrap-min' ), '1.2.2', true );

		wp_enqueue_script( 'valocity-ui-min', plugin_dir_url( __FILE__ ) . 'js/velocity-ui.min.js', array( 'jquery', 'velocity-min' ), '1.2.2', true );


		wp_enqueue_script( 'bootstrap-notify', plugin_dir_url( __FILE__ ) . 'js/bootstrap-notify.js', array( 'bootstrap-min' ), '1.2.2', true );

	
	if ( isset($_GET['welcome']) && !empty( sanitize_key($_GET['welcome']))) {
		wp_add_inline_script('bootstrap-notify', '
			(function () {
                   jQuery.notify({
                    // options
                    message: "Thanks for activating our plugin. If you found any issue then click on support and please feel free to contact us, we will response very quickly. Thank you :)" 
                },{
                    // settings
                    type: "success",
                    placement: {
                        from: "top",
                        align: "center"
                    },
                    animate:{
                        enter: "animated fadeInDown",
                        exit: "animated fadeOutUp"
                    },
                    delay: 10000
                }

                );
                }(jQuery));
		');
    }




	}

	public function different_menus_create_menu(){

		add_options_page(
			'Different Menu for Different Pages',
			__('Different Menus', 'different-menus'),
			'manage_options',
			'different-menus-in-different-pages',
			array(
				$this,
				'load_admin_dependencies'
			)
		);

		add_action('admin_init', array( $this,'different_menus_settings') );
	}


/*Replacing the main theme location menu*/
public function change_nav_menu_arguments( $args ){


$locations 	= get_nav_menu_locations();
	if(isset($locations)){
		foreach ($locations as $location => $value) {

		$menu = $this->location_to_menu_condition($location);

			if ( $location == $args['theme_location'] ) {
				$args['menu'] = $menu;
			}
		}// end foreach
	}

	return $args;
}


public function location_to_menu_condition($location = "primary-menu" , $return = ""){

	$different_menus = get_option('different_menus_for_different_page');



	$assigned_menu = isset($different_menus[get_stylesheet()][$location])? $different_menus[get_stylesheet()][$location] : array();

		$single_condition = "";
		$menuId = 0;	


	if (isset($assigned_menu)) {
		foreach ($assigned_menu as $menu_id => $conditions) { 
			$conditions = $conditions['name'];

			foreach ($conditions as $condition) {
				$single_condition  .= $condition . "&";
			}

				$menuId = str_replace("menu_", "", $menu_id);

				$condition = rtrim($single_condition, "&");

			if ( $this->check_visibility($condition) && $menuId !== "disable" ) {

				return intval($menuId);	

				//break;
			} 
		
		}

	}
			

		//return $menuId;
}


	public function load_admin_dependencies(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/different-menus-for-different-page-admin-display.php';

	}

	public function different_menus_settings(){
		register_setting('different_menus_settings_list', 'recorp_settings');
	}

	public function check_visibility( $logic ) {
		$visible = true;
		parse_str( $logic, $logic );
		$query_object = get_queried_object();

		// Logged-in check
		if( isset( $logic['general']['logged'] ) ) {
			if( ! is_user_logged_in() ) {
				return false;
			}
			unset( $logic['general']['logged'] );
			if( empty( $logic['general'] ) ) {
				unset( $logic['general'] );
			}
		}
		// none logged user check
		if( isset( $logic['general']['none_logged'] ) ) {
			if( is_user_logged_in() ) {
				return false;
			}
			unset( $logic['general']['none_logged'] );
			if( empty( $logic['general'] ) ) {
				unset( $logic['general'] );
			}
		}


	// User role check
		if( isset($logic['roles']) && ! empty( $logic['roles']) && empty($GLOBALS['current_user']->roles) ) {
			return false;
		}
	// User role check
		if( isset($logic['roles']) && ! empty( $logic['roles']) && !empty($GLOBALS['current_user']->roles) && !in_array( $GLOBALS['current_user']->roles[0] , array_keys( $logic['roles'] ) ) ) {
			return false;
		}
		unset( $logic['roles'] );

		if( ! empty( $logic ) ) { 
			$visible = false; // if any condition is set for a hook, hide it on all pages of the site except for the chosen ones.
			if( ( is_home() && isset( $logic['general']['home'] ) )
				|| (is_front_page() && isset($logic['general']['frontpage']) )
				|| (is_home() && isset($logic['general']['blog']) )
				|| ( is_page() && isset( $logic['general']['page'] ))
				|| ( is_sticky() && isset( $logic['general']['sticky_post'] ) )
				|| ( is_rtl() && isset( $logic['general']['rtl'] ) )
				|| ( is_404() && isset( $logic['general']['404'] ) )
				|| ( is_singular() && isset( $logic['general']['single'] ) )
				|| ( is_search() && isset( $logic['general']['search'] ) )
				|| ( is_author() && isset( $logic['general']['author'] ) )
				|| ( is_category() && isset( $logic['general']['category'] ) )
				|| ( is_tag() && isset($logic['general']['tag']) )
				|| ( is_date() && isset($logic['general']['date']) )
				|| ( is_year() && isset($logic['general']['year']) )
				|| ( is_month() && isset($logic['general']['month']) )
				|| ( is_day() && isset($logic['general']['day']) )
				|| ( is_singular() && isset( $logic['general'][$query_object->post_type] ) && $query_object->post_type !== 'page' && $query_object->post_type !== 'post' )
				|| ( is_tax() && isset( $logic['general'][$query_object->taxonomy] ) )
			) {
				$visible = true;
			} else { 
				if ( ! empty($logic['template'])) {
					foreach ($logic['template'] as $key => $value) {
						if ( is_page_template( $key ) ) {
							$visible = true;
							break;
						}
					}
				}
				if( ! empty( $logic['tax'] ) ) {
					if(is_singular()){
						if( !empty($logic['tax']['category_single'])){
							$cat = get_the_category();
							if(!empty($cat)){
								foreach($cat as $c){
									if($c->taxonomy === 'category' && isset($logic['tax']['category_single'][$c->slug])){
										$visible = true;
										break;
									}
								}
							}
						} 
						if(!empty($logic['tax']['category'])){
							$cat = get_the_category();
							if(!empty($cat)){
								foreach($cat as $c){
									if( isset($logic['tax']['category'][$c->slug])){
										$visible = true;
										break;
									}
								}
							}
						}
					} else {
						foreach( $logic['tax'] as $tax => $terms ) {
							$terms = array_keys( $terms );
							if( ( $tax === 'category' && is_category( $terms ) )
								|| ( $tax === 'post_tag' && is_tag( $terms ) )
								|| ( is_tax( $tax, $terms ) )
							) {
								$visible = true;
								break;
							}
						}
					}
				}

				if ( ! $visible && ! empty( $logic['post_type'] ) ) {

					foreach( $logic['post_type'] as $post_type => $posts ) {
						$posts = array_keys( $posts );

						if (
							// Post single
							( $post_type === 'post' && is_single() && is_single( $posts ) )
							// Page view
							|| ( $post_type === 'page' && (
								( is_page() &&
									( is_page( $posts )
									// check for pages that have a Parent, the slug for these pages are stored differently.
									|| ( isset( $query_object->post_parent ) && $query_object->post_parent > 0 && in_array( str_replace( home_url(), '', get_permalink( $query_object->ID ) ), $posts ) )
								) )
								|| ( ! is_front_page() && is_home() &&  in_array( get_post_field( 'post_name', get_option( 'page_for_posts' ) ), $posts ) ) // check for Posts page
								|| ( class_exists( 'WooCommerce' ) && function_exists( 'is_shop' ) && in_array( get_post_field( 'post_name', wc_get_page_id( 'shop' ) ), $posts ) && is_shop() ) // check for WC Shop page
							) )
							// Custom Post Types single view check
							|| ( is_singular( $post_type ) && in_array( $query_object->ID, $posts ) )
						) {
							$visible = true;
							break;
						}
					}
				}
			}
		}

		return $visible;
	}

	public function after_menu_locations_table(){
		echo '<a href="options-general.php?page=different-menus-in-different-page" class="btn" style="display: inline-block;background-color: #4caf50;color: #FFFFFF;padding: 4px 15px;text-align: center;text-decoration: none;font-size: 16px;opacity: 0.9;border-radius: 4px;position: relative;margin-top: 19px;">'.__('Click here', 'different-menu') .'</a><span class="differen-menu" style="font-size: 16px;margin-left: 5px;">'. __('to go <span style="color: #0085ba;font-weight: bold;">Different menu in different page</span>\'s settings page.', 'different-menu') . '</span>';
	}


	public function goto_different_menu_page(){
		?>
			<style>
				.modal-dialog-centered::before {
						height: 0;
					}

				#duplicate_menu{
					z-index: 99999;
				}
			</style>
			<script>
				(function ($) {


				 jQuery(".menu-edit .publishing-action").prepend('<button type="button" class="btn btn-success menu-duplicate ml-1" data-toggle="modal" data-target="#duplicate_menu" style="font-size: 12px;">Duplicate Menus</button>');

				  jQuery('.manage-menus').after('<div class="go-to-different-menu"><a href="options-general.php?page=different-menus-in-different-pages" class="btn" style="display: inline-block;background-color: #4caf50;color: #FFFFFF;padding: 4px 15px;text-align: center;text-decoration: none;font-size: 16px;opacity: 0.9;border-radius: 4px;position: relative;margin-top: 19px;"><?php esc_html_e('Click here', 'different-menu'); ?></a><span class="differen-menu" style="font-size: 16px;margin-left: 5px;">to go <span style="color: #0085ba;font-weight: bold;">Different menu in different page</span>\'s settings page.</span></div>');


                  jQuery(document).on("click", ".btn.duplicate", function(){
                   		var selected_menu = jQuery("#menus.selected_menu").val();
                   		var new_menu_name = jQuery("#new_menu.new_menu_name").val();

                   		 var datas = {
                   		  "action"			: "create_duplicate_menu",
                   		  "selected_menu"	: selected_menu,
                   		  "new_menu_name"	: new_menu_name,
                   		  "nonce"			: "<?php echo wp_create_nonce( "recorp_different_menu" ); ?>"
                   		};

                   		var this_ = jQuery(this);
                   		
                   		jQuery.ajax({
                   		    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                   		    data: datas,
                   		    type: "post",
							
							  beforeSend: function( xhr ) {
							    this_.html("Duplicate <i class=\"fa fa-spinner fa-spin\" style=\"font-size:16px;\"></i>");
							  },

                   		
                   		    success: function(r){
                   		    	//console.log(r);

                   		    	this_.html("Duplicate");
                   		    	jQuery("#new_menu.new_menu_name").val("");

                   		    	jQuery("[data-dismiss=\"modal\"]").click();

                   		    	jQuery.notify({
				                    // options
				                    message: "Manu has been duplicated successfully." 
				                },{
				                    // settings
				                    type: "success",
				                    placement: {
				                        from: "top",
				                        align: "center"
				                    },
				                    animate:{
				                        enter: "animated fadeInDown",
				                        exit: "animated fadeOutUp"
				                    },
				                    delay: 5000
				                }

				                );

                   		    }, error: function(){
                   		    	alert("Something went wrong !");
                   		  }
                   		});
                  }); 


                  //jQuery('.menu-item-bar .item-title').append('<span class="dmidp_launchs">Different Menu</span>');

				}($|jQuery));
				
			</script>


<!-- Modal -->
<div class="modal" id="duplicate_menu"  data-easein="flipXIn" tabindex="2" role="dialog" aria-labelledby="resetDifferentMenusConditionsTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php esc_html_e('Duplicate a Menu', 'different-menu'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <div class="select-a-menu">
             <div class="default_menu clearfix">

                <label for="menus">Select a menu</label>
                <select class="form-control col-sm-6 float-left mr-2 selected_menu" id="menus" style="">
                    <?php 

	$menus = wp_get_nav_menus();
foreach ($menus as $key => $value) {
?>
                        <option slug="<?php echo $value->slug; ?>" value="<?php echo $value->slug; ?>">
                            <?php echo $value->name; ?>
                        </option>
                        <?php
}
?>
                </select>

                <div id="new_menu_name">
                    <input type="text" id="new_menu" class="form-control col-sm-6 float-left mt-3 new_menu_name" name="new_menu_name" placeholder="<?php esc_html_e('Enter new menu name', 'different-menu'); ?>">
                    <label for="new_menu" class="mt-3 ml-2">Enter a name</label>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php esc_html_e('Close', 'different-menu'); ?></button>
        <button type="button" class="btn btn-success duplicate"><?php esc_html_e('Duplicate', 'different-menu'); ?></button>
      </div>
    </div>
  </div>
</div>




		<?php
	}

	public function remove_default_menu(){
			
		//unregister_nav_menu('primary-menu');
		$locations 	= get_nav_menu_locations();
		if(isset($locations)){
			foreach ($locations as $location => $value) {
				if (is_home()) {
					unregister_nav_menu($location);

					break;
				}
			$menu = $this->remove_theme_location($location);

				
			}// end foreach
		}

	}

	public function remove_theme_location($location = "primary-menu" , $return = ""){

		$different_menus = get_option('different_menus_for_different_page');



	$assigned_menu = isset($different_menus[get_stylesheet()][$location])? $different_menus[get_stylesheet()][$location] : array();

		$single_condition = "";
		$menuId = "";	


	if (isset($assigned_menu)) {
		foreach ($assigned_menu as $menu_id => $conditions) { 
			$conditions = $conditions['name'];

			foreach ($conditions as $condition) {
				$single_condition  .= $condition . "&";
			}

				$menuId = str_replace("menu_", "", $menu_id);

				$condition = rtrim($single_condition, "&");

			if ( is_home() ) {

				return 'disable';	
			} 
		
		}

	}


	}




public function custom_plugin_row_meta( $links, $file ) {

	if ( strpos( $file, 'different-menus-in-different-page.php' ) !== false ) {
		$new_links = array(
				'different_menus_premium' => '<a style="color: red;font-weight: bold;" href="https://myrecorp.com/product/different-menus-in-different-pages/?clk=wp" target="_blank">Premium support</a>'
				);
		
		$links = array_merge( $links, $new_links );
	}
	
	return $links;
}


public function create_duplicate_menu(){


		if(check_ajax_referer( 'recorp_different_menu', 'nonce' ) && current_user_can('administrator')){
	$selected_menu = $_POST['selected_menu'];
	$new_menu_name = $_POST['new_menu_name'];


$menu_items = wp_get_nav_menu_items($selected_menu);


$term = wp_insert_term(
  $new_menu_name, // the term 
  'nav_menu' // the taxonomy
);

$term_taxonomy_id = $term['term_taxonomy_id'];




foreach ($menu_items as $key => $value) {
	
	$title = $value->title;
	$name = $value->post_name;
	$menu_order = $value->menu_order;

	$post_meta = get_post_meta($value->ID);

	$post_args = array(
		'post_author' => 1,
		'post_status' => 'publish',
		'post_title' => $title,
		'post_name' => $name,
		'comment_status' => 'closed',
		'ping_status' => 'closed',
		'post_type' => 'nav_menu_item',
		'menu_order' => $menu_order,
		'post_status' => 'publish',

	);
	$post_id = wp_insert_post($post_args);

	$this->recorp_add_term_relationships($post_id, $term_taxonomy_id);

$x = 0;
	foreach ($post_meta as $key) {
		$meta_key = array_keys($post_meta)[$x];
		$meta_value = $key[0];



		if ($meta_key == "_menu_item_object_id") {

			if ( ! add_post_meta( $post_id, '_menu_item_object_id', $value->ID, true ) ) { 
			   update_post_meta( $post_id, '_menu_item_object_id', $value->ID );

			}
		} else {

			if ( ! add_post_meta( $post_id, $meta_key, $meta_value, true ) ) { 
			   update_post_meta( $post_id, $meta_key, $meta_value );
			}
		}

		$x++;

	}
	
}

}
	die();
}



public function recorp_add_term_relationships($post_id, $tax_id){
	global $wpdb;

	$wpdb->insert( 
		$wpdb->prefix . 'term_relationships', 
		array( 
			'object_id' => $post_id,
			'term_taxonomy_id' => $tax_id
		), 
		array( 
			'%d',
			'%s',
		) 
	);

	return $object_id;
}

	public function dmidp_deactivate_reason(){
		if (file_exists(plugin_dir_path( __FILE__ ) . 'deactivate-reason/deactivate_reason.php')) {
			require_once plugin_dir_path( __FILE__ ) . 'deactivate-reason/deactivate_reason.php';
		}
		
	}

	public function dmidp_trial_dismiss_scripts(){
		?>
			<script>
				jQuery(document).on("click", ".dmidp_trial_notice .notice-dismiss", function(){
					 var datas = {
					  'action': 'dmidp_trial_dismiss_ajax',
					  'value': "",
					};
					
					jQuery.ajax({
					    url: '<?php echo admin_url('admin-ajax.php'); ?>',
					    data: datas,
					    type: 'post',
					
					    beforeSend: function(xhr){
					        
					    },
					    success: function(r){
					    	console.log(r);
					    }, error: function(){
					    	alert('Something went wrong !');
					  }
					});
				});


				jQuery(document).on("click", ".dmidp_notice .notice-dismiss", function(){
					if (jQuery(this).parent().attr('dmidp_notice_key').length) {
						 var datas = {
						  'action': 'dmidp_notice_has_clicked',
						  'rc_nonce': '<?php echo wp_create_nonce( "recorp_different_menu" ); ?>',
						  'dmidp_notice_key': jQuery(this).parent().attr('dmidp_notice_key'),
						};
						
						jQuery.ajax({
						    url: '<?php echo admin_url('admin-ajax.php'); ?>',
						    data: datas,
						    type: 'post',
						    dataType: 'json',
						
						    beforeSend: function(){
						
						    },
						    success: function(r){
						      if(r.success == 'true'){
						        console.log(r.response);
						
						        
						        } else {
						          alert('Something went wrong, please try again!');
						        }
						    	
						    }, error: function(){
						    	
						  }
						});
					}
				});
			</script>
		<?php
	}

	public function dmidp_trial_dismiss_ajax(){
		update_option('is_trial_notice_clicked', "1");
	
		die();
	}

	public function get_terms_hierarchical() {
		$terms = get_terms('category', array( 'hide_empty' => false, 'parent'=> 0));

		if (!empty($terms)) {
			$x = 1;
			foreach ($terms as $key => $term) {
				 if ($x % 2 == 0 ) {
                    $class = 'float-right';
                } else {
                    $class = 'float-left';
                }
				echo '<div class="parent_cat '.$class.'"><div class="parent"><label><input type="checkbox" name="tax[category][' . $term->slug . ']"  />' . $term->name . '</label></div>';

				$child_cats = get_terms('category', array( 'hide_empty' => false, 'parent'=> $term->term_id));

				if (!empty($child_cats)) {
					$this->get_terms_data_with_hierarchical($child_cats, 2);
				}

				echo '</div>';
				$x++;
			}
		}
	}

	public function get_terms_data_with_hierarchical($terms, $level = 1){
		if (!empty($terms)) {
			foreach ($terms as $key => $term) {

				echo '<div class="child_cats"><div class="child_cat cat_level_'.$level.'"><label><input type="checkbox" name="tax[category][' . $term->slug . ']"  />' . $term->name . '</label></div>';

				$child_cats = get_terms('category', array( 'hide_empty' => false, 'parent'=> $term->term_id));

				if (!empty($child_cats)) {
					$this->get_terms_data_with_hierarchical($child_cats, $level+1);
				}

				echo '</div>';
			}
		}
	}

	public function get_child_posts($posts, $level = 1){
		if (!empty($posts)) {
			$key = 'page';
			foreach ($posts as $key2 => $post) {

                echo '<div class="child_pages level_'.$level.'">';

				echo '<div class="child_page"><label><input type="checkbox" name="post_type[' . $key . '][' . $post->post_name . ']" />' . $post->post_title . '</label></div>';

				$child_posts = get_posts( array( 'post_type' => $key, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title', 'post_parent' => $post->ID) );

                if (!empty($child_posts)) {
                    $this->get_child_posts($child_posts, $level+1);
                }

                echo '</div>';
			}
		}
	}


	public function dmidp_notice_has_clicked(){
		//$post = $_POST['post'];
		$dmidp_notice_key = isset($_POST['dmidp_notice_key']) ? $_POST['dmidp_notice_key'] : "";
		$nonce = isset($_POST['rc_nonce']) ? $_POST['rc_nonce'] : "";

		if(!empty($nonce)){
			if(!wp_verify_nonce( $nonce, "recorp_different_menu" )){
				echo json_encode(array('success' => 'false', 'status' => 'nonce_verify_error', 'response' => ''));

				die();
			}
		}

		$clicked_notices = get_option('dmidp_notices_clicked_data');
		if (!empty($clicked_notices)) {
			$clicked_notices[] = $dmidp_notice_key;
		} else {
			$clicked_notices[0] = $dmidp_notice_key;
		}

		update_option('dmidp_notices_clicked_data', $clicked_notices);
		$response = "";

		
		echo json_encode(array('success' => 'true', 'status' => 'success', 'response' => $response));
	
		die();
	}
	

}


