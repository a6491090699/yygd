<?php
    namespace Yy\Gd;
// hehe
    class Image
    {
        public $width;
        public $height;
        protected $img;
        public $mime;
        public $ext;
        public $file_path;

        public function __construct($file_path)
        {
            $this->file_path = $file_path;
            $this->open($file_path);
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
            $this->ext = $ext;
            $create = 'imagecreatefrom'.$ext;
            $img = $create($file);

            $this->img = $img;
            return $this;
            // return $r;

        }

        public function fontmark($fontsize=20,$jiaodu=0,$x=0 , $y=0,$text='testing')
        {
            $img = $this->img;
            $back_color = imagecolorallocate($img, 255,255,255);
            $color = imagecolorallocate($img, 255,255,0);
            imagettftext($img, $fontsize, $jiaodu, $x, $y, $color, __DIR__.'/fonts/font.ttf', $text);

            header('content-type:image/jpeg');
            imagejpeg($img);

        }

        public function imagemark($water , $pos=1 , $touming=100)
        {
            $img = $this->img;
            $water_info = getimagesize($water);
            $water_mime = $water_info['mime'];
            $c = explode('/',$water_mime);
            $create = 'imagecreatefrom'.array_pop($c);
            $water_img = $create($water);
            // 将图片拷贝在一起就可以
            switch($pos){
                case 1:
                    $x = 0;
                    $y = 0;
                    break;
                case 2:
                    $x = $this->width/3;
                    $y = 0;
                    break;
                case 3:
                    $x = $this->width/3*2;
                    $y = 0;
                    break;

                case 4:
                    $x =0;
                    $y = $this->height/3;
                    break;
                case 5:
                    $x = $this->width/3;
                    $y = $this->height/3;
                    break;
                case 6:
                    $x = $this->width/3*2;
                    $y = $this->height/3;
                    break;
                case 7:
                    $x = 0;
                    $y = $this->height/3*2;
                    break;
                case 8:
                    $x = $this->width/3;
                    $y = $this->height/3*2;
                    break;
                case 9:
                    $x = $this->width/3*2;
                    $y = $this->height/3*2;
                    break;

                default:
                    $x =mt_rand(0,$this->width);
                    $y =mt_rand(0,$this->height);
            }
            imagecopymergegray($img,$water_img , $x,$y,0,0,$water_info[0] ,$water_info[1] , $touming);
            header('content-type:'.$this->mime);
            $s = 'image'.$this->ext;
            $s($img);
            imagedestroy($water_img);

        }

        public function zoom($width =200,$height=200,$path='./')
        {
            if(empty($this->img)) die(404);

            $img = $this->img;

            if(($width/$this->width ) < ($height/$this->height))
            {
                $dw = $width ;
                $dh = $this->height*($width/$this->width);
                $pre = $width.'_';
            }else{
                $dh = $height ;
                $dw = $this->width*($height/$this->height);
                $pre = $height.'_';
            }

            $simg = imagecreatetruecolor($dw, $dh);
            // echo $this->width.$this->height;exit;
            imagecopyresampled($simg , $img ,0,0,0,0,$dw , $dh ,$this->width , $this->height);

            $arr1 = explode('/',$this->file_path);
            $name = array_pop($arr1);

            $s = 'image'.$this->ext;
            $s($simg,$path.$pre.$name);
            return true;
            imagedestroy($simg);
            // return


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
