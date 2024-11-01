<?php
	/*Plugin Name: WP Ads Auto Post
	Plugin URI: http://www.nexxuz.com/wp-ads-auto-post-plugin-wordpress.html
	Description: WP Auto Post ADS: a plugin that allows you to add advertising (Adsense) automatically in your posts. (Permite agregar publicidad o codigo HTML automaticamente en todos tus Articulos)
	Version: 1.3
	Author: Jodacame
	Author URI: http://nexxuz.com/*/
function wp_ads_auto_post($content){
	global $wpdb; 
		global $user_level;
	$dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
	$table_name = $wpdb->prefix . "wp_ads_auto_post";
	$posicion= $wpdb->get_var("SELECT posicion FROM $table_name  LIMIT 0, 1; " );
	$boton= $wpdb->get_var("SELECT boton FROM $table_name  LIMIT 0, 1; " );
	$size= $wpdb->get_var("SELECT size FROM $table_name  LIMIT 0, 1; " );
	$ads= $wpdb->get_var("SELECT ads FROM $table_name  LIMIT 0, 1; " );
	$userr= $wpdb->get_var("SELECT userr FROM $table_name  LIMIT 0, 1; " );
	
	include('template/wp_ads_auto_post.html');		
	
	
	return $content;
}
function wp_ads_auto_post_instalar(){
	global $wpdb; 
	$table_name= $wpdb->prefix . "wp_ads_auto_post";
   $sql = " CREATE TABLE $table_name(
		id mediumint( 9 ) NOT NULL AUTO_INCREMENT ,
		posicion varchar(25) NOT NULL ,
		boton int(1) NOT NULL ,
		size int(1) NOT NULL ,
		ads text NOT NULL,
		userr int(1) NOT NULL ,
		PRIMARY KEY (id)	
	) ;";
	
	$wpdb->query($sql);
	$ads="<!-- Paste your code here -->";
	$sql = "INSERT INTO $table_name VALUES ('','right',1,1,'$ads',0);";
		
	$wpdb->query($sql);
}
function wp_ads_auto_post_desinstalar(){
	global $wpdb; 
	$table_name = $wpdb->prefix . "wp_ads_auto_post";
	$sql = "DROP TABLE $table_name";
	$wpdb->query($sql);
}	
function wp_ads_auto_post_panel(){
		
	
	global $wpdb; 
	$table_name = $wpdb->prefix . "wp_ads_auto_post";
	if ($_POST['actualizar']==1){
	
		
			//$sql = "INSERT INTO $table_name (saludo) VALUES ('{$_POST['saludo_inserta']}');";
			$sql = "UPDATE $table_name set posicion=('{$_POST['posicion']}'),boton=({$_POST['boton']}),size=({$_POST['size']}),ads=('{$_POST['ads']}'),userr=('{$_POST['userr']}');";
	
		
		$wpdb->query($sql);
		echo '<div style="width:100%;background-color:#FFFF00;text-align:center;">Saved</div>';			
	}
			
			include('template/panel.html');	
		//    echo $sql;
			
}

function wp_ads_auto_post_add_menu(){	
	if (function_exists('add_options_page')) {
		//add_menu_page
		add_options_page('wp_ads_auto_post', 'WP ADS Auto Post', 8, basename(__FILE__), 'wp_ads_auto_post_panel');
	}
}
function writeCSS() {


 
}

if (function_exists('add_action')) {
	add_action('admin_menu', 'wp_ads_auto_post_add_menu'); 
}


add_action('activate_wp-ads-auto-post/wp_ads_auto_post.php','wp_ads_auto_post_instalar');
add_action('deactivate_wp-ads-auto-post/wp_ads_auto_post.php', 'wp_ads_auto_post_desinstalar');
add_action('the_content', 'wp_ads_auto_post');
add_action('wp_head', 'writeCSS');
?>
