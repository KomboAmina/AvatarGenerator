<?php
/**
 * @author Amina Kombo <https://aminakombo.work>
 * references this tutorial: https://dev.to/thinkverse/creating-default-user-initial-avatars-in-php-7-1gf1
 */

class AvatarGenerator{

    public $randomizeBGColor=false;

    public $randomizeDefaultInitials=true;

    public $defaultInitials="Hi!";

    public $activeFont='./src/OdudoMono-Bold.ttf';

    private $minimumWidth=10;

    private $minimumHeight=10;

    private $maximumInitials=3;

    public function __construct(){

        

    }

    public function generateAvatarFromName($fullname,$width,$height){

        $width=($width<$this->minimumWidth) ? $this->minimumWidth:$width;

        $height=($height<$this->minimumHeight) ? $this->minimumHeight:$height;

        $initials=$this->getInitials($fullname);

    }

    private function getInitials($fullname):string{

        $initials="";

        $names=explode(" ",$fullname);

        $totalNames=count($names);

        if(empty($names)){

            $initials=($this->randomizeDefaultInitials) ?
            \StringGenerator::generateRandomCode($this->maximumInitials):$this->defaultInitials;

        }

        else{

            for($k=0;$k<$this->maximumInitials;$k++){

                if(isset($names[$k])){

                    $initials.=$names[$k][0];

                }

            }

        }

        return $initials;

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
