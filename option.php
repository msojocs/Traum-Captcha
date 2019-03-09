<?php
defined('ABSPATH') or exit;

if(!is_user_logged_in())//检测是否登录
 {
 return false;
 }
 
if ($_POST["install"] == 'true') {
    Traum_Captcha_insertsql();
}else if($_POST["install"] == 'no'){
    global $wpdb;
    $wpdb->query( "DROP TABLE captcha_event" );
    $wpdb->query( "DROP TABLE captcha_matrix" );
    $wpdb->query( "DROP TABLE captcha_vcode" );
    echo '<div class="notice notice-success"><p>删除成功</p></div>';
    
}

?>
<h2>这是Traum Captcha数据库操作页面</h2>
<p>本页面只操作与本插件相关数据</p>
<p>插件开发参考于<a href="https://hfo4.github.io/2018/08/30/captcha-for-cloudreve/">给Cloudreve添加化学式/矩阵/大事件验证码</a></p>
<div>
    <form method="post">
        <input type="hidden" name="install" value="true" />
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="安装"></p>
    </form>
    <form method="post">
        <input type="hidden" name="install" value="no" />
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="删除"></p>
    </form>
</div>
<?php
function Traum_Captcha_insertsql() {
    if(current_user_can('level_10')){
        global $wpdb;
        function insert($file,$database,$name,$root,$pwd)
        {
            //将表导入数据库
            header("Content-type: text/html; charset=utf-8");
            $_sql = file_get_contents($file);
            //写自己的.sql文件
            $_arr = explode(';
', $_sql);//此处不可修改，否则数据库可能无法成功导入
            $_mysqli = new mysqli($name,$root,$pwd,$database);
            //第一个参数为域名，第二个为用户名，第三个为密码，第四个为数据库名字
            if (mysqli_connect_errno()) {
                exit('连接数据库出错');
            } else {
                //执行sql语句
                $_mysqli->query('set names utf8;');
                //设置编码方式
                foreach ($_arr as $_value) {
                    $_mysqli->query($_value.';');
                }
                //echo "插入成功";
                echo '<div class="notice notice-success"><p>安装成功</p></div>';
            }
            $_mysqli->close();
            $_mysqli = null;
        }
        insert(plugin_dir_path(__FILE__)."db/Captcha.sql",DB_NAME,DB_HOST,DB_USER,DB_PASSWORD);
    }else{
        echo '权限不足';
    }
    
}