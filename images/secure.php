<?
if(!function_exists('gd_info')) { exit(); }

session_start();


class antiscripting
{
        var $width  = 67;                                 // image height
        var $height = 20;                                 // image width

        var $transparent = 1;                                 // transparency
        var $interlace = false;

        var $msg = 'NO BOTS!';                                 // text to display
        var $font = 'verdana.ttf';         // full path to your font

        var $size = 13;                                 // font size
        var $rotation = 0;                                // font rotation.

        var $pad_x = 5;                                 // padding x
        var $pad_y = 15;                                 // padding y

        var $fg_r = 60;                                         // text color RGB - red
        var $fg_g = 40;                                         // text color RGB - green
        var $fg_b = 50;                                         // text color RGB - blue


        var $bg_r = 210;                                 // background color RGB - red
        var $bg_g = 210;                                 // background color RGB - green
        var $bg_b = 210;                                // background color RGB - blue

        function drawImage()
        {
                $image   = '';
                $this->msg = chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122)).chr(rand(97,122));
                $_SESSION['code'] = $this->msg;
                $this->rotation = rand(0,18)-9;
                $image = ImageCreate($this->width,$this->height);

                // Allocate background color
                $bg = ImageColorAllocate($image, $this->bg_r, $this->bg_g, $this->bg_b);

                // Allocate text color
                $fg = ImageColorAllocate($image, $this->fg_r, $this->fg_g, $this->fg_b);

                if ($this->transparent)
                    ImageColorTransparent($image, $bg);

                ImageInterlace($image, $this->interlace);

                ImageTTFText($image, $this->size, $this->rotation, $this->pad_x, $this->pad_y, $fg, $this->font, $this->msg);

                // Image distortion

                // Alocate distortion color
                $dc = ImageColorAllocate($image, rand(0,255), rand(0,255), rand(0,255));

                // Draw eclipse
                ImageArc($image, rand(0, $this->width ), rand(0, $this->height ), rand($this->width / 2, $this->width) ,rand($this->height / 2, $this->height), 0,360, $dc);

                // Alocate distortion color
                $dc = ImageColorAllocate($image, rand(0,255), rand(0,255), rand(0,255));

                // Draw rectangle
                //ImageRectangle($image, rand(0, $this->width/2 ), rand(0, $this->height/2 ), rand($this->width / 2, $this->width) ,rand($this->height / 2, $this->height), $dc);

                // Draw dots at random position
                $dots = $this->width * $this->height / 10;
                for($i=0;$i<$dots;$i++)
                {
                        // Alocate dot color
                        $dc = ImageColorAllocate($image, rand(0,255), rand(0,255), rand(0,255));

                        // Draw dot
                        ImageSetPixel($image, rand(0,$this->width), rand(0,$this->height), $dc);
                }

                // Create image
                ImagePNG($image);
        }
}

$image = new antiscripting;

header('Content-type:image/png');
header('Expires: '.$expires_gmt);
header('last-modified: '.$last_modified_gmt);

$image->drawImage();




?>