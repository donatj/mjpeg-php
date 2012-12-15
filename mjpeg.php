<?php
# Used to separate multipart
$boundary = "spiderman";

# We start with the standard headers. PHP allows us this much
header("Cache-Control: no-cache");
header("Cache-Control: private");
header("Pragma: no-cache");
header("Content-type: multipart/x-mixed-replace; boundary=$boundary");

# From here out, we no longer expect to be able to use the header() function
echo "--$boundary\n\n";

# Set this so PHP doesn't timeout during a long stream
set_time_limit(0);

# The loop, producing one jpeg frame per iteration

$rand = rand(1, 10000);

$i = rand(1, 10000);
while(true) {
	$i++;
	# Per-image header, note the two new-lines
	echo "Content-type: image/jpeg\n\n";

	$im = imagecreatetruecolor(400, 100);
	$fill_color = imagecolorallocate($im, (128 * sin($i / 30)) + 128, (128 * sin($i / 25)) + 128, (128 * sin($i / 20)) + 128);
	imagefill($im,1,1,$fill_color);
	$text_color = imagecolorallocate($im, 255, 255, 255);
	imagestring($im, 7, 5, 5,  $rand . ' || ' . date('c'), $text_color);
	ob_start();
	imagejpeg($im);
	imagedestroy($im);
	echo ob_get_clean(); 
	


	echo "--$boundary\n";
	usleep(10000);
}