<?php

//设置
function traum_captcha_menu() {
    //$icon_url = plugins_url('/img/favicon.ico', __FILE__);
    $icon_url = null;
    add_menu_page(
        __('Traum Captcha About Page','Traum-Captcha'),
        'Traum Captcha',
        'administrator',
        'traum_captcha',
        'traum_captcha_about'
        );
        
    add_submenu_page(
        'traum_captcha',//line 4 of add_menu_page
        __('Database','Traum-Captcha'),//页面标题
        __('Database','Traum-Captcha'),//左侧菜单
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
        
    add_submenu_page(
        'traum_captcha',                  // Register this submenu with the menu defined above
        __('Update','Traum-Captcha'),          // The text to the display in the browser when this menu item is active
        __('Update','Traum-Captcha'),                    // The text for this menu item
        'administrator',                // Which type of users can see this menu
        'traum_captcha_update',          // The unique ID - the slug - for this menu item
        'traum_captcha_update_display'   // The function used to render the menu for this page to the screen
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

function display_traum_captcha_database() {
    ?>
    <!-- Create a header in the default WordPress 'wrap' container -->
    <div class="wrap">
        <!-- Add the icon to the page -->
        <div id="icon-themes" class="icon32"></div><h2>
        <?php  _e('Traum Captcha Install Options','Traum-Captcha'); ?>
 </h2>
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
        'traum_captcha_database',                         // ID used to identify this section and with which to register options
        __('Traum Captcha Database Page','Traum-Captcha'),                    // Title to be displayed on the administration page
        'traum_captcha_database',                         // Callback used to render the description of the section
        'traum_captcha_database'                          // Page on which to add this section of options
    );
     
    // Database Page
    add_settings_field( 
        'traum_captcha_database_install',                      // ID used to identify the field throughout the theme
        
        __('<p>If you want use Traum Captcha ,please activate this setting and enjoy it.</p>','Traum-Captcha'),                           // The label to the left of the option interface element
        'traum_captcha_database_callback',   // The name of the function responsible for rendering the option interface
        'traum_captcha_database',                          // The page on which this option will be displayed
        'traum_captcha_database',         // The name of the section to which this field belongs
        array(                              // The array of arguments to pass to the callback. In this case, just a description.
            __('Activate this setting to display  ✔ and install database.','Traum-Captcha')
        )
    );
    
    // Finally, we register the fields with WordPress
    register_setting(
        'traum_captcha_database',//page
        'traum_captcha_database_install'//field ID
    );
     
} 
function traum_captcha_about() {
    _e('<p>This plugin include Chemical、Historical、Matrix verification code</p>
<p>The core of plugin development is referenced to','Traum-Captcha'); ?><a href="https://hfo4.github.io/2018/08/30/captcha-for-cloudreve/">给Cloudreve添加化学式/矩阵/大事件验证码</a></p>
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
    _e('<h2>Traum Captcha Setting Page</h2>
    <br>Some functions will be added future.
    ','Traum-Captcha');
}

function traum_captcha_update_display(){
    global $version;
    _e('<h2>Traum Captcha Update Page</h2>','Traum-Captcha');
    traum_captcha_update($version);
}
//Setting end
