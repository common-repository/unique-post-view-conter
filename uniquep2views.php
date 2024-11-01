<?php
/*
  Plugin Name: Unique post View Conter
  Plugin URI: http://www.spicyclassified.com
  Description: Using this plugin you can show how many unique users view your posts and pages, That means we can get unique users count.
  Version: 1.0
  Author: Chandra sekhar Gudavalli
  License: GPLv2
 */

function unique_p2_table(){ return "uniquep2views";}

/* When a plugin is activated  below function is fired for creating table  */
function unique_p2_table_install() {
    global $wpdb;
    $p2_table = $wpdb->prefix.unique_p2_table();
    if ($wpdb->get_var("SHOW TABLES LIKE '$p2_table'") != $p2_table) {

        echo $sql = "CREATE TABLE " . $p2_table .
                "( id  INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		           post_id int( 10 ) NOT NULL,
				   ip_addres varchar( 60 ) NOT NULL,
                   view int( 10 ) NOT NULL,
                   view_datetime datetime NOT NULL DEFAULT '0000-00-00 00:00:00');";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

/* When a plugin is deactivated  below function is fired for deleting table  */
function unique_p2_table_drop() {
    global $wpdb;
    $p2_table = $wpdb->prefix.unique_p2_table();
    if ($wpdb->get_var("SHOW TABLES LIKE '$p2_table'") == $p2_table) {
        $sql = "DROP TABLE " . $p2_table;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

/* using this function we can get the total count of specific post of page */
if (!function_exists('total_views')) {
    function total_views($post_id) {

        if (update_views($post_id) == 1) {
            $views = get_total_views_count($post_id);
            echo number_format_i18n($views);
        } else {
            echo 1;
        }
    }
}

function insert_views($views, $post_id) {
    global $wpdb;
    $p2_table = $wpdb->prefix.unique_p2_table();
	$result = $wpdb->query("INSERT INTO $p2_table VALUES(NULL ,$post_id,'".$_SERVER['REMOTE_ADDR']."',1,NOW())");
    return ($result);
}

function update_views($post_id) {
    global $wpdb;
    $p2_table = $wpdb->prefix.unique_p2_table();
    $views = get_total_views($post_id) + 1;
 
	if (get_total_views($post_id) == 0)
        insert_views($views, $post_id);
	   $result = $wpdb->query("UPDATE $p2_table SET view = $views WHERE ip_addres = '".$_SERVER['REMOTE_ADDR']."'");
   return ($result);
}

function get_total_views($post_id) {
    global $wpdb;
    $p2_table = $wpdb->prefix.unique_p2_table();
	 $result = $wpdb->get_results("SELECT view FROM $p2_table WHERE post_id = '$post_id' AND ip_addres =  '".$_SERVER['REMOTE_ADDR']."'", ARRAY_A);
    if (!is_array($result) || empty($result)) {
        return "0";
    } else {
        return $result[0]['view'];
    }
}

function get_total_views_count($post_id){
	global $wpdb;
    $p2_table = $wpdb->prefix.unique_p2_table();
	 $result = $wpdb->get_results("SELECT SUM( VIEW ) as totalcount FROM $p2_table WHERE post_id = '$post_id'", ARRAY_A);
    if (!is_array($result) || empty($result)) {
        return "0";
    } else {
        return $result[0]['totalcount'];
    }
}

function get_unique_views($post_id) {
    global $wpdb;
    $p2_table = $wpdb->prefix.unique_p2_table();
	 $result = $wpdb->get_results(" SELECT DISTINCT COUNT( ip_addres ) as uniqueview FROM $p2_table WHERE post_id ='$post_id' ", ARRAY_A);

	if (!is_array($result) || empty($result)) {
        return "0";
    } else {
        return $result[0]['uniqueview'];
    }
}

/* using this function we can get the count of unique users for sepecific post of page */
if (!function_exists('unique_views')) {
    function unique_views($post_id) {

        if (update_views($post_id) == 1) {
            $views = get_unique_views($post_id);
            echo number_format_i18n($views);
        } else {
            echo 1;
        }
    }
}

register_activation_hook(__FILE__, unique_p2_table_install());
register_uninstall_hook(__FILE__, unique_p2_table_drop());
?>