<?php
    namespace Yy\Gd;

    class image
    {

        public function __construct()
        {

        }

        public function createEwm($width , $height , $type=0)
        {
            $img = imagecreatetruecolor($width , $height);
            imagefill($img, 0, 0, imagecolorallocate($img, mt_rand(130,255), mt_rand(130,255), mt_rand(130,255)));

            for($i=0;$i<200;$i++)
            {
                imagesetpixel($img , mt_rand(0,100) ,mt_rand(0,40) ,imagecolorallocate($img,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120)));
            }

            for($j =0;$j<3;$j++)
            {
                imageline(
                    $img,
                    mt_rand(0,100),mt_rand(0,40),
                    mt_rand(0,100),mt_rand(0,40),
                    imagecolorallocate($img,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120)));
            }
            //写字
            $str ='23456789qwertyuipasdfghjkzxcvbnmQWERTYUIPASDFGHJKZXCVBNM';
            $str = str_shuffle($str);
            $str = substr($str,0,4);
            $w = $width/4;
            for($i=0;$i<4;$i++){
                $x=$i*$w+5;
                $y = mt_rand(20,40);
                imagettftext($img,20,mt_rand(-40,40),$x,$y,
                    imagecolorallocate($img,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120)),
                    '',
                    $str{$i}
                );
            }

            //5.保存或输出
            header('content-type:image/png');
            imagepng($img);
            //6.销毁资源
            imagedestroy($img);
        }

        public function test()
        {
            echo 123;exit;
        }

    }

 ?>
