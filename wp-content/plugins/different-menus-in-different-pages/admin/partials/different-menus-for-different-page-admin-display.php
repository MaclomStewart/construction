<div id="different-menus-settings-page">
    <!-- <div class="section"> -->
    <div class="container-fluid border-bottom mb-3">
        <div class="row pt-3 pb-3">
            <div class="col-md-12">
                <h4 class="border-bottom pb-1"><?php esc_html_e('Different menus in different pages', 'different-menu'); ?> <span class="badge badge-secondary">v<?php echo $this->version; ?></span></h4>
            </div>
        </div>

        <?php
		  		$name 		= get_registered_nav_menus();
		  		$menu_items = $menus = wp_get_nav_menus();
		  		$locations 	= get_nav_menu_locations();

		  	    $post_types =  get_post_types( array( 'public' => true ) );
				unset( $post_types['page'] );
				$post_types = array_map( 'get_post_type_object', $post_types );

				$taxonomies = get_taxonomies( array( 'public' => true ) );
				unset( $taxonomies['category'] );
				$taxonomies = array_map( 'get_taxonomy', $taxonomies );
                $posts_per_page = 26;

			?>

            <div class="row">
                <div class="col-md-8 border-right">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><?php esc_html_e('Theme Location', 'different-menu'); ?></th>
                                <th scope="col"><?php esc_html_e('Assigned Menu', 'different-menu'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
					  		foreach ($locations as $location => $value) {
                                if (!empty($value)) {
					  			$menu_objects = wp_get_nav_menu_object($value);
					  			$term_id = (isset($menu_objects->term_id))?$menu_objects->term_id:"0";
					  			?>
                                <tr>
                                    <td location="<?php echo $location; ?>">
                                        <?php echo $name[$location]; ?>
                                    </td>

                                    <td>

                                        <div class="default_menu clearfix">
                                            <select class="form-control col-sm-6 float-left mr-2 assigned_menu" id="menu_items" style="">
                                                <?php 
                        
                           
				      		foreach ($menu_items as $key => $value) {  
                                  
		  				?>
                                                    <option slug="<?php echo $value->slug; ?>" value="<?php echo $value->term_id; ?>" <?php echo ($term_id==$value->term_id)? "selected": ""; ?>>
                                                        <?php echo $value->name; ?>
                                                    </option>
                                                    <?php
			  				}
				      	?>
                                            </select>
                                            <span class="default description"><?php esc_html_e('Default', 'different-menu'); ?></span>
                                        </div>

                                        <div class="different_menus_list">
                                            <?php 
	$different_menus = get_option('different_menus_for_different_page');

	$assigned_menu = isset($different_menus[get_stylesheet()][$location])? $different_menus[get_stylesheet()][$location] : array();

$menu_count = 0;
if (isset($assigned_menu)) {
    $menu_count++;

        foreach ($assigned_menu as $menu_id => $conditions) { 

            $disable_menu = $menu_id;
			$menu_id = str_replace("menu_", "", $menu_id);
		?>							
									<div class="menu_items clearfix">
                                        <select class="form-control col-sm-6 float-left mr-2 assigned_menu" id="menu_items" 
                                                        selected_menu = "<?php echo $menu_id; ?>">
                                                    <option><?php esc_html_e('- Select a Menu -', 'different-menu'); ?></option>
                                                    <?php foreach ($menu_items as $key => $value) { ?>
                                                        <option slug="<?php echo $value->slug; ?>" value="<?php echo $value->term_id; ?>" <?php echo ($menu_id==$value->term_id)? "selected": ""; ?>>
                                                            <?php echo $value->name; ?>
                                                        </option>
                                                        <?php } ?>
                                                </select>

                                                <?php 

                                                	$conditions = $conditions['name'];

                                                	$single_condition = "";
                                                	foreach ($conditions as $condition) {
                                                		$single_condition .= '[name=\'' . $condition . "'],";
                                                	}

                                                	$single_condition = rtrim($single_condition, ",");
                                                ?>
                                                <a href="#" class="setup button" data-toggle="modal" conditions="<?php echo $single_condition; ?>"><i class="fas fa-cogs"></i> <?php esc_html_e('Setup', 'different-menu'); ?></a>

                                                <button type="button" class="close menu-delete float-left" aria-label="Close" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr('Remove this menu', 'different-menu'); ?>">
												  <span aria-hidden="true">&times;</span>
												</button>
											</div>
                                                <?php } }  ?>


                                        </div>
                                        <div class="content">
                                            <a href="#" class="btn right add_different_menu">
                                                <span class="left title">
										    		<span class="slant-left"></span>
										    		<?php esc_html_e('Add Different Menu', 'different-menu'); ?>
												</span>
                                                <span class="right icon fa fa-plus-square"></span>
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                                <?php
					  		} }

                            if ($menu_count == 0) {
                                echo '<tr><td>You didn\'t created any menu yet! <a href="nav-menus.php" style="color: #007bff;">Create here!</a></td></tr>';
                            }
					  	 ?>
                        </tbody>
                    </table>

                    <div class="all_menu_options" style="display: none;">

                        <div class="new_different_menu menu_items clearfix">
                            <select class="form-control col-sm-6 float-left mr-2 assigned_menu" id="menu_items" style="">
                                <option value=""><?php esc_html_e('- Select a Menu -', 'different-menu'); ?></option>
                                <?php 
				      		foreach ($menu_items as $key => $value) {
		  				?>
                                    <option slug="<?php echo $value->slug; ?>" value="<?php echo $value->term_id; ?>">
                                        <?php echo $value->name; ?>
                                    </option>
                                    <?php
			  				}
				      	?>
                            </select>

                            <a href="#" class="setup button" data-toggle="modal"><i class="fas fa-cogs"></i><?php esc_html_e('Setup', 'different-menu'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 support">
                      <div class="created py-2 mt-1 border-bottom"> <?php esc_html_e('Created by', 'different-menu'); ?> <a href="https://myrecorp.com/?clk=wp"><img src="<?php echo plugin_dir_url( __DIR__ ) . 'images/recorp-logo.png'; ?>" alt="ReCorp" width="100"></a></div>

                      <div class="documentation my-2">
                          <span><?php esc_html_e('See the documentation', 'different-menu'); ?> </span> <a href="https://myrecorp.com/different-menus/documentation/?clk=wp"><?php esc_html_e('here', 'different-menu'); ?></a>
                      </div>  
                    <div class="support my-2">
                          <span><?php esc_html_e('Need support ? Then do not waste your time. Just ', 'different-menu'); ?></span> <a href="https://myrecorp.com/different-menus/support/?clk=wp"><?php esc_html_e('click here', 'different-menu'); ?></a>
                    </div> 



                    <div class="pro mt-3">
                        <span class="go_pro"><a href="https://myrecorp.com/product/different-menus-in-different-pages/?clk=wp&a=pro"><?php _e('Go to pro', 'different-menu'); ?></a></span>

                          <!-- 
                            <br>

                          <span style="position: relative; top: 30px;font-weight: bold;"> We are offering 20% discount for you for very limited time! </span> -->
                    </div> 

                    <div class="right_side_notice mt-4">
                        <?php do_action('dmidp_right_side_notice'); ?>
                    </div>

                    <div class="plugin_rating mt-4">
                        <p id="rate-left" class="alignleft">
                        If you like <strong>this plugin</strong> please leave us a <a href="https://wordpress.org/support/plugin/different-menus-in-different-pages/reviews?rate=5#new-post" target="_blank" class="wc-rating-link" aria-label="five star" data-rated="Thanks :)">★★★★★</a> rating. <br>A huge thanks in advance!  </p>
                        
                    </div>
<!-- 
                    <div class="pro mt-5" style="position: relative; top: 15px;">
                          <span class="go_pro"><a href="https://myrecorp.com/product/different-menus-in-different-pages-trial/?clk=wp&r=free" style="background-color: #ff6e00;">Download Trial Version</a></span>
                            <br>

                          <span style="position: relative; top: 30px;font-weight: bold;"> No credit card needed! </span>
                    </div>  -->



                 </div>
            </div>
    </div>
    <!-- </div> -->
</div>

<div id="set_conditions" class="modal" data-easein="flipXIn" tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                            <?php esc_html_e('Add different menu conditions', 'different-menu'); ?>
                        </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">

                <div class="tabs">
                    <div class="tab-button-outer">
                        <ul id="tab-button">
                            <li><a href="#general"><?php esc_html_e('General', 'different-menu'); ?></a></li>
                            <li><a href="#templates"><?php esc_html_e('Templates', 'different-menu'); ?></a></li>
                            <li><a href="#pages"><?php esc_html_e('Pages', 'different-menu'); ?></a></li>
                            <li><a href="#categories"><?php esc_html_e('Categories', 'different-menu'); ?></a></li>
                            <!-- <li><a href="#single-categories">Categories Singles</a></li> -->
                            <li><a href="#post_types"><?php esc_html_e('Post Types', 'different-menu'); ?></a></li>
                            <li><a href="#taxonomies"><?php esc_html_e('Taxonomies', 'different-menu'); ?></a></li>
                            <li><a href="#user_roles"><?php esc_html_e('User Roles', 'different-menu'); ?></a></li>
                            <li><a href="#devices"><?php esc_html_e('Devices', 'different-menu'); ?></a></li>
                            <li><a href="#locations"><?php esc_html_e('Locations', 'different-menu'); ?></a></li>
                        </ul>
                    </div>
                    <div class="tab-select-outer">
                        <select id="tab-select">
                            <option value="#general"><?php esc_html_e('General', 'different-menu'); ?></option>
                            <option value="#templates"><?php esc_html_e('Templates', 'different-menu'); ?></option>
                            <option value="#pages"><?php esc_html_e('Pages', 'different-menu'); ?></option>
                            <option value="#categories"><?php esc_html_e('Categories', 'different-menu'); ?></option>
                            <!-- <option value="#single-categories">Categories Singles</option> -->
                            <option value="#post_types"><?php esc_html_e('Post Types', 'different-menu'); ?></option>
                            <option value="#taxonomies"><?php esc_html_e('Taxonomies', 'different-menu'); ?></option>
                            <option value="#user_roles"><?php esc_html_e('User Roles', 'different-menu'); ?></option>
                            <option value="#devices"><?php esc_html_e('Devices', 'different-menu'); ?></option>
                            <li><a href="#locations"><?php esc_html_e('Locations', 'different-menu'); ?></a></li>
                        </select>
                    </div>

                    <div id="general" class="tab-contents">
                        <?php

        $output = "";
        $output .= '<div id="tab-items" class="tab-items-general clearfix">';
            
            $output .= '<div class="title">Normal pages</div>';
            $output .= '<label><input type="checkbox" name="general[home]"  />' . __( 'Home page', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[frontpage]"  />' . __( 'Front page', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[blogpage]"  />' . __( 'Blog page', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[page]"  />' . __( 'All Page', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[sticky_post]"  />' . __( 'Sticky Post', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[single]"  />' . __( 'Single post', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[rtl]"  />' . __( 'Right to Left (rtl) Page', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[404]"  />' . __( '404 (page not found)', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[search]"  />' . __( 'Search pages', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[author]"  />' . __( 'Author pages', 'different-menu' ) . '</label>';

            $output .= '<div class="title">Archive pages</div>';
            $output .= '<label><input type="checkbox" name="general[category]"  />' . __( 'Category archive', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[tag]"  />' . __( 'Tag archive', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[date]"  />' . __( 'Date archive pages', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[year]"  />' . __( 'Year based archive', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[month]"  />' . __( 'Month based archive', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[day]"  />' . __( 'Day based archive', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[logged]"  />' . __( 'User logged in', 'different-menu' ) . '</label>';
            $output .= '<label><input type="checkbox" name="general[none_logged]"  />' . __( 'None logged user', 'different-menu' ) . '</label>';

            /* General - custom post types */
            $output .= '<div class="title">Single custom post types</div>';
            foreach( get_post_types( array( 'public' => true, 'exclude_from_search' => false, '_builtin' => false ) ) as $key => $post_type ) {
                $post_type = get_post_type_object( $key );
                $output .= '<label><input type="checkbox" name="general['. $key .']"  />' . sprintf( __( 'Single %s', 'different-menu' ), $post_type->labels->singular_name ) . '</label>';
            }

            /* Custom taxonomies archives */

            $output .= '<div class="title">Custom taxonomies archive pages</div>';
            foreach( get_taxonomies( array( 'public' => true, '_builtin' => false ) ) as $key => $tax ) {
                $tax = get_taxonomy( $key );

                $output .= '<label><input type="checkbox" name="general['. $key .']"  />' . sprintf( __( '%s Archive', 'different-menu' ), $tax->labels->singular_name ) . '</label>';
            }

            $output .= '</div>'; // tab-general

        echo $output;
     ?>
                    </div>
                    <div id="templates" class="tab-contents">

                        <div id="tab-items" class="tab-items-template clearfix">
                            <?php 

			$output = "";
			$templates = wp_get_theme()->get_page_templates();

			foreach ($templates as $key => $value) {

				$output .= '<label><input type="checkbox" name="template[' . $key . ']" />' . $value . ' ('. $key .')' . '</label>';
			}

			echo $output;
		?>
                        </div>
                    </div>
                    <div id="pages" class="tab-contents">
                        <?php
			$output = "";
			$key = 'page';
                $posts = get_posts( array( 'post_type' => $key, 'posts_per_page' => $posts_per_page, 'post_status' => 'publish', 'paged'=> 1, 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true, 'post_parent' => 0) );

				$posts2 = get_posts( array( 'post_type' => $key, 'posts_per_page' => -1, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true, 'post_parent' => 0) );
				if( ! empty( $posts ) ) {
					$i = 1;
					$page_id = 1;
					$num_of_single_pages = count($posts2);
					$num_of_pages = (int) ceil( $num_of_single_pages / $posts_per_page );
					$output .= '<div class="tab-items-inner" data-items="' . $num_of_single_pages . '" data-pages="' . $num_of_pages . '">';
					$output .= '<div id="tab-items" class="tab-items-page clearfix tab-items-page-' . $page_id . '">';

                    $x = 1;
					foreach ( $posts as $post ) :
						if ( $post->post_parent > 0 ) {
							$post->post_name = str_replace( home_url(), '', get_permalink( $post->ID ) );
						}
						/* note: slugs are more reliable than IDs, they stay unique after export/import */

                        $child_posts = get_posts( array( 'post_type' => $key, 'post_status' => 'publish', 'order' => 'ASC', 'orderby' => 'title',  'no_found_rows' => true, 'post_parent' => $post->ID) );

                        if ($x % 2 == 0 ) {
                            $class = 'float-right';
                        } else {
                            $class = 'float-left';
                        }

                        $output .= '<div class="parent_page '.$class.'">';

						$output .= '<div class="parent"><label><input type="checkbox" name="post_type[' . $key . '][' . $post->post_name . ']" />' . $post->post_title . '</label></div>';

                        if (!empty($child_posts)) {
                            ob_start();
                            $this->get_child_posts($child_posts, 1);
                            $output .= ob_get_clean();
                        }

                        $output .= '</div>';

						if ( $i === ($page_id * $posts_per_page) ) {
							$output .= '</div>';
							$page_id++;
							$output .= '<div class="tab-items-page tab-items-page-' . $page_id . ' is-hidden">';
						}
						$i++;
                        $x++;
					endforeach;
					$output .= '</div>';
					if ( $num_of_pages > 1 ) {
						$output .= '<ul class="pagination pagination-sm">';
						$output .= create_page_pagination( 1, $num_of_pages );
                        $output .= '</ul>';


					}
					$output .= '</div>';
				}

				echo $output;
		 ?>
                    </div>
                    <div id="categories" class="tab-contents">
                        <?php

    $output = "";

                $terms = get_terms( 'category', array( 'hide_empty' => false, 'parent' => 0 ) );
                if ( ! empty( $terms ) ) {
                    $i                   = 1;
                    $page_id             = 1;
                    $num_of_single_pages = count( $terms );
                    $num_of_pages        = (int) ceil( $num_of_single_pages / $posts_per_page );
                    $output              .= '<div class="tab-items-inner" data-items="' . $num_of_single_pages . '" data-pages="' . $num_of_pages . '">';
                    $output              .= '<div id="tab-items" class="tab-items-page clearfix tab-items-page-' . $page_id . '">';

                    ob_start();
                    $this->get_terms_hierarchical($terms);
                    $output .= ob_get_clean();

                    $output .= '</div>';
                    if ( $num_of_pages > 1 ) {
                        $output .= '<ul class="pagination pagination-sm">';
                        $output .= create_page_pagination( 1, $num_of_pages );
                        $output .= '</ul>';
                    }
                    $output .= '</div>';
                }

                echo $output;
            ?>


        </div>
                    
                    <div id="post_types" class="tab-contents">

                        <div class="tab_container">
                            <ul class="nav nav-pills nav-fill navtop border-bottom mb-2">
                                <?php
		$output = "";
    		foreach( $post_types as $key => $post_type ) {
						$checkboxs  = '<input type="checkbox" name="post_type[' . $key . ']"  /> ';

						$active_class= ($key == "post")?"active": "";

					if ($key !== "attachment") {
						$output .= '<li class="nav-item"><a href="#visibility-tab-' . $key . '" class="nav-link  ' . $active_class .'" data-toggle="tab">' . $post_type->label . '</a></li>';
					}
				}

				echo $output;
			?>
                            </ul>
                            <div class="tab-content">
                                <?php

		$output = "";
			foreach( $post_types as $key => $post_type ) {

				$active_class = ($key == "post")?"active": "";
				$output .= '<div id="visibility-tab-'. $key .'" post_type="'.$key.'" class="tab-pane '.$active_class.' clearfix" role="tabpanel">';
				$output .= '<div id="tab-items" class="tab-items-post_type">';

                $posts = get_posts( array(
                            'posts_per_page' => $posts_per_page,
                            'post_type'        => $key,
                            'post_status'      => 'publish',
                            'orderby' => 'post_title',
                            'order' => 'ASC'
                        ) );

				$all_post = get_posts( array(
							'posts_per_page' => -1,
							'post_type'        => $key,
							'post_status'      => 'publish',
                            'orderby' => 'post_title',
                            'order' => 'ASC'
						) );

                $i                   = 1;
                //$page_id             = 1;
                $num_of_single_pages = count( $all_post );
                $num_of_pages        = (int) ceil( $num_of_single_pages / $posts_per_page );

				if( ! empty( $posts ) ) : foreach( $posts as $post ) :
					$output .= '<label><input type="checkbox" name="post_type['. $key .']['. $post->ID .']"  />' . $post->post_title . '</label>';
				endforeach;
                    if ( $num_of_pages > 1 ) {
                        $output .= '<ul class="pagination pagination-sm" style="float: left;position: relative;bottom: -20px;clear: left;">';
                        $output .= create_page_pagination( 1, $num_of_pages );
                        $output .= '</ul>';
                    } 
                endif;

				$output .= '</div></div>';
			}

			echo $output;

		?>

                            </div>
                        </div>

                    </div>
                    <div id="taxonomies" class="tab-contents">

                        <div class="tab_container">
                            <ul class="nav nav-pills nav-fill navtop border-bottom mb-2">
                                <?php
		$output = "";
    		foreach( $taxonomies as $key => $tax ) {

					$active_class = ($key == "post_tag")?"active": "";

					if ($key !== "attachment") {
						$output .= '<li class="nav-item"><a href="#visibility-tab-' . $key . '" class="nav-link ' . $active_class .'" data-toggle="tab">' . $tax->label . '</a></li>';
					}
				}

				echo $output;
			?>
                            </ul>
                            <div id="tab-items" class="tab-content">
                                <?php

		$output = "";

           

			foreach( $taxonomies as $key => $tax ) {
				$active_class = ($key == "post_tag")?"active": "";
				$output .= '<div id="visibility-tab-'. $key .'" tax="'.$key.'" class="tab-pane '.$active_class.' clearfix" role="tabpanel">';
				$terms = get_terms( $key, array( 'hide_empty' => false ) );


				if( ! empty( $terms ) ) : 

                    $i                   = 1;
                    $page_id             = 1;
                    $num_of_single_pages = count( $terms );
                    $num_of_pages        = (int) ceil( $num_of_single_pages / $posts_per_page );

                    foreach( $terms as $term ) :
					
                        if ($i <= $posts_per_page) {
                                $output .= '<label><input type="checkbox" name="tax['. $key .']['. $term->slug .']"  />' . $term->name . '</label>';
                        } 

                        $i++;

				    endforeach; 

                    if ( $num_of_pages > 1 ) {
                        $output .= '<ul class="pagination pagination-sm" style="float: left;position: relative;bottom: -20px;clear: left;">';
                        $output .= create_page_pagination( 1, $num_of_pages );
                        $output .= '</ul>';
                    }


            endif;
				$output .= '</div>';
			}


			echo $output;

		?>
                            </div>
                        </div>

                    </div>
                    <div id="user_roles" class="tab-contents">
                        <?php

   	$output = "";
   		$output .= '<div id="tab-items" class="tab-items-user_roles clearfix">';
		foreach( $GLOBALS['wp_roles']->roles as $key => $role ) {
			$output .= '<label><input type="checkbox" name="roles['. $key .']"  />' . $role['name'] . '</label>';
		}
		$output .= '</div>'; // tab-userroles

		echo $output;
	?>
                    </div>



                    <div id="devices" class="tab-contents">

                <div id="tab-items" class="clearfix">

                    <div class="premium">This option available for premium version only <span class="go_pro2"><a href="https://myrecorp.com/product/different-menus-in-different-pages/?clk=device-tab&a=pro">Buy Now</a></span></div>

                <div class="labels" style="filter: blur(0.5px);-webkit-filter: blur(0.5px);pointer-events: none;">
                    <label class="" ><input type="checkbox" name="version[android]"  /> <?php esc_html_e('Android', 'different-menu'); ?> <span class="question-circle" data-toggle="tooltip" title="<?php esc_html_e('Check this if you want to show the menu on all android device.', 'different-menu'); ?>"></span></label>

                    <label class="" ><input type="checkbox" name="version[ios]"  /> <?php esc_html_e('iPhone', 'different-menu'); ?> <span class="question-circle" data-toggle="tooltip" title="<?php esc_html_e('Check this if you want to show the menu on all iphone  device.', 'different-menu'); ?>"></span></label>

                    <label class="" ><input type="checkbox" name="version[mobile]"  /> <?php esc_html_e('Moble', 'different-menu'); ?> <span class="question-circle" data-toggle="tooltip" title="<?php esc_html_e('Check this if you want to show the menu on all mobile devices.', 'different-menu'); ?>"></span></label>

                    <label class="" ><input type="checkbox" name="version[tablet]"  /> <?php esc_html_e('Tablet', 'different-menu'); ?> <span class="question-circle" data-toggle="tooltip" title="<?php esc_html_e('Check this if you want to show the menu on all tablet devices.', 'different-menu'); ?>"></span></label>
                </div>

                </div>
                    </div>


                    <div id="locations" class="tab-contents">

                <div id="tab-items" class="clearfix">

                      <div class="premium">This option available for premium version only <span class="go_pro2"><a href="https://myrecorp.com/product/different-menus-in-different-pages/?clk=loc-tab&a=pro">Buy Now</a></span></div>

    <div style="filter: blur(0.5px);-webkit-filter: blur(0.5px);pointer-events: none;">
        <label><input type="checkbox" name="location[AF]"><span class="flag flag-af"></span> Afghanistan</label>
    <label><input type="checkbox" name="location[AX]"><span class="flag flag-ax"></span> Åland Islands</label>
    <label><input type="checkbox" name="location[AL]"><span class="flag flag-al"></span> Albania</label>
    <label><input type="checkbox" name="location[DZ]"><span class="flag flag-dz"></span> Algeria</label>
    <label><input type="checkbox" name="location[AS]"><span class="flag flag-as"></span> American Samoa</label>
    <label><input type="checkbox" name="location[AD]"><span class="flag flag-ad"></span> Andorra</label>
    <label><input type="checkbox" name="location[AO]"><span class="flag flag-ao"></span> Angola</label>
    <label><input type="checkbox" name="location[AI]"><span class="flag flag-ai"></span> Anguilla</label>
    <label><input type="checkbox" name="location[AQ]"><span class="flag flag-aq"></span> Antarctica</label>
    <label><input type="checkbox" name="location[AG]"><span class="flag flag-ag"></span> Antigua and Barbuda</label>
    <label><input type="checkbox" name="location[AR]"><span class="flag flag-ar"></span> Argentina</label>
    <label><input type="checkbox" name="location[AM]"><span class="flag flag-am"></span> Armenia</label>
    <label><input type="checkbox" name="location[AW]"><span class="flag flag-aw"></span> Aruba</label>
    <label><input type="checkbox" name="location[AU]"><span class="flag flag-au"></span> Australia</label>
    <label><input type="checkbox" name="location[AT]"><span class="flag flag-at"></span> Austria</label>
    <label><input type="checkbox" name="location[AZ]"><span class="flag flag-az"></span> Azerbaijan</label>
    <label><input type="checkbox" name="location[BS]"><span class="flag flag-bs"></span> Bahamas</label>
    <label><input type="checkbox" name="location[BH]"><span class="flag flag-bh"></span> Bahrain</label>
    <label><input type="checkbox" name="location[BD]"><span class="flag flag-bd"></span> Bangladesh</label>
    <label><input type="checkbox" name="location[BB]"><span class="flag flag-bb"></span> Barbados</label>
    <label><input type="checkbox" name="location[BY]"><span class="flag flag-by"></span> Belarus</label>
    <label><input type="checkbox" name="location[BE]"><span class="flag flag-be"></span> Belgium</label>
    <label><input type="checkbox" name="location[BZ]"><span class="flag flag-bz"></span> Belize</label>
    <label><input type="checkbox" name="location[BJ]"><span class="flag flag-bj"></span> Benin</label>
    <label><input type="checkbox" name="location[BM]"><span class="flag flag-bm"></span> Bermuda</label>
    <label><input type="checkbox" name="location[BT]"><span class="flag flag-bt"></span> Bhutan</label>
    <label><input type="checkbox" name="location[BO]"><span class="flag flag-bo"></span> Bolivia, Plurinational State of</label>
    <label><input type="checkbox" name="location[BQ]"><span class="flag flag-bq"></span> Bonaire, Sint Eustatius and Saba</label>
    <label><input type="checkbox" name="location[BA]"><span class="flag flag-ba"></span> Bosnia and Herzegovina</label>
    <label><input type="checkbox" name="location[BW]"><span class="flag flag-bw"></span> Botswana</label>
    <label><input type="checkbox" name="location[BV]"><span class="flag flag-bv"></span> Bouvet Island</label>
    <label><input type="checkbox" name="location[BR]"><span class="flag flag-br"></span> Brazil</label>
    <label><input type="checkbox" name="location[IO]"><span class="flag flag-io"></span> British Indian Ocean Territory</label>
    <label><input type="checkbox" name="location[BN]"><span class="flag flag-bn"></span> Brunei Darussalam</label>
    <label><input type="checkbox" name="location[BG]"><span class="flag flag-bg"></span> Bulgaria</label>
    <label><input type="checkbox" name="location[BF]"><span class="flag flag-bf"></span> Burkina Faso</label>
    <label><input type="checkbox" name="location[BI]"><span class="flag flag-bi"></span> Burundi</label>
    <label><input type="checkbox" name="location[KH]"><span class="flag flag-kh"></span> Cambodia</label>
    <label><input type="checkbox" name="location[CM]"><span class="flag flag-cm"></span> Cameroon</label>
    <label><input type="checkbox" name="location[CA]"><span class="flag flag-ca"></span> Canada</label>
    <label><input type="checkbox" name="location[CV]"><span class="flag flag-cv"></span> Cape Verde</label>
    <label><input type="checkbox" name="location[KY]"><span class="flag flag-ky"></span> Cayman Islands</label>
    <label><input type="checkbox" name="location[CF]"><span class="flag flag-cf"></span> Central African Republic</label>
    <label><input type="checkbox" name="location[TD]"><span class="flag flag-td"></span> Chad</label>
    <label><input type="checkbox" name="location[CL]"><span class="flag flag-cl"></span> Chile</label>
    <label><input type="checkbox" name="location[CN]"><span class="flag flag-cn"></span> China</label>
    <label><input type="checkbox" name="location[CX]"><span class="flag flag-cx"></span> Christmas Island</label>
    <label><input type="checkbox" name="location[CC]"><span class="flag flag-cc"></span> Cocos (Keeling) Islands</label>
    <label><input type="checkbox" name="location[CO]"><span class="flag flag-co"></span> Colombia</label>
    <label><input type="checkbox" name="location[KM]"><span class="flag flag-km"></span> Comoros</label>
    <label><input type="checkbox" name="location[CG]"><span class="flag flag-cg"></span> Congo</label>
    <label><input type="checkbox" name="location[CD]"><span class="flag flag-cd"></span> Congo, the Democratic Republic of the</label>
    <label><input type="checkbox" name="location[CK]"><span class="flag flag-ck"></span> Cook Islands</label>
    <label><input type="checkbox" name="location[CR]"><span class="flag flag-cr"></span> Costa Rica</label>
    <label><input type="checkbox" name="location[CI]"><span class="flag flag-ci"></span> Côte d'Ivoire</label>
    <label><input type="checkbox" name="location[HR]"><span class="flag flag-hr"></span> Croatia</label>
    <label><input type="checkbox" name="location[CU]"><span class="flag flag-cu"></span> Cuba</label>
    <label><input type="checkbox" name="location[CW]"><span class="flag flag-cw"></span> Curaçao</label>
    <label><input type="checkbox" name="location[CY]"><span class="flag flag-cy"></span> Cyprus</label>
    <label><input type="checkbox" name="location[CZ]"><span class="flag flag-cz"></span> Czech Republic</label>
    <label><input type="checkbox" name="location[DK]"><span class="flag flag-dk"></span> Denmark</label>
    <label><input type="checkbox" name="location[DJ]"><span class="flag flag-dj"></span> Djibouti</label>
    <label><input type="checkbox" name="location[DM]"><span class="flag flag-dm"></span> Dominica</label>
    <label><input type="checkbox" name="location[DO]"><span class="flag flag-do"></span> Dominican Republic</label>
    <label><input type="checkbox" name="location[EC]"><span class="flag flag-ec"></span> Ecuador</label>
    <label><input type="checkbox" name="location[EG]"><span class="flag flag-eg"></span> Egypt</label>
    <label><input type="checkbox" name="location[SV]"><span class="flag flag-sv"></span> El Salvador</label>
    <label><input type="checkbox" name="location[GQ]"><span class="flag flag-gq"></span> Equatorial Guinea</label>
    <label><input type="checkbox" name="location[ER]"><span class="flag flag-er"></span> Eritrea</label>
    <label><input type="checkbox" name="location[EE]"><span class="flag flag-ee"></span> Estonia</label>
    <label><input type="checkbox" name="location[ET]"><span class="flag flag-et"></span> Ethiopia</label>
    <label><input type="checkbox" name="location[FK]"><span class="flag flag-fk"></span> Falkland Islands (Malvinas)</label>
    <label><input type="checkbox" name="location[FO]"><span class="flag flag-fo"></span> Faroe Islands</label>
    <label><input type="checkbox" name="location[FJ]"><span class="flag flag-fj"></span> Fiji</label>
    <label><input type="checkbox" name="location[FI]"><span class="flag flag-fi"></span> Finland</label>
    <label><input type="checkbox" name="location[FR]"><span class="flag flag-fr"></span> France</label>
    <label><input type="checkbox" name="location[GF]"><span class="flag flag-gf"></span> French Guiana</label>
    <label><input type="checkbox" name="location[PF]"><span class="flag flag-pf"></span> French Polynesia</label>
    <label><input type="checkbox" name="location[TF]"><span class="flag flag-tf"></span> French Southern Territories</label>
    <label><input type="checkbox" name="location[GA]"><span class="flag flag-ga"></span> Gabon</label>
    <label><input type="checkbox" name="location[GM]"><span class="flag flag-gm"></span> Gambia</label>
    <label><input type="checkbox" name="location[GE]"><span class="flag flag-ge"></span> Georgia</label>
    <label><input type="checkbox" name="location[DE]"><span class="flag flag-de"></span> Germany</label>
    <label><input type="checkbox" name="location[GH]"><span class="flag flag-gh"></span> Ghana</label>
    <label><input type="checkbox" name="location[GI]"><span class="flag flag-gi"></span> Gibraltar</label>
    <label><input type="checkbox" name="location[GR]"><span class="flag flag-gr"></span> Greece</label>
    <label><input type="checkbox" name="location[GL]"><span class="flag flag-gl"></span> Greenland</label>
    <label><input type="checkbox" name="location[GD]"><span class="flag flag-gd"></span> Grenada</label>
    <label><input type="checkbox" name="location[GP]"><span class="flag flag-gp"></span> Guadeloupe</label>
    <label><input type="checkbox" name="location[GU]"><span class="flag flag-gu"></span> Guam</label>
    <label><input type="checkbox" name="location[GT]"><span class="flag flag-gt"></span> Guatemala</label>
    <label><input type="checkbox" name="location[GG]"><span class="flag flag-gg"></span> Guernsey</label>
    <label><input type="checkbox" name="location[GN]"><span class="flag flag-gn"></span> Guinea</label>
    <label><input type="checkbox" name="location[GW]"><span class="flag flag-gw"></span> Guinea-Bissau</label>
    <label><input type="checkbox" name="location[GY]"><span class="flag flag-gy"></span> Guyana</label>
    <label><input type="checkbox" name="location[HT]"><span class="flag flag-ht"></span> Haiti</label>
    <label><input type="checkbox" name="location[HM]"><span class="flag flag-hm"></span> Heard Island and McDonald Islands</label>
    <label><input type="checkbox" name="location[VA]"><span class="flag flag-va"></span> Holy See (Vatican City State)</label>
    <label><input type="checkbox" name="location[HN]"><span class="flag flag-hn"></span> Honduras</label>
    <label><input type="checkbox" name="location[HK]"><span class="flag flag-hk"></span> Hong Kong</label>
    <label><input type="checkbox" name="location[HU]"><span class="flag flag-hu"></span> Hungary</label>
    <label><input type="checkbox" name="location[IS]"><span class="flag flag-is"></span> Iceland</label>
    <label><input type="checkbox" name="location[IN]"><span class="flag flag-in"></span> India</label>
    <label><input type="checkbox" name="location[ID]"><span class="flag flag-id"></span> Indonesia</label>
    <label><input type="checkbox" name="location[IR]"><span class="flag flag-ir"></span> Iran, Islamic Republic of</label>
    <label><input type="checkbox" name="location[IQ]"><span class="flag flag-iq"></span> Iraq</label>
    <label><input type="checkbox" name="location[IE]"><span class="flag flag-ie"></span> Ireland</label>
    <label><input type="checkbox" name="location[IM]"><span class="flag flag-im"></span> Isle of Man</label>
    <label><input type="checkbox" name="location[IT]"><span class="flag flag-it"></span> Italy</label>
    <label><input type="checkbox" name="location[JM]"><span class="flag flag-jm"></span> Jamaica</label>
    <label><input type="checkbox" name="location[JP]"><span class="flag flag-jp"></span> Japan</label>
    <label><input type="checkbox" name="location[JE]"><span class="flag flag-je"></span> Jersey</label>
    <label><input type="checkbox" name="location[JO]"><span class="flag flag-jo"></span> Jordan</label>
    <label><input type="checkbox" name="location[KZ]"><span class="flag flag-kz"></span> Kazakhstan</label>
    <label><input type="checkbox" name="location[KE]"><span class="flag flag-ke"></span> Kenya</label>
    <label><input type="checkbox" name="location[KI]"><span class="flag flag-ki"></span> Kiribati</label>
    <label><input type="checkbox" name="location[KP]"><span class="flag flag-kp"></span> Korea, Democratic People's Republic of</label>
    <label><input type="checkbox" name="location[KR]"><span class="flag flag-kr"></span> Korea, Republic of</label>
    <label><input type="checkbox" name="location[KW]"><span class="flag flag-kw"></span> Kuwait</label>
    <label><input type="checkbox" name="location[KG]"><span class="flag flag-kg"></span> Kyrgyzstan</label>
    <label><input type="checkbox" name="location[LA]"><span class="flag flag-la"></span> Lao People's Democratic Republic</label>
    <label><input type="checkbox" name="location[LV]"><span class="flag flag-lv"></span> Latvia</label>
    <label><input type="checkbox" name="location[LB]"><span class="flag flag-lb"></span> Lebanon</label>
    <label><input type="checkbox" name="location[LS]"><span class="flag flag-ls"></span> Lesotho</label>
    <label><input type="checkbox" name="location[LR]"><span class="flag flag-lr"></span> Liberia</label>
    <label><input type="checkbox" name="location[LY]"><span class="flag flag-ly"></span> Libya</label>
    <label><input type="checkbox" name="location[LI]"><span class="flag flag-li"></span> Liechtenstein</label>
    <label><input type="checkbox" name="location[LT]"><span class="flag flag-lt"></span> Lithuania</label>
    <label><input type="checkbox" name="location[LU]"><span class="flag flag-lu"></span> Luxembourg</label>
    <label><input type="checkbox" name="location[MO]"><span class="flag flag-mo"></span> Macao</label>
    <label><input type="checkbox" name="location[MK]"><span class="flag flag-mk"></span> Macedonia, the former Yugoslav Republic of</label>
    <label><input type="checkbox" name="location[MG]"><span class="flag flag-mg"></span> Madagascar</label>
    <label><input type="checkbox" name="location[MW]"><span class="flag flag-mw"></span> Malawi</label>
    <label><input type="checkbox" name="location[MY]"><span class="flag flag-my"></span> Malaysia</label>
    <label><input type="checkbox" name="location[MV]"><span class="flag flag-mv"></span> Maldives</label>
    <label><input type="checkbox" name="location[ML]"><span class="flag flag-ml"></span> Mali</label>
    <label><input type="checkbox" name="location[MT]"><span class="flag flag-mt"></span> Malta</label>
    <label><input type="checkbox" name="location[MH]"><span class="flag flag-mh"></span> Marshall Islands</label>
    <label><input type="checkbox" name="location[MQ]"><span class="flag flag-mq"></span> Martinique</label>
    <label><input type="checkbox" name="location[MR]"><span class="flag flag-mr"></span> Mauritania</label>
    <label><input type="checkbox" name="location[MU]"><span class="flag flag-mu"></span> Mauritius</label>
    <label><input type="checkbox" name="location[YT]"><span class="flag flag-yt"></span> Mayotte</label>
    <label><input type="checkbox" name="location[MX]"><span class="flag flag-mx"></span> Mexico</label>
    <label><input type="checkbox" name="location[FM]"><span class="flag flag-fm"></span> Micronesia, Federated States of</label>
    <label><input type="checkbox" name="location[MD]"><span class="flag flag-md"></span> Moldova, Republic of</label>
    <label><input type="checkbox" name="location[MC]"><span class="flag flag-mc"></span> Monaco</label>
    <label><input type="checkbox" name="location[MN]"><span class="flag flag-mn"></span> Mongolia</label>
    <label><input type="checkbox" name="location[ME]"><span class="flag flag-me"></span> Montenegro</label>
    <label><input type="checkbox" name="location[MS]"><span class="flag flag-ms"></span> Montserrat</label>
    <label><input type="checkbox" name="location[MA]"><span class="flag flag-ma"></span> Morocco</label>
    <label><input type="checkbox" name="location[MZ]"><span class="flag flag-mz"></span> Mozambique</label>
    <label><input type="checkbox" name="location[MM]"><span class="flag flag-mm"></span> Myanmar</label>
    <label><input type="checkbox" name="location[NA]"><span class="flag flag-na"></span> Namibia</label>
    <label><input type="checkbox" name="location[NR]"><span class="flag flag-nr"></span> Nauru</label>
    <label><input type="checkbox" name="location[NP]"><span class="flag flag-np"></span> Nepal</label>
    <label><input type="checkbox" name="location[NL]"><span class="flag flag-nl"></span> Netherlands</label>
    <label><input type="checkbox" name="location[NC]"><span class="flag flag-nc"></span> New Caledonia</label>
    <label><input type="checkbox" name="location[NZ]"><span class="flag flag-nz"></span> New Zealand</label>
    <label><input type="checkbox" name="location[NI]"><span class="flag flag-ni"></span> Nicaragua</label>
    <label><input type="checkbox" name="location[NE]"><span class="flag flag-ne"></span> Niger</label>
    <label><input type="checkbox" name="location[NG]"><span class="flag flag-ng"></span> Nigeria</label>
    <label><input type="checkbox" name="location[NU]"><span class="flag flag-nu"></span> Niue</label>
    <label><input type="checkbox" name="location[NF]"><span class="flag flag-nf"></span> Norfolk Island</label>
    <label><input type="checkbox" name="location[MP]"><span class="flag flag-mp"></span> Northern Mariana Islands</label>
    <label><input type="checkbox" name="location[NO]"><span class="flag flag-no"></span> Norway</label>
    <label><input type="checkbox" name="location[OM]"><span class="flag flag-om"></span> Oman</label>
    <label><input type="checkbox" name="location[PK]"><span class="flag flag-pk"></span> Pakistan</label>
    <label><input type="checkbox" name="location[PW]"><span class="flag flag-pw"></span> Palau</label>
    <label><input type="checkbox" name="location[PS]"><span class="flag flag-ps"></span> Palestinian Territory, Occupied</label>
    <label><input type="checkbox" name="location[PA]"><span class="flag flag-pa"></span> Panama</label>
    <label><input type="checkbox" name="location[PG]"><span class="flag flag-pg"></span> Papua New Guinea</label>
    <label><input type="checkbox" name="location[PY]"><span class="flag flag-py"></span> Paraguay</label>
    <label><input type="checkbox" name="location[PE]"><span class="flag flag-pe"></span> Peru</label>
    <label><input type="checkbox" name="location[PH]"><span class="flag flag-ph"></span> Philippines</label>
    <label><input type="checkbox" name="location[PN]"><span class="flag flag-pn"></span> Pitcairn</label>
    <label><input type="checkbox" name="location[PL]"><span class="flag flag-pl"></span> Poland</label>
    <label><input type="checkbox" name="location[PT]"><span class="flag flag-pt"></span> Portugal</label>
    <label><input type="checkbox" name="location[PR]"><span class="flag flag-pr"></span> Puerto Rico</label>
    <label><input type="checkbox" name="location[QA]"><span class="flag flag-qa"></span> Qatar</label>
    <label><input type="checkbox" name="location[RE]"><span class="flag flag-re"></span> Réunion</label>
    <label><input type="checkbox" name="location[RO]"><span class="flag flag-ro"></span> Romania</label>
    <label><input type="checkbox" name="location[RU]"><span class="flag flag-ru"></span> Russian Federation</label>
    <label><input type="checkbox" name="location[RW]"><span class="flag flag-rw"></span> Rwanda</label>
    <label><input type="checkbox" name="location[BL]"><span class="flag flag-bl"></span> Saint Barthélemy</label>
    <label><input type="checkbox" name="location[SH]"><span class="flag flag-sh"></span> Saint Helena, Ascension and Tristan da Cunha</label>
    <label><input type="checkbox" name="location[KN]"><span class="flag flag-kn"></span> Saint Kitts and Nevis</label>
    <label><input type="checkbox" name="location[LC]"><span class="flag flag-lc"></span> Saint Lucia</label>
    <label><input type="checkbox" name="location[MF]"><span class="flag flag-mf"></span> Saint Martin (French part)</label>
    <label><input type="checkbox" name="location[PM]"><span class="flag flag-pm"></span> Saint Pierre and Miquelon</label>
    <label><input type="checkbox" name="location[VC]"><span class="flag flag-vc"></span> Saint Vincent and the Grenadines</label>
    <label><input type="checkbox" name="location[WS]"><span class="flag flag-ws"></span> Samoa</label>
    <label><input type="checkbox" name="location[SM]"><span class="flag flag-sm"></span> San Marino</label>
    <label><input type="checkbox" name="location[ST]"><span class="flag flag-st"></span> Sao Tome and Principe</label>
    <label><input type="checkbox" name="location[SA]"><span class="flag flag-sa"></span> Saudi Arabia</label>
    <label><input type="checkbox" name="location[SN]"><span class="flag flag-sn"></span> Senegal</label>
    <label><input type="checkbox" name="location[RS]"><span class="flag flag-rs"></span> Serbia</label>
    <label><input type="checkbox" name="location[SC]"><span class="flag flag-sc"></span> Seychelles</label>
    <label><input type="checkbox" name="location[SL]"><span class="flag flag-sl"></span> Sierra Leone</label>
    <label><input type="checkbox" name="location[SG]"><span class="flag flag-sg"></span> Singapore</label>
    <label><input type="checkbox" name="location[SX]"><span class="flag flag-sx"></span> Sint Maarten (Dutch part)</label>
    <label><input type="checkbox" name="location[SK]"><span class="flag flag-sk"></span> Slovakia</label>
    <label><input type="checkbox" name="location[SI]"><span class="flag flag-si"></span> Slovenia</label>
    <label><input type="checkbox" name="location[SB]"><span class="flag flag-sb"></span> Solomon Islands</label>
    <label><input type="checkbox" name="location[SO]"><span class="flag flag-so"></span> Somalia</label>
    <label><input type="checkbox" name="location[ZA]"><span class="flag flag-za"></span> South Africa</label>
    <label><input type="checkbox" name="location[GS]"><span class="flag flag-gs"></span> South Georgia and the South Sandwich Islands</label>
    <label><input type="checkbox" name="location[SS]"><span class="flag flag-ss"></span> South Sudan</label>
    <label><input type="checkbox" name="location[ES]"><span class="flag flag-es"></span> Spain</label>
    <label><input type="checkbox" name="location[LK]"><span class="flag flag-lk"></span> Sri Lanka</label>
    <label><input type="checkbox" name="location[SD]"><span class="flag flag-sd"></span> Sudan</label>
    <label><input type="checkbox" name="location[SR]"><span class="flag flag-sr"></span> Suriname</label>
    <label><input type="checkbox" name="location[SJ]"><span class="flag flag-sj"></span> Svalbard and Jan Mayen</label>
    <label><input type="checkbox" name="location[SZ]"><span class="flag flag-sz"></span> Swaziland</label>
    <label><input type="checkbox" name="location[SE]"><span class="flag flag-se"></span> Sweden</label>
    <label><input type="checkbox" name="location[CH]"><span class="flag flag-ch"></span> Switzerland</label>
    <label><input type="checkbox" name="location[SY]"><span class="flag flag-sy"></span> Syrian Arab Republic</label>
    <label><input type="checkbox" name="location[TW]"><span class="flag flag-tw"></span> Taiwan, Province of China</label>
    <label><input type="checkbox" name="location[TJ]"><span class="flag flag-tj"></span> Tajikistan</label>
    <label><input type="checkbox" name="location[TZ]"><span class="flag flag-tz"></span> Tanzania, United Republic of</label>
    <label><input type="checkbox" name="location[TH]"><span class="flag flag-th"></span> Thailand</label>
    <label><input type="checkbox" name="location[TL]"><span class="flag flag-tl"></span> Timor-Leste</label>
    <label><input type="checkbox" name="location[TG]"><span class="flag flag-tg"></span> Togo</label>
    <label><input type="checkbox" name="location[TK]"><span class="flag flag-tk"></span> Tokelau</label>
    <label><input type="checkbox" name="location[TO]"><span class="flag flag-to"></span> Tonga</label>
    <label><input type="checkbox" name="location[TT]"><span class="flag flag-tt"></span> Trinidad and Tobago</label>
    <label><input type="checkbox" name="location[TN]"><span class="flag flag-tn"></span> Tunisia</label>
    <label><input type="checkbox" name="location[TR]"><span class="flag flag-tr"></span> Turkey</label>
    <label><input type="checkbox" name="location[TM]"><span class="flag flag-tm"></span> Turkmenistan</label>
    <label><input type="checkbox" name="location[TC]"><span class="flag flag-tc"></span> Turks and Caicos Islands</label>
    <label><input type="checkbox" name="location[TV]"><span class="flag flag-tv"></span> Tuvalu</label>
    <label><input type="checkbox" name="location[UG]"><span class="flag flag-ug"></span> Uganda</label>
    <label><input type="checkbox" name="location[UA]"><span class="flag flag-ua"></span> Ukraine</label>
    <label><input type="checkbox" name="location[AE]"><span class="flag flag-ae"></span> United Arab Emirates</label>
    <label><input type="checkbox" name="location[GB]"><span class="flag flag-gb"></span> United Kingdom</label>
    <label><input type="checkbox" name="location[US]"><span class="flag flag-us"></span> United States</label>
    <label><input type="checkbox" name="location[UM]"><span class="flag flag-um"></span> United States Minor Outlying Islands</label>
    <label><input type="checkbox" name="location[UY]"><span class="flag flag-uy"></span> Uruguay</label>
    <label><input type="checkbox" name="location[UZ]"><span class="flag flag-uz"></span> Uzbekistan</label>
    <label><input type="checkbox" name="location[VU]"><span class="flag flag-vu"></span> Vanuatu</label>
    <label><input type="checkbox" name="location[VE]"><span class="flag flag-ve"></span> Venezuela, Bolivarian Republic of</label>
    <label><input type="checkbox" name="location[VN]"><span class="flag flag-vn"></span> Viet Nam</label>
    <label><input type="checkbox" name="location[VG]"><span class="flag flag-vg"></span> Virgin Islands, British</label>
    <label><input type="checkbox" name="location[VI]"><span class="flag flag-vi"></span> Virgin Islands, U.S.</label>
    <label><input type="checkbox" name="location[WF]"><span class="flag flag-wf"></span> Wallis and Futuna</label>
    <label><input type="checkbox" name="location[EH]"><span class="flag flag-eh"></span> Western Sahara</label>
    <label><input type="checkbox" name="location[YE]"><span class="flag flag-ye"></span> Yemen</label>
    <label><input type="checkbox" name="location[ZM]"><span class="flag flag-zm"></span> Zambia</label>
    <label><input type="checkbox" name="location[ZW]"><span class="flag flag-zw"></span> Zimbabwe</label>
                </div>
                </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <div class="check_all" style="position: absolute;left: 50px;margin-top: 6px;">
                    <input type="checkbox" id="check_all">
                    <label for="check_all"> Check all</label>
                </div>

                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">
                    Close
                </button>
                <button class="btn btn-primary save_conditions">
                    <?php esc_html_e('Save changes', 'different-menu'); ?>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="checked_items" style="display:none"></div>

<?php

  	function create_page_pagination( $current_page, $num_of_pages ) {
        $links_in_the_middle = 4;
        $links_in_the_middle_min_1 = $links_in_the_middle - 1;
        $first_link_in_the_middle   = $current_page - floor( $links_in_the_middle_min_1 / 2 );
        $last_link_in_the_middle    = $current_page + ceil( $links_in_the_middle_min_1 / 2 );
        if ( $first_link_in_the_middle <= 0 ) {
            $first_link_in_the_middle = 1;
        }
        if ( ( $last_link_in_the_middle - $first_link_in_the_middle ) != $links_in_the_middle_min_1 ) {
            $last_link_in_the_middle = $first_link_in_the_middle + $links_in_the_middle_min_1;
        }
        if ( $last_link_in_the_middle > $num_of_pages ) {
            $first_link_in_the_middle = $num_of_pages - $links_in_the_middle_min_1;
            $last_link_in_the_middle  = (int) $num_of_pages;
        }
        if ( $first_link_in_the_middle <= 0 ) {
            $first_link_in_the_middle = 1;
        }
        $pagination = '';
        if ( $current_page != 1 ) {
            $pagination .= '<li class="page-item"><a class="page-link" page_id="'.( $current_page - 1 ).'" href="/page/' . ( $current_page - 1 ) . '">Previous</a></li>';
        }
        if ( $first_link_in_the_middle >= 3 && $links_in_the_middle < $num_of_pages ) {
            $pagination .= '<li class="page-item"><a class="page-link" href="/page/" class="page-numbers">1</a></li>';

            if ( $first_link_in_the_middle != 2 ) {
                $pagination .= '<span class="page-numbers extend">...</span>';
            }
        }
        for ( $i = $first_link_in_the_middle; $i <= $last_link_in_the_middle; $i ++ ) {
            if ( $i == $current_page ) {
                $pagination .= '<li class="page-item active"><a class="page-link" page_id="'.$i.'" href="#">'.$i.'<span class="sr-only">(current)</span></a></li>';
            } else {
                $pagination .= '<li class="page-item"><a class="page-link" href="/page/' . $i . '" page_id="'.$i.'" class="page-numbers">' . $i . '</a></li>';
            }
        }
        if ( $last_link_in_the_middle < $num_of_pages ) {
            if ( $last_link_in_the_middle != ( $num_of_pages - 1 ) ) {
                $pagination .= '<span class="page-numbers extend" style="padding: 0 5px;">...</span>';
            }
            $pagination .= '<li class="page-item"><a class="page-link" href="/page/' . $num_of_pages . '" page_id="'.$num_of_pages.'" class="page-numbers">' . $num_of_pages . '</a></li>';
        }
        if ( $current_page != $last_link_in_the_middle ) {
            $pagination .= '<li class="page-item"><a class="page-link" href="/page/' . ( $current_page + 1 ) . '" page_id="'.($current_page + 1).'" class="next page-numbers">Next</a></li>';
        }

        return $pagination;
    }

	?>

	<button class="btn btn-danger" type="reset" data-toggle="modal" data-target="#resetDifferentMenusConditions"><?php esc_html_e('Reset', 'different-menu'); ?></button>

    <!--  data-toggle="tooltip" data-title="<?php esc_html_e('This option available for premium version only', 'different-menu'); ?>" -->

<span class="d-inline-block">
	<button type="button" class="btn btn-success backup-restore" data-toggle="modal" data-target="#backupAndRestore">

  <?php esc_html_e('Backup or Restore', 'different-menu'); ?>
</button>
</span>

<a href="nav-menus.php" class="btn btn-success float-right text-white mr-3"><?php esc_html_e('Go to menu settings page', 'different-menu'); ?></a>

<a href="" class="btn btn-success float-right text-white mr-3" data-toggle="modal" data-target="#duplicate_menu"><?php esc_html_e('Duplicate Menus', 'different-menu'); ?></a>


    <input type="hidden" class="setup_active_menu">
    <input type="hidden" class="change_selected_menu">




<!-- Modal -->
<div class="modal" id="resetDifferentMenusConditions"  data-easein="flipXIn" tabindex="2" role="dialog" aria-labelledby="resetDifferentMenusConditionsTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php esc_html_e('Are you sure ?', 'different-menu'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6><?php esc_html_e('You want to reset those settings?', 'different-menu'); ?></h6>
        <h6><?php esc_html_e('You may backup those settings first!', 'different-menu'); ?></h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php esc_html_e('Close', 'different-menu'); ?></button>
        <button type="button" class="btn btn-danger remove_diff_menus"><?php esc_html_e('Reset', 'different-menu'); ?></button>
      </div>
    </div>
  </div>
</div>


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
                    <label for="new_menu" class="mt-3 ml-2"><?php _e('Enter a name', 'different-menu'); ?></label>
                    
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


<!-- Modal -->
<div class="modal" id="backupAndRestore" tabindex="3" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php esc_html_e('Backup or Restore', 'different-menu'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-success btn-backup_settings"><?php esc_html_e('Backup settings', 'different-menu'); ?></button>
        <span class="description"><?php esc_html_e('Click here to backup settings data.', 'different-menu'); ?></span>

        <br>
        <br>
        

        <input type="file" id="restore_settings" accept=".csv">
        <br>
        <span class="description"><?php esc_html_e('Select a backup file to restore settings.', 'different-menu'); ?></span>

        <div class="restore_settings_data_as_txt hidden">
            
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php esc_html_e('Close', 'different-menu'); ?></button>
            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-title="<?php esc_html_e('This option available for premium version only', 'different-menu'); ?>" disabled=""><?php esc_html_e('Restore', 'different-menu'); ?></button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal" id="removeMenu"  data-easein="flipXIn" tabindex="4" role="dialog" aria-labelledby="backupAndRestoreTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php esc_html_e('Are you sure?', 'different-menu'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <h6><?php esc_html_e('You want to delete the menu?', 'different-menu'); ?></h6>
        <h6><?php esc_html_e('You may backup those settings first!', 'different-menu'); ?></h6>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php esc_html_e('Close', 'different-menu'); ?></button>
        <button type="button" class="btn btn-danger remove_diff_menu"><?php esc_html_e('Delete', 'different-menu'); ?></button>
      </div>
    </div>
  </div>
</div>
