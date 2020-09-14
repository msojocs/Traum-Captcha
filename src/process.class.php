<?php
use GDText\Box;
use GDText\Color;
class Traum_captcha {
    public function Chemical() {
        global $wpdb;
        $id = rand(1,10186);
        $results = $wpdb -> get_row("SELECT * FROM `captcha_vcode` WHERE `id` =$id", ARRAY_A);
        $url = "https://www.chemicalbook.com/CAS/GIF/".$results["cas"].".gif";
        ob_end_clean();
        Header("HTTP/1.1 303 See Other");
        Header("Location:$url");
        $_SESSION['Checknum'] = $results["anwser"];
    }
    public function History() {
        global $wpdb;
        $id = rand(1,30925);
        $results1 = $wpdb -> get_row("SELECT * FROM `captcha_event` WHERE `id` =$id", ARRAY_A);
        $type = $results1['y'];
        $year = $results1['d'];
        $riqi = $results1['i'];
        $info = $results1['p'];
        if ($type != "0") {
            $id = rand(1,30000);
            $results1 = $wpdb -> get_row("SELECT * FROM `captcha_event` WHERE `id` =$id", ARRAY_A);
            $type = $results1['y'];
            $year = $results1['d'];
            $riqi = $results1['i'];
            $info = $results1['p'];
        }
        switch ($type) {
            case '0':
                $t = "大事件发生";
                break;
            case '1':
                $t = "人物出生";
                break;
            case '2':
                $t = "人物逝世";
                break;

            default:

                break;
        }
        $year = str_replace("前", "-", $year);
        $year = str_replace("年", "", $year);
        $month = explode("月",$riqi);
        $m = sprintf("%02d", $month[0]);
        $d = sprintf("%02d", str_replace("日","",$month[1]));
        $ttt = $t.":\n".$info;
        $width = (strlen($info) >= 189) ? 500 : 250 ;
        $im = imagecreatetruecolor(500, $width);
        $backgroundColor = imagecolorallocate($im, 255, 255, 255);
        imagefill($im, 0, 0, $backgroundColor);
        $box = new Box($im);
        $box->setFontFace(plugin_dir_path(__FILE__).'../assets/fonts/fz.otf');
        //受freetype版本限制，字体文件不能过大
        $box->setFontColor(new Color(0, 0, 0));
        $box->setTextShadow(new Color(0, 0, 0, 50), 0, 0);
        $box->setFontSize(28);
        $box->setLineHeight(1.5);
        $box->setBox(20, 20, 460, 460);
        $box->setTextAlign('left', 'top');
        $box->draw($ttt
        );
        $_SESSION['Checknum'] = $year.$m.$d;
        header("Content-type: image/png;");
        header("cache-control:no-cache,must-revalidate");
        imagepng($im);
        imagedestroy($im);
    }

    public function Matrix() {
        global $wpdb;
        $image = imagecreatefrompng(plugin_dir_path(__FILE__)."../assets/img/bg.png");
        $black = imagecolorallocate($image, 0, 0, 0);
        $id = rand(1,22523);
        $size = 22;
        $font = plugin_dir_path(__FILE__).'../assets/fonts/fz.otf';
        $text = "1";
        $results1 = $wpdb -> get_row("SELECT * FROM `captcha_matrix` WHERE `id` =$id", ARRAY_A);
        $m1 = $results1['m1'];
        $m2 = $results1['m2'];
        $anwser = $results1['anwser'];
        $m1_ex = explode(";",$m1);
        $m2_ex = explode(";",$m2);
        $row = "";
        foreach ($m1_ex as $key => $value) {
            foreach (explode(" ",$value) as $key1 => $value1) {
                $row = $row.$value1."   ";
            }
            imagettftext($image, $size, 0, 45, 130+$key*40, $black, $font, $row);
            $row = "";
        }
        foreach ($m2_ex as $key => $value) {
            foreach (explode(" ",$value) as $key1 => $value1) {
                $row = $row.$value1."   ";
            }
            imagettftext($image, $size, 0, 307, 130+$key*40, $black, $font, $row);
            $row = "";
        }
        ob_end_clean();
        header("cache-control:no-cache,must-revalidate");
        $_SESSION['Checknum'] = $anwser;
        header('content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }


}