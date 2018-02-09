<?php
    namespace Yy\Gd;
// hehe
    class Image
    {
        public $width;
        public $height;
        protected $img;
        public $mime;

        public function __construct()
        {
            function p($data)
            {
                echo '<pre>';
                print_r($data);
                echo '</pre>';
            }
        }


        public function open($file)
        {
            // p(getimagesize($file));exit;
            $info = getimagesize($file);

            $this->width = $width = $info[0];
            $this->height = $height = $info[1];
            $this->mime = $mime = $info['mime'];

            $arr = explode('/' , $mime);
            $ext = $arr[1];
            $create = 'imagecreatefrom'.$ext;
            $img = $create($file);

            $this->img = $img;
            return $this;
            // return $r;

        }

        //画像素点
        public function addPix()
        {
            for($i =0 ; $i<200 ; $i++)
            {
                imagesetpixel($this->img, mt_rand(0 , $this->width), mt_rand(0,$this->height), imagecolorallocate($img, mt_rand(0,120), mt_rand(0,120), mt_rand(0,120)));
            }
            return $this;
        }
        //画干扰线
        public function addLine()
        {
            for ($i=0; $i < 100; $i++) {
                imagesetpixel($this->img, mt_rand( 0 ,$this->width) ,  mt_rand( 0 ,$this->height), imagecolorallocate($img , mt_rand(0,120),mt_rand(0,120),mt_rand(0,120)));
            }
            return $this;
        }
        // 生成雁阵吗


        // 加水印
        public function water()
        {

        }

         // 等比例缩放
         public function zoom()
         {

         }

         //  裁剪

         public function thumb()
         {

         }

         // 保存图片
         public function save()
         {
             $arr = explode('/',$this->mime);
             $ext = array_pop($arr);
             $save = 'image'.$ext;
             header('content-type:'.$this->mime);
             $save($this->img);

         }


         // 销毁资源
         public function __destruct()
         {
             // $this->save();
             imagedestroy($this->img);

         }

        public function createEwm($type=0)
        {
            $img = imagecreatetruecolor(100 , 40);
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
            // //写字
            $str = $this->typestring($type);
            // $str ='23456789qwertyuipasdfghjkzxcvbnmQWERTYUIPASDFGHJKZXCVBNM';
            function unicode_shuffle($string, $chars, $format = 'UTF-8')
            {
                for($i=0; $i<$chars; $i++)
                    $rands[$i] = rand(0, mb_strlen($string, $format));

                    $s = NULL;

                foreach($rands as $r)
                    $s.= mb_substr($string, $r, 1, $format);

                return $s;
            }


            $str = unicode_shuffle($str, 100);
            $str = substr($str,0,4*3);
            echo $str;exit;

            $w = 100/4;
            for($i=0;$i<4;$i++){
                $x=$i*$w+5;
                $y = mt_rand(20,40);
                imagettftext($img,20,mt_rand(-40,40),$x,$y,
                    imagecolorallocate($img,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120)),
                    __DIR__.'/fonts/font.ttf',
                    $str{$i}
                );
            }

            //5.保存或输出
            header('content-type:image/png');
            imagepng($img);
            //6.销毁资源
            imagedestroy($img);
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

        public function test()
        {
            echo 123;exit;
        }

    }

 ?>
