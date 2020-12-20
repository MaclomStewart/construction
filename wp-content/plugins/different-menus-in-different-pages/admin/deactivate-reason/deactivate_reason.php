<?php

	global $current_user;
?>

		<div class="dmidp_wrap">
		  <div class="modal js-modal">
		    <div class="modal-image">
		    	<a href="https://myrecorp.com/?a=dmidp_deactivate_tab">
		      <img src="<?php echo plugin_dir_url( dirname(__DIR__) ) . 'admin/images/recorp-logo.png'; ?>" alt="ReCorp" width="100"></a>
		    </div>
		    <h1>Hi, <?php echo $current_user->user_firstname . " " . $current_user->user_lastname ; ?>!</h1>
		    <p>Thanks for being with us.</p>

		    <h4 style="margin-bottom: 5px;">Please let us know why you want to deactivate this plugin?</h4>

		    <span class="select-a-reason" style="color: red; font-weight: bold; display: none;">Please select a reason.</span>

			<div class="deactivate_reason">
				<input type="radio" id="not_working" name="deactivate_reason" value="not_working"><label for="not_working">Not working.</label>
			</div>

			<div class="deactivate_reason">
				<input type="radio" id="found_better_plugin" name="deactivate_reason" value="found_better_plugin"><label for="found_better_plugin">I found a better plugin.</label>
			</div>

			<div class="deactivate_reason">
				<input type="radio" id="bought_the_pro" name="deactivate_reason" value="bought_the_pro"><label for="bought_the_pro">I bought the pro version.</label>
			</div>

			<div class="deactivate_reason">
				<input type="radio" id="limited_feature" name="deactivate_reason" value="limited_feature"><label for="limited_feature">Limited Features.</label>
			</div>
			<div class="deactivate_reason" style="display: none;">
				<input type="radio" id="else" checked="" name="deactivate_reason" value="else"><label for="else">Else</label>
			</div>

			<div class="deactivate_reason">
				<input type="radio" id="other" name="deactivate_reason" value="other"><label for="other">Other</label>
				<textarea name="reason" id="deactivate_reasone_text" placeholder="Please enter a reason"></textarea>
			</div>

			

		    <p style="margin-top: 0;">Your feedback will help us to build our plugin more strong.</p>
		    <button class="js-close">Dismiss</button>
		    <button class="plugin-deactivate">Deactivate</button>
		  </div>
		</div>

		<div class="full_page_dark"></div>
		
		<link rel="stylesheet" href="<?php echo plugin_dir_url( __FILE__ ) . 'css/deactivate_reason.css'; ?>">

		<script>

			<?php echo 
			'/* <!\[CDATA\[ */
				var deactivate_reason = {"theme_url":"'.  get_stylesheet_directory_uri() .'",
					"members_url":"'.  get_home_url() . '/members' .'",
					"home_url":"'.  get_home_url() .'",
					"ajax_url":"'. get_admin_url() . 'admin-ajax.php' . '"
					};
			/* \]\]> */'; ?>
		
		</script>

		<script src="<?php echo plugin_dir_url( __FILE__ ) . 'js/modal.js'; ?>"></script>
		<script src="<?php echo plugin_dir_url( __FILE__ ) . 'js/coffee-script.js'; ?>"></script>
		<script src="<?php echo plugin_dir_url( __FILE__ ) . 'js/custom-scripts.js'; ?>"></script>
