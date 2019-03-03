<?php
/*
    Plugin Name: Traum验证码
    Plugin URI: https://www.jysafe.cn/3571.air
    Description: 化学验证码，历史验证码，矩阵验证码
    Author: Traum
    Version: 1.0 
    Author URI: https://www.jysafe.cn
    */
?>
<?php
/*if (!function_exists('Traum_Captcha_activation')) {
    function Traum_Captcha_activation() {
        global $wpdb;
        function insert($file,$database,$name,$root,$pwd)
        {
            //将表导入数据库
            header("Content-type: text/html; charset=utf-8");
            $_sql = file_get_contents($file);
            //写自己的.sql文件
            $_arr = explode(';
', $_sql);
            $_mysqli = new mysqli($name,$root,$pwd,$database);
            //第一个参数为域名，第二个为用户名，第三个为密码，第四个为数据库名字
            if (mysqli_connect_errno()) {
                exit('连接数据库出错');
            } else {
                //执行sql语句
                $_mysqli->query('set names utf8;');
                //设置编码方式
                //echo $_arr['0'];
                foreach ($_arr as $_value) {
                    //$_value = $_value.'';
                    //echo $_value.'<br>--------------------------------';
                    $_mysqli->query($_value.';');
                }
                //echo "插入成功";
                //echo '<div class="notice notice-success"><p>这是成功操作的提示</p></div>';
            }
            $_mysqli->close();
            $_mysqli = null;
        }
        insert("/home/jysafecn/public_html/wp-content/plugins/Traum-CAPTCHA/db/Captcha_event.sql",DB_NAME,DB_HOST,DB_USER,DB_PASSWORD);
        insert("/home/jysafecn/public_html/wp-content/plugins/Traum-CAPTCHA/db/Captcha_matrix.sql",DB_NAME,DB_HOST,DB_USER,DB_PASSWORD);
        insert("/home/jysafecn/public_html/wp-content/plugins/Traum-CAPTCHA/db/Captcha_vcode.sql",DB_NAME,DB_HOST,DB_USER,DB_PASSWORD);
    }
}
add_action('activated_plugin', 'Traum_Captcha_activation');*/

// WordPress 注册表单添加验证图片
function add_security_question() {
    ?>
    <p>
        <label>验证码(点击图像更换)</label><br><br>
        <input type="text" name="ctype" id="ts" style="display: none" value="vcode">
        <div id="fzs">
            <div align="center">
                <img style="background-color: white;max-width:100%" id="v" onclick="change()" src="/?Captcha_type=Chemical">
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
    <script src="//upcdn.b0.upaiyun.com/libs/jquery/jquery-2.0.3.min.js"></script>
    <script>
        function change() {
            r = Math.random();
            if (r > 0.66) {
                $("#fzs").hide();
                $("#jz").hide();
                $("#ev").show();
                $("#ve").attr('src', '/?Captcha_type=History&t=' + Math.random());
                ts = "vcode1";
            } else if (r < 0.66 && r > 0.33) {
                $("#ev").hide();
                $("#jz").hide();
                $("#fzs").show();
                $("#v").attr('src', '/?Captcha_type=Chemical&t=' + Math.random());
                ts = "vcode2";
            } else {
                $("#jz").show();
                $("#fzs").hide();
                $("#ev").hide();
                $("#jzi").attr('src', '/?Captcha_type=Matrix&t=' + Math.random());
                ts = "vcode3";
            }
            $("#ts").val(ts);
        }
    </script>
    <br />
    <?php
}
add_action('register_form', 'add_security_question');

//检验输入的验证码是否正确
function Traum_Captcha_add_security_question_validate($sanitized_user_login, $user_email, $errors) {
    if ($_POST['vcode1'] == $_SESSION['Checknum'] || $_POST['vcode2'] == $_SESSION['Checknum'] || $_POST['vcode3'] == $_SESSION['Checknum']) {
        //wp_die('正确');
        //return $errors->add('prooffail', '<strong>正确</strong>答案：');
    } else {
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
    $captcha_type = $_GET['Captcha_type'];
    $traum_captcha -> $captcha_type();
    echo $captcha_type;
    exit;
}

//初始化
function traum_captcha_init() {
    if (isset($_GET['Captcha_type'])) {
        traum_captcha();
    }
}
add_action('init','traum_captcha_init');

//设置
function Traum_captcha_menu() {
    //$icon_url = plugins_url('/img/favicon.ico', __FILE__);
    $icon_url = null;
    add_menu_page('Traum验证码设置页面', 'Traum Captcha', 'administrator', 'Traum_captcha', 'display_Traum_captcha_menu',$icon_url);
}
add_action('admin_menu','Traum_captcha_menu');

function display_Traum_captcha_menu() {
    require "option.php";

}