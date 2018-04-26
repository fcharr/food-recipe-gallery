<?
header("Content-type: image/png");

$food_image = imageCreateTrueColor(320, 200);
$background = imageColorAllocate($food_image, 255, 255, 0);
imagefill($food_image, 0, 0, $background);

imagePNG($food_image);

imageDestroy($food_image);
?>