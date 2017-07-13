<?php
/**
 * Plugin Name: Daily Maui Photo Widget
 * Plugin URI: http://www.webnelly.com/widgets/daily-maui-photo
 * Description: A widget that displays a new photo of Maui each day.
 * Version: 0.2
 * Author: Kris Nelson
 * Author URI: http://www.webnelly.com
 *
 */
	//include("dmp_client_wp.php");
	
	global $wp_version;	
	
	$exit_msg='Daily Maui Photo requires WordPress 2.6 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';
	
	if (version_compare($wp_version,"2.6","<"))
	{
		exit ($exit_msg);
	}

	$wp_dailymaui_plugin_dir = trailingslashit( WP_PLUGIN_DIR .'/'. dirname( plugin_basename(__FILE__) ) );
	$wp_dailymaui_plugin_url = trailingslashit( WP_PLUGIN_URL.'/'. dirname( plugin_basename(__FILE__) ) );
	$wp_dailymaui_base_url = "http://api.dailymauiphoto.com/widget/";

	function WPDailyMaui_WidgetControl()
	{
		// get saved options
		$options = get_option('wp_dailymaui');
		
		// handle user input
		if ($_POST["dailymaui_submit"]) {
		  // retireve wall title from the request
		  $options['dailymaui_title'] = strip_tags(stripslashes($_POST["dailymaui_title"]));
		  
		  $options['dailymaui_size'] = $_POST["dailymaui_size"];
		  
		  // update the options to database
		  update_option('wp_dailymaui', $options);
		}
		
		$title = $options['dailymaui_title'];
		
		$size = $options['dailymaui_size'];
		if ($size == "") $size = "small";
		
		// handle selection for drop down
		$selected = "selected='selected'";
		switch ($size)
		{
			case "small": $selected_small = $selected; break;
			case "medium": $selected_medium = $selected; break;
			case "classic": $selected_full = $selected; break;
			case "thumb": $selected_thumb = $selected; break;
			case "date": $selected_date = $selected; break;
			default: $selected_small = $selected; break;
		}
		//if ($size == "small") $selected_small = $selected;
		//elseif ($size == "medium") $selected_medium = $selected;
		//elseif ($size == "classic") $selected_full = $selected;
		
		
		// print out the widget control    
		include('wp-dailymaui-widget-control.php');
	}

	function WPDailyMaui_Widget($args = array())
	{
		global $wp_dailymaui_base_url;
		
		// extract the parameters
		extract($args);
		
		// get our options
		$options = get_option('wp_dailymaui');
		$title = $options['dailymaui_title'];
		$size = $options['dailymaui_size'];
		
		if ($size == "") 
		{
			$size = "small";
			$options['dailymaui_size'] = $size;			
			update_option('wp_dailymaui', $options);
		}
		
		// get entry
		//$entry = WPDailyMaui_GetEntry();
		//$entry = WPDailyMaui_GetApiEntry($size);
		
		// print the theme compatibility code
		echo $before_widget;
		if (isset($title) and $title != "")
			echo $before_title . $title . $after_title;
		
		// include our widget
		switch($size)
		{
			case "small" : 
				$js_file = "s.js";
				break;
			case "medium" :
				$js_file = "m.js";
				break;
			case "thumb" :
				$js_file = "t.js";
				break;
			case "date" :
				$js_file = "d.js";
				break;
			case "classic" :
				$js_file = "f.js";
				break;
			default : 
				$js_file = "s.js";
				break;
		}
		
		echo "<script type='text/javascript' src='{$wp_dailymaui_base_url}{$js_file}'></script>";
		
		echo $after_widget;
	}


	function WPDailyMaui_Init()
	{
		// register widget
		register_sidebar_widget('Daily Maui Photo', 'WPDailyMaui_Widget');
		
		// alternative way
		//$widget_optionss = array('classname' => 'WPWall_Widget', 'description' => "A comments 'Wall' for your sidebar." );
		//wp_register_sidebar_widget('WPWall_Widget', 'WP Wall', 'WPWall_Widget', $widget_options);
		
		// register widget control
		register_widget_control('Daily Maui Photo', 'WPDailyMaui_WidgetControl');
		
		$options = get_option('wp_dailymaui');
		
	}

	add_action('init', 'WPDailyMaui_Init');

	//add_action('wp_head', 'WPDailyMaui_HeadAction');

	function WPDailyMaui_HeadAction() {
		//global $wp_dailymaui_plugin_url;
		
		//$options = get_option('wp_dailymaui');
		//$size = $options['dailymaui_size'];		
		//if ($size == "") $size = "small";		
		
		//echo '<link rel="stylesheet" href="'.$wp_dailymaui_plugin_url.'wp-dailymaui-' . $size . '.css" type="text/css" />'; 
	}	

?>