<?php

//设置
function traum_captcha_menu() {
    //$icon_url = plugins_url('/img/favicon.ico', __FILE__);
    $icon_url = null;
    add_menu_page(
        'Traum Captcha About Page',
        'Traum Captcha',
        'administrator',
        'traum_captcha',
        'display_traum_captcha'
        );
    add_submenu_page(
        'traum_captcha',//line 4 of add_menu_page
        'Database',
        'Database',
        'administrator',
        'traum_captcha_database',
        'display_traum_captcha_database'
        );
    add_submenu_page(
    'traum_captcha',                  // Register this submenu with the menu defined above
    __('Captcha Settings','Traum-Captcha'),          // The text to the display in the browser when this menu item is active
    __('Captcha Settings','Traum-Captcha'),                    // The text for this menu item
    'administrator',            // Which type of users can see this menu
    'traum_captcha_setting',          // The unique ID - the slug - for this menu item
    'traum_captcha_setting_display'   // The function used to render the menu for this page to the screen
);
}
add_action('admin_menu','traum_captcha_menu');
/*
function traum_captcha_menu_bar($admin_bar){
    $admin_bar->add_menu( array(
        'id'    => 'search-terms',
        'parent'=> 'traum_captcha',
        'title' => 'Search Terms',
        'href'  => admin_url('admin.php?page=traum_captcha_database'),
        'meta'  => array(
            'title' => __('Search Terms'),
        ),
    ));
}
//show admin bar
add_action('admin_bar_menu','traum_captcha_menu_bar');*/
function display_traum_captcha(){
    do_settings_sections('traum_captcha_about');
}

function display_traum_captcha_database() {
    //require "option.php";
    ?>
    <!-- Create a header in the default WordPress 'wrap' container -->
    <div class="wrap">
 
        <!-- Add the icon to the page -->
        <div id="icon-themes" class="icon32"></div>
        <h2>Traum Captcha Install Options</h2>
 
        <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
        <?php settings_errors();
        Traum_Captcha_install_check( get_option('traum_captcha_database_install'));
        ?>
 
        <!-- Create the form that will be used to render our options -->
        <form method="post" action="options.php">
            <?php settings_fields( 'traum_captcha_database' ); ?>
            <?php do_settings_sections( 'traum_captcha_database' ); ?>           
            <?php submit_button(); ?>
        </form>
 
    </div><!-- /.wrap -->
<?php
}

add_action('admin_init', 'traum_captcha_plugin_options');
function traum_captcha_plugin_options() {
 
   // If the theme options don't exist, create them.
  /*  if( false == get_option( 'traum_captcha_display_options' ) ) {  
        add_option( 'traum_captcha_display_options' );
    }*/ // end if
    // First, we register a section. This is necessary since all future options must belong to a 
    
    //Database page
    add_settings_section(
        'traum_captcha_database',         // ID used to identify this section and with which to register options
        'Traum Captcha About Page',                  // Title to be displayed on the administration page
        'traum_captcha_database', // Callback used to render the description of the section
        'traum_captcha_database'                           // Page on which to add this section of options
    );
     
    // Database Page
    add_settings_field( 
        'traum_captcha_database_install',                      // ID used to identify the field throughout the theme
        'state',                           // The label to the left of the option interface element
        'traum_captcha_database_callback',   // The name of the function responsible for rendering the option interface
        'traum_captcha_database',                          // The page on which this option will be displayed
        'traum_captcha_database',         // The name of the section to which this field belongs
        array(                              // The array of arguments to pass to the callback. In this case, just a description.
            'Activate this setting to display  ✔ and install database.'
        )
    );
    
     
    // Finally, we register the fields with WordPress
     
    register_setting(
        'traum_captcha_database',//page
        'traum_captcha_database_install'//field ID
    );
     
} 
function traum_captcha_about() {
    _e('<p>If you want use Traum Captcha ,please activate this setting and enjoy it.</p>');
    _e('<p>本页面只操作与本插件相关数据</p>
<p>插件开发参考于','Traum-Captcha'); ?><a href="https://hfo4.github.io/2018/08/30/captcha-for-cloudreve/">给Cloudreve添加化学式/矩阵/大事件验证码</a></p>
<?php
} // end sandbox_general_options_callback
 
function traum_captcha_database_callback($args) {
     
    // Note the ID and the name attribute of the element match that of the ID in the call to add_settings_field
    $html = '<input type="checkbox" id="traum_captcha_database_install" name="traum_captcha_database_install" value="1" ' . checked(1, get_option('traum_captcha_database_install'), false) . '/>'; 
     
    // Here, we'll take the first argument of the array and add it to a label next to the checkbox
    $html .= '<label for="traum_captcha_database_install"> '  . $args[0] . '</label>'; 
     
    echo $html;
     
} // end sandbox_toggle_header_callback

function traum_captcha_setting_display(){
    echo 'Traum Captcha Setting Page';
}
//设置end


function Traum_Captcha_insertsql() {
        global $wpdb;
        $results1 = $wpdb -> get_row("SELECT table_name FROM information_schema.TABLES WHERE table_name ='captcha_event'");
        $results2 = $wpdb -> get_row("SELECT table_name FROM information_schema.TABLES WHERE table_name ='captcha_matrix'");
        $results3 = $wpdb -> get_row("SELECT table_name FROM information_schema.TABLES WHERE table_name ='captcha_vcode'");
        if ($results1 && $results2 && $results3){
            echo('<div class="notice notice-error"><p>'.__('Already Installed', 'Traum-Captcha').'</p></div>');
        }else {
            //echo 'start';
            traum_captcha_database_insert(plugin_dir_path(__FILE__)."db/Captcha.sql",DB_NAME,DB_HOST,DB_USER,DB_PASSWORD);
            //echo 'end';
        }
    
}
//insert(plugin_dir_path(__FILE__)."db/Captcha.sql",DB_NAME,DB_HOST,DB_USER,DB_PASSWORD);
function traum_captcha_database_insert($file,$database,$name,$root,$pwd)
        {
            //将表导入数据库
            //header("Content-type: text/html; charset=utf-8");
            $_sql = file_get_contents($file);
            //写自己的.sql文件
            $_arr = explode(';
', $_sql);//此处不可修改，否则数据库可能无法成功导入
            $_mysqli = new mysqli($name,$root,$pwd,$database);
            //第一个参数为域名，第二个为用户名，第三个为密码，第四个为数据库名字
            if (mysqli_connect_errno()) {
                exit(_e('Database Connect Fail', 'Traum-Captcha'));
            } else {
                //执行sql语句
                $_mysqli->query('set names utf8;');
                //设置编码方式
                //global $wpdb;
                foreach ($_arr as $_value) {
                    $_mysqli->query($_value.';');
                   // $wpdb -> get_row($_value.';');
                }
                echo '<div class="notice notice-success"><p>'.__('Install Successful', 'Traum-Captcha').'</p></div>';
            }
            $_mysqli->close();
            $_mysqli = null;
}

function Traum_Captcha_install_check($install){
        if ($install == 1) {
        Traum_Captcha_insertsql();
    }else{
        global $wpdb;
        $wpdb->query( "DROP TABLE captcha_event" );
        $wpdb->query( "DROP TABLE captcha_matrix" );
        $wpdb->query( "DROP TABLE captcha_vcode" );
        echo '<div class="notice notice-success"><p>'.__('Delete Successful', 'Traum-Captcha').'</p></div>';
        }
}