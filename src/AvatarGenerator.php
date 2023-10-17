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

    public function generateAvatar($text,$width,$height):object{

        $text=(empty($text)) ? $this->getDefaultText():$text;

        $width=($width<$this->minimumWidth) ? $this->minimumWidth:$width;

        $height=($height<$this->minimumHeight) ? $this->minimumHeight:$height;

        //bgcolor
        $bgColor=$this->getActiveBGColor();

        //textcolor
        //$textColor=$this->defaultTextColor;
        $textColor=$this->getActiveTextColor($bgColor);

        //font size
        $textSize=$this->defaultTextSize;

        //font color
        $textColor=$this->defaultTextColor;

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

        return $this->defaultTextColor;

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
