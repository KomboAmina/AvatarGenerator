<?php

defined('DS') || define('DS',DIRECTORY_SEPARATOR);

include_once "src".DS."StringGenerator.php";

include_once "src".DS."AvatarGenerator.php";

$avv=new AvatarGenerator();

$name="Mina Kaj Tiel Plu";

$width=mt_rand(100,650);

$height=$width;

$img=$avv->generateAvatarFromFirstLettersInName($name,$width,$height);

ob_start();
imagepng($img);
$png=ob_get_clean();
$uri = "data:image/png;base64," . base64_encode($png);

echo "<img src='".$uri."' />";
