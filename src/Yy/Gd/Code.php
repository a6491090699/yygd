<?php
    namespace Yy\Gd;
    class Code{


        public function create()
        {
            $img = imagecreatetruecolor(100 , 40);
            imagefill($img, 0, 0, imagecolorallocate($img, mt_rand(130,255), mt_rand(130,255), mt_rand(130,255)));
            // 画干扰点
            for($i=0;$i<200;$i++)
            {
                imagesetpixel($img , mt_rand(0,100) ,mt_rand(0,40) ,imagecolorallocate($img,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120)));
            }
            // 画干扰线
            for($j =0;$j<3;$j++)
            {
                imageline(
                    $img,
                    mt_rand(0,100),mt_rand(0,40),
                    mt_rand(0,100),mt_rand(0,40),
                    imagecolorallocate($img,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120)));
            }
            // //写字
            $str = $this->typestring(0);
            // $str ='23456789qwertyuipasdfghjkzxcvbnmQWERTYUIPASDFGHJKZXCVBNM';
            $str = str_shuffle($str);
            $str = substr($str,0,4);
            session_start();
            $_SESSION['ewm'] = $str;
            $w = 100/4;
            for($i=0;$i<4;$i++){
                $x=$i*$w+5;
                $y = mt_rand(20,40);
                imagettftext($img,20,mt_rand(-40,40),$x,$y,
                    imagecolorallocate($img,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120)),
                    __DIR__.'/fonts/4.ttf',
                    $str{$i}
                );
            }

            //5.保存或输出
            header('content-type:image/png');
            imagepng($img);
            //6.销毁资源
            imagedestroy($img);

        }

        private function unicode_shuffle($str , $chars , $format="UTF-8" )
        {
            for($i=0; $i<$chars; $i++)
                $rands[$i] = rand(0, mb_strlen($string, $format));

                $s = NULL;

            foreach($rands as $r)
                $s.= mb_substr($string, $r, 1, $format);

            return $s;
        }

        public function typestring($type)
        {
            switch($type)
            {
                //
                case 0:
                    return '123456789qwertyuipasdfghjkzxcvbnmQWERTYUIPASDFGHJKZXCVBNM';
                break;
                //文字
                case 1:
                    return '收到货福收到小丑女从小就内存泄漏你们热不是到付考虑了下次能持续的李开复就算开发';
                break;

            }
        }

        public function createHtml($route)
        {
            $url = 'code.php';
            $html =<<<EOT
            <form class="" action="$url" method="post">
                验证码:
                <img src="code.php?a=ewm" onclick="this.src='code.php?a=ewm'"/>
                <input type="text" name="yzm" value=""><br>

                <input type="submit" name="" value="提交">
            </form>
EOT;
        echo $html;exit;
        }

        public function check($code)
        {
            // 判断有没有 开启session
            if(!isset($_SESSION))
            {
                session_start();
            }
            $name = $this->inputName();
            if(!empty($_POST[$name]))
            {
                $front_yzm = $_POST[$name];
                if(strtolower($code)== strtolower($front_yzm)) return true;
            }
            return false;
        }

        private function inputName()
        {
            return 'yzm';
        }
    }

 ?>
