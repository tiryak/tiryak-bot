<?php

require 'functions.php';

$files = glob('excel/images/*.{jpg}', GLOB_BRACE);

foreach($files as $file)
{
	$image = basename($file);

	$magicianObj = new imageLib('excel/images/' . $image);
	$magicianObj->resizeImage(800, 800);
	$magicianObj->saveImage('excel/images_resized/' . $image);
}
