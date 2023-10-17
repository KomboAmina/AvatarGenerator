<?php

defined('DS') || define('DS',DIRECTORY_SEPARATOR);

include_once "src".DS."StringGenerator.php";

include_once "src".DS."AvatarGenerator.php";

if(isset($_GET['show'])){

    //show generated image

}
else{

    //show form

    $avv=new AvatarGenerator();

    $name="S huprella Prella Pais";

    $img=$avv->generateAvatar('',500,500);

    ob_start();
    imagepng($img);
    $png=ob_get_clean();
    $uri = "data:image/png;base64," . base64_encode($png);

    echo "<img src='".$uri."' />";

    /*
    $img = $avv->createDefaultAvatar(mt_rand(10,99)."");

    ob_start();
    imagepng($img);
    $png=ob_get_clean();
    $uri = "data:image/png;base64," . base64_encode($png);

    echo "<img src='".$uri."' />";*/


    /*
    header("Content-Type: image/png");

    imagepng($img);
    imagedestroy($img);*/

}

