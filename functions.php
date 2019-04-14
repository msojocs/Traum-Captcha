<?php
/*
    Plugin Name: Traum Captcha
    Plugin URI: https://www.jysafe.cn/3571.air
    Description: Chemical Captcha，Historical Captcha，Matrix Captcha
    Author: Traum
    Version: 1.0.2
    Author URI: https://www.jysafe.cn
    */
?>
<?php
require plugin_dir_path( __FILE__ ) .'options.php';

// WordPress 注册表单添加验证图片
function traum_captcha_add_security_question() {
    ?>
    <script type="text/javascript">
jQuery(function(){ 
	//alert(jQuery.fn.jquery);		
})
</script>
    <p>
        <label>验证码(点击图像更换)</label><br><br>
        <input type="text" name="ctype" id="ts" style="display: none" value="vcode">
        <div id="fzs">
            <div align="center">
                <img style="background-color: white;max-width:100%" id="v" onclick="change()" src="/?traum_captcha_type=Chemical">
            </div>
            <div class="form-group label-floating is-empty">
                <label class="control-label" for="focusedInput1">请输入上图物质的分子式</label>
                <input class="form-control" name="vcode2" id="vcode" type="text">
            </div>
        </div>
        <div id="ev" style="display:none;">
            <div align="center">
                <img style="background-color: white;max-width:100%" id="ve" onclick="change()">
            </div>
            <div class="form-group label-floating is-empty">
                <label class="control-label" for="focusedInput1">请输入上图事件发生日期</label>
                <input class="form-control" name="vcode1" id="vcode1" type="text">
                <label>格式例如：19890604，公元前请加“-”表示</label>
            </div>
        </div>
        <div id="jz" style="display:none;">
            <div align="center">
                <img style="background-color: white;max-width:100%" id="jzi" onclick="change()">
            </div>
            <div class="form-group label-floating is-empty">
                <label class="control-label" for="focusedInput1">请输入上图结果的方阵的行列式的值</label>
                <input class="form-control" name="vcode3" id="vcode3" type="text">
                <label>请使用整数表示</label>
            </div>
        </div>
    </p>
    <br />
    <script>
        var jq=jQuery.noConflict();
        function change() {
            r = Math.random();
            if (r > 0.66) {
                jq("#fzs").hide();
                jq("#jz").hide();
                jq("#ev").show();
                jq("#ve").attr('src', '/?traum_captcha_type=History&t=' + Math.random());
                ts = "vcode1";
            } else if (r < 0.66 && r > 0.33) {
                jq("#ev").hide();
                jq("#jz").hide();
                jq("#fzs").show();
                jq("#v").attr('src', '/?traum_captcha_type=Chemical&t=' + Math.random());
                ts = "vcode2";
            } else {
                jq("#jz").show();
                jq("#fzs").hide();
                jq("#ev").hide();
                jq("#jzi").attr('src', '/?traum_captcha_type=Matrix&t=' + Math.random());
                ts = "vcode3";
            }
            jq("#ts").val(ts);
        }
    </script>
    <br />
    <?php

}
add_action('register_form', 'traum_captcha_add_security_question');

//检验输入的验证码是否正确
function Traum_Captcha_add_security_question_validate($sanitized_user_login, $user_email, $errors) {

    /*
    eregi('[0-9]', $str) //数字
eregi('[a-zA-Z]', $str)//英文
*/

    if (!empty($_POST['vcode1'])) {
        $vcode = $_POST['vcode1'];

    } else if (!empty($_POST['vcode2'])) {
        $vcode = $_POST['vcode2'];

    } else if (!empty($_POST['vcode3'])) {
        $vcode = $_POST['vcode3'];

    }

    $regex = '/^[0-9a-zA-Z]+$/i';
    if (!preg_match($regex, $vcode)) {
        wp_die('非法字符');
    }

    if ($_POST['vcode1'] != $_SESSION['Checknum'] && $_POST['vcode2'] != $_SESSION['Checknum'] && $_POST['vcode3'] != $_SESSION['Checknum']) {
        return $errors->add('prooffail', '<strong>错误</strong>: 您的回答不正确。');

    }
}
add_action('register_post', 'Traum_Captcha_add_security_question_validate', 10, 3);

//获取验证码
function traum_captcha() {
    session_start();
    include_once('src/Box.php');
    include_once('src/Color.php');
    include_once('process.class.php');
    $traum_captcha = new Traum_captcha();
    $traum_captcha_type = $_GET['traum_captcha_type'];
    $traum_captcha -> $traum_captcha_type();
    //echo $traum_captcha_type;
    exit;
}

//初始化
function traum_captcha_init() {
    if (isset($_GET['traum_captcha_type'])) {
        traum_captcha();
    }
}
add_action('init','traum_captcha_init');

// 多语言
function traum_captcha_plugin_languages_init(){
load_plugin_textdomain( 'Traum-Captcha', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'traum_captcha_plugin_languages_init');


