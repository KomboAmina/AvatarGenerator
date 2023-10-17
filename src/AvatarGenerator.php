<?php
/**
 * @author Amina Kombo <https://aminakombo.work>
 * references this tutorial: https://dev.to/thinkverse/creating-default-user-initial-avatars-in-php-7-1gf1
 */

class AvatarGenerator{

    public $randomizeBGColor=true;

    public $randomizeDefaultText=true;

    public $defaultInitials="Hi!";

    public $activeFont='./src/OdudoMono-Bold.ttf';

    private $minimumWidth=10;

    private $minimumHeight=10;

    private $maximumTextLength=3;

    private $defaultBGColor=[0,0,0];

    private $defaultTextColor=[255,255,255];

    private $defaultTextSize=140;

    public function generateAvatarFromInitials($fullname,$width,$height){

        $initials=$this->getInitials($fullname);

    }

    public function generateAvatarFromFirstLettersInName($fullname,$width,$height){

        $letters=$this->getFirstLettersInName($fullname);

    }

    public function generateAvatar($text="",$width=0,$height=0):object{

        $text=(empty($text)) ? $this->getDefaultText():$text;

        $width=($width<$this->minimumWidth) ? $this->minimumWidth:$width;

        $height=($height<$this->minimumHeight) ? $this->minimumHeight:$height;

        //bgcolor
        $bgColor=$this->getActiveBGColor();

        //textcolor
        $textColor=$this->getActiveTextColor($bgColor);

        //font size
        $textSize=$this->defaultTextSize;

        $image=@imagecreate($width,$height) or die("Cannot initialize GD image stream");

        imagecolorallocate($image,$bgColor[0],$bgColor[1],$bgColor[2]);

        $fontColor=imagecolorallocate($image,$textColor[0],$textColor[1],$textColor[2]);

        $textBoundingBox=imagettfbbox($textSize,0,$this->activeFont,$text);

        $y = abs(ceil(($height - $textBoundingBox[5]) / 2));
        $x = abs(ceil(($width - $textBoundingBox[2]) / 2));

        imagettftext($image, $textSize, 0, $x, $y, $fontColor, $this->activeFont, $text);

        return $image;

    }

    private function getInitials($fullname):string{

        $initials="";

        $names=explode(" ",$fullname);

        if(empty($names)){

            $initials=$this->getDefaultText();

        }

        else{

            for($k=0;$k<$this->maximumTextLength;$k++){

                if(isset($names[$k])){

                    $initials.=$names[$k][0];

                }

            }

        }

        return $initials;

    }

    private function getFirstLettersInName($fullname){

        $letters="";

        //only alphanumeric characters and no spaces allowed.
        $fullname=preg_replace("/[^A-Za-z0-9]/", '', $fullname);

        if(empty($fullname)){

            $letters=$this->getDefaultText();

        }

        else{

            for($k=0;$k<$this->maximumTextLength;$k++){

                if(isset($fullname[$k])){

                    if(strlen($letters)<$this->maximumTextLength){

                        $letters.=$fullname[$k];

                    }
                    else{

                        break;

                    }

                }

            }

        }

        return $letters;

    }

    private function getDefaultText():string{

        return ($this->randomizeDefaultText) ?
        \StringGenerator::generateCode($this->maximumTextLength):$this->defaultInitials;

    }

    private function getActiveBGColor():array{

        return ($this->randomizeBGColor) ? [mt_rand(0,255),mt_rand(0,255),mt_rand(0,255)]:$this->defaultBGColor;

    }

    private function getActiveTextColor($bgColor=array()):array{

        $rgb=implode("",$bgColor);

        $hsl=$this->RGBTOHSL($rgb);

        return ($hsl->lightness<200) ? [0,0,0]:[255,255,255];

    }

    /**
     * unchanged from accepted answer on this page:
     * https://stackoverflow.com/questions/12228644/how-to-detect-light-colors-with-php
     */
    private function RGBToHSL($RGB) {
        $r = 0xFF & ($RGB >> 0x10);
        $g = 0xFF & ($RGB >> 0x8);
        $b = 0xFF & $RGB;
    
        $r = ((float)$r) / 255.0;
        $g = ((float)$g) / 255.0;
        $b = ((float)$b) / 255.0;
    
        $maxC = max($r, $g, $b);
        $minC = min($r, $g, $b);
    
        $l = ($maxC + $minC) / 2.0;
    
        if($maxC == $minC)
        {
          $s = 0;
          $h = 0;
        }
        else
        {
          if($l < .5)
          {
            $s = ($maxC - $minC) / ($maxC + $minC);
          }
          else
          {
            $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
          }
          if($r == $maxC)
            $h = ($g - $b) / ($maxC - $minC);
          if($g == $maxC)
            $h = 2.0 + ($b - $r) / ($maxC - $minC);
          if($b == $maxC)
            $h = 4.0 + ($r - $g) / ($maxC - $minC);
    
          $h = $h / 6.0; 
        }
    
        $h = (int)round(255.0 * $h);
        $s = (int)round(255.0 * $s);
        $l = (int)round(255.0 * $l);
    
        return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
    }

    /**unchanged from this tutorial:
     * https://dev.to/thinkverse/creating-default-user-initial-avatars-in-php-7-1gf1 */
    function createDefaultAvatar(
        string $text = 'DEV',
        array $bgColor = [0, 0, 0],
        array $textColor = [255, 255, 255],
        int $fontSize = 140,
        int $width = 600,
        int $height = 600,
        string $font = './src/OdudoMono-Bold.ttf'
    ) {
        $image = @imagecreate($width, $height)
            or die("Cannot Initialize new GD image stream");

        imagecolorallocate($image, $bgColor[0], $bgColor[1], $bgColor[2]);

        $fontColor = imagecolorallocate($image, $textColor[0], $textColor[1], $textColor[2]);

        $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);

        $y = abs(ceil(($height - $textBoundingBox[5]) / 2));
        $x = abs(ceil(($width - $textBoundingBox[2]) / 2));

        imagettftext($image, $fontSize, 0, $x, $y, $fontColor, $font, $text);

        return $image;
    }

}
