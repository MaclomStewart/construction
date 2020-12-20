<?php

function rc_task_events_activate() {
    if (! wp_next_scheduled ( 'dmidp_daily_schedules' )) {
        wp_schedule_event( time(), 'daily', 'dmidp_daily_schedules');
    }
}

add_action( 'dmidp_daily_schedules', 'dmidp_active_cron_job_after_five_second', 10, 2 );
function dmidp_active_cron_job_after_five_second() {
	$home_url = get_home_url();
	$notices = file_get_contents('http://api.myrecorp.com/dmidp_notices.php?version=free&url='.$home_url);
    update_option('dmidp_notices', $notices);
}

function rc_task_events_deactivate() {
    wp_clear_scheduled_hook( 'dmidp_daily_schedules' );
}

function dmidp_right_side_notice(){
	$notices = get_option('dmidp_notices');
	$notices = json_decode($notices);
	$html = "";

	if (!empty($notices)) {
		foreach ($notices as $key => $notice) {
			$title = $notice->title;
			$key = $notice->key;
			$publishing_date = $notice->publishing_date;
			$auto_hide = $notice->auto_hide;
			$auto_hide_date = $notice->auto_hide_date;
			$is_right_sidebar = $notice->is_right_sidebar;
			$content = $notice->content;
			$status = $notice->status;
			$version = isset($notice->version) ? $notice->version : array();
			$styles = isset($notice->styles) ? $notice->styles : "";

			$current_time = time();
			$publish_time = strtotime($publishing_date);
			$auto_hide_time = strtotime($auto_hide_date);

			if ( $status && $is_right_sidebar == 1 && $current_time > $publish_time && $current_time < $auto_hide_time && in_array('free', $version) ) {
				$html .= '<div class="sidebar_notice_section">';
				$html .=	'<div class="right_notice_title">'.$title.'</div>';
				$html .=	'<div class="right_notice_details">'.$content.'</div>';
				$html .= '</div>';

				if ( !empty($styles) ) {
					$html .= '<style>' . $styles . '</style>';
				}
			}
		}
	}

	echo $html;
}
add_action("dmidp_right_side_notice", "dmidp_right_side_notice");

function dmidp_admin_notices(){


	$notices = get_option('dmidp_notices');
	$notices = json_decode($notices);
	$html = "";

	
	if (!empty($notices)) {
		foreach ($notices as $key2 => $notice) {
			$title = isset($notice->title) ? $notice->title : "";
			$key = isset($notice->key) ? $notice->key : "";
			$publishing_date = isset($notice->publishing_date) ? $notice->publishing_date : time();
			$auto_hide = isset($notice->auto_hide) ? $notice->auto_hide : false;
			$auto_hide_date = isset($notice->auto_hide_date) ? $notice->auto_hide_date : time();
			$is_right_sidebar = isset($notice->is_right_sidebar) ? $notice->is_right_sidebar : true;
			$content = isset($notice->content) ? $notice->content : "";
			$status = isset($notice->status) ? $notice->status : false;
			$alert_type = isset($notice->alert_type) ? $notice->alert_type : "success";
			$version = isset($notice->version) ? $notice->version : array();
			$styles = isset($notice->styles) ? $notice->styles : "";

			$current_time = time();
			$publish_time = strtotime($publishing_date);
			$auto_hide_time = strtotime($auto_hide_date);

			$clicked_data = (array) get_option('dmidp_notices_clicked_data');

			if ( $status && !$is_right_sidebar && $current_time > $publish_time && $current_time < $auto_hide_time && !in_array($key, $clicked_data) && in_array('free', $version) ) {
				$html .=  '<div class="notice notice-'. $alert_type .' is-dismissible dcim-alert dmidp_notice" dmidp_notice_key="'.$key.'">
						'.$content.'
					</div>';

				if ( !empty($styles) ) {
					$html .= '<style>' . $styles . '</style>';
				}
			}
		}
	}

	echo $html;

}
add_action('admin_notices', 'dmidp_admin_notices');