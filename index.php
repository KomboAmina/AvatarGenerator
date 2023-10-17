<?php

defined('DS') || define('DS',DIRECTORY_SEPARATOR);

include_once "src".DS."StringGenerator.php";

include_once "src".DS."AvatarGenerator.php";

$avv=new AvatarGenerator();

$name="";

$width=mt_rand(100,750);

$height=$width;

$img=$avv->generateAvatar($name,$width,$height);

ob_start();
imagepng($img);
$png=ob_get_clean();
$uri = "data:image/png;base64," . base64_encode($png);

echo "<img src='".$uri."' />";
