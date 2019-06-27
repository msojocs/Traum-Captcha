<?php
// 判断是不是从 WordPress 后台调用的
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
exit;
}
global $wpdb;
delete_option("traum_captcha_database_install");
$wpdb->query( "DROP TABLE captcha_event" );
$wpdb->query( "DROP TABLE captcha_matrix" );
$wpdb->query( "DROP TABLE captcha_vcode" );