<?php

//设置
function traum_captcha_menu() {
    //$icon_url = plugins_url('/img/favicon.ico', __FILE__);
    $icon_url = null;
    add_menu_page(
        '设置页面',
        'Traum Captcha',
        'administrator',
        'traum_captcha_setting_page',
        'traum_captcha_setting_callback'
        );
}
add_action('admin_menu','traum_captcha_menu');

function traum_captcha_setting_display() {
    
}

function traum_captcha_plugin_options() {
 
    //setting page
    add_settings_section(
        'traum_captcha_setting_section',                         // ID used to identify this section and with which to register options
        '数据库设置部分',                    // Title to be displayed on the administration page
        'traum_captcha_setting_section_callback',                         // Callback used to render the description of the section
        'traum_captcha_setting_page'                          // Page on which to add this section of options
    );
     
    // setting Page
    add_settings_field( 
        'traum_captcha_database_install',                      // ID used to identify the field throughout the theme
        __('<p>If you want use Traum Captcha ,please activate this setting and enjoy it.</p>','Traum-Captcha'),                           // The label to the left of the option interface element
        'traum_captcha_database_install_callback',   // The name of the function responsible for rendering the option interface
        'traum_captcha_setting_page',                          // The page on which this option will be displayed
        'traum_captcha_setting_section',         // The name of the section to which this field belongs
        array(                              // The array of arguments to pass to the callback. In this case, just a description.
            __('Activate this setting to display  ✔ and install database.', 'Traum-Captcha')
        )
    );
    
    // Finally, we register the fields with WordPress
    register_setting('traum_captcha_setting_field','traum_captcha_database_install');
     
}
add_action('admin_init', 'traum_captcha_plugin_options');

function traum_captcha_setting_callback() {
    echo '<h1>说明</h1>';
    _e('<p>This plugin include Chemical、Historical、Matrix verification code</p>
<p>The core of plugin development is referenced to','Traum-Captcha'); 
?>
    <a href="https://hfo4.github.io/2018/08/30/captcha-for-cloudreve/">给Cloudreve添加化学式/矩阵/大事件验证码</a></p>
        <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
        
        <!-- Create the form that will be used to render our options -->
        <form method="post" action="options.php">
            <?php settings_fields('traum_captcha_setting_field'); ?>
            <?php do_settings_sections('traum_captcha_setting_page'); ?>           
            <?php submit_button(); ?>
        </form>
 
<?php
} // end sandbox_general_options_callback

function traum_captcha_setting_section_callback()
{
    echo '数据库状态：';
    settings_errors();
    Traum_Captcha_install_check( get_option('traum_captcha_database_install'));
}

function traum_captcha_database_install_callback($args) {
    // Note the ID and the name attribute of the element match that of the ID in the call to add_settings_field
    $html = '<input type="checkbox" id="traum_captcha_setting_install" name="traum_captcha_setting_install" value="1" ' . checked(1, get_option('traum_captcha_database_install'), false) . '/>'; 
     
    // Here, we'll take the first argument of the array and add it to a label next to the checkbox
    $html .= '<label for="traum_captcha_database_install"> '  . $args[0] . '</label>'; 
     
    echo $html;
     
} // end sandbox_toggle_header_callback


//Setting end
