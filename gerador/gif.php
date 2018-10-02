<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type");

$text = isset($_GET['text']) ? $_GET['text'] : strtolower("Richard");
$text = str_replace(" ", "-", $text);

if(!file_exists("gerados/$text.gif")){
	include('GIFEncoder.class.php');

	$newtext = $text . "-";

	for($i=0;$i<strlen($newtext);$i++){
		for($j=0;$j<=4;$j++){

			// Open the first source image and add the text.
			$image = imagecreatefrompng("sg_gifs/$newtext[$i]_$j.png");
			$text_color = imagecolorallocate($image, 500, 500, 500);

			// Generate GIF from the $image
			// We want to put the binary GIF data into an array to be used later,
			//  so we use the output buffer.
			ob_start();
			imagegif($image);
			$frames[]=ob_get_contents();
			$framed[]=15; // Delay in the animation.
			ob_end_clean();
		}
	}


	// Generate the animated gif and output to screen.
	$gif = new GIFEncoder($frames,$framed,0,2,0,0,0,'bin');

	file_put_contents("gerados/$text.gif", $gif->GetAnimation());

	//echo $gif->GetAnimation();

}

echo json_encode(array('gifUrl' => "http://richardds.com.br/projetos/e9midia/StrangersThings/v2/gerador/gerados/$text.gif"));


?>
