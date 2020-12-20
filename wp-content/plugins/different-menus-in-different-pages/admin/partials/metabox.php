<?php

class Different_Menu_Meta_Box {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {
		if(current_user_can('administrator')){
			add_action( 'add_meta_boxes', array( $this, 'add_metabox' ), 10, 2        );
			add_action( 'save_post', array( $this, 'save_metabox' ), 10, 2 );
		}
	}

	public function add_metabox($post_type, $post) {
		if ($post_type !== "attachment") {
			add_meta_box(
				'different_menu',
				__( 'Set Different Menu' . $post_type, 'text_domain' ),
				array( $this, 'render_metabox' ),
				'',
				'advanced',
				'default'
			);
		}
	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		//wp_nonce_field( 'different_menu_action', 'different_menu' );

		// Retrieve an existing value from the database.
		$diff_menus = get_post_meta( $post->ID, 'different_menu', true );

		// Set default values.
		if( empty( $diff_menus ) ) $diff_menus = array();

		$name 		= get_registered_nav_menus();
  		$menu_items = wp_get_nav_menus();
  		$locations 	= get_nav_menu_locations();

ob_start();
?>

<style>
.different-menu {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

.different-menu td, .different-menu th {
  border: 1px solid #ddd;
  padding: 8px;
}

/* .different-menu tr:nth-child(even){background-color: #f2f2f2;} */

.different-menu tr:hover {background-color: #ddd;}

.different-menu th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #6fda44;
  color: white;
}

.differen_menu_change .premium {
	position: absolute;
	left: 24%;
	top: 53%;
	z-index: 2;
	font-size: 149%;
	color: red;
	font-weight: bold;
}
.differen_menu_change .premium {
	font-size: 149%;
	color: red;
	font-weight: bold;
}
.go_pro {
	padding: 10px;
}


</style>		

				<div class="differen_menu_change">
					<div class="premium">This option available for premium version only <span class="go_pro"><a href="https://myrecorp.com/product/different-menus-in-different-pages/?clk=wp&a=pro">Go to pro</a></span></div>
					<table class="table different-menu" style="filter: blur(0.5px);-webkit-filter: blur(0.5px);pointer-events: none;">
                        <thead>
                            <tr>
                                <th scope="col"><?php esc_html_e('Theme Location', 'different-menu'); ?></th>
                                <th scope="col"><?php esc_html_e('Assigned Menu', 'different-menu'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                           if (!empty($diff_menus)) {
                           	 $diff_menus = json_decode($diff_menus);
                           }
                            
                        if(isset($locations)){
					  		foreach ($locations as $location => $value) {
					  			$menu_objects = wp_get_nav_menu_object($value);
					  			$term_id = (isset($menu_objects->term_id))?$menu_objects->term_id:"0";
					  			?>
                                <tr  style="margin-bottom: 20px;">
                                    <td location="<?php echo $location; ?>">
                                        <?php echo $name[$location]; ?>
                                    </td>

                                    <td>

                                        <div class="default_menu clearfix" >
                                            <select class="form-control col-sm-6 float-left mr-2 assigned_menu" id="menu_items" name="different_menu[<?php echo $location; ?>]">
                                            	<option value="">- Select a menu -</option>
                                                <?php 
				      		foreach ($menu_items as $key => $value) {
		  				?>
                                                    <option slug="<?php echo $value->slug; ?>" value="<?php echo $value->term_id; ?>" <?php echo (isset($diff_menus->$location)&&$diff_menus->$location==$value->term_id)? "selected": ""; ?>>
                                                        <?php echo ($term_id==$value->term_id)? $value->name . ' (default)' : $value->name; ?>
                                                    </option>
                                                    <?php
			  				}
				      	?>
                                            </select>

                                        </div>


                                    </td>
                                </tr>

                                <?php } }?>
                        </tbody>
                    </table>
				</div>
                    <input type="hidden" name="is_different_menu_changed" class="is_different_menu_changed">

                    <script>
                    	jQuery(document).on("change", ".different-menu .assigned_menu", function(){

                    		jQuery('.is_different_menu_changed').val("changed");
                    		
                    	});
                    </script>


<?php

echo ob_get_clean();

}

	public function save_metabox( $post_id, $post ) {

	}

	public function change_different_menu($args){
		
	}

}

new Different_Menu_Meta_Box;