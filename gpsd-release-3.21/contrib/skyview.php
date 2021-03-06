<?php

# Copyright 2006,2007 Chris Kuethe <chris.kuethe@gmail.com>
# Updated 2015 by Sanjeev Gupta <ghane0@gmail.com>
#
# This file is Copyright 2010 by the GPSD project
# SPDX-License-Identifier: BSD-2-clause

// This program originally read a logfile of filtered gpsd messages,
// type Y.  The gpsd protocol changed in 2.90, since when this became
// non-functional.
//
// The program has been updated (the first while loop) to read messages
// over tcp; of type SKY.  These are unpacked from JSON.  No attempt has
// been made to touch the actual calculation or plotting routines.
//
// Because it now reads a live stream, the program must be run with an
// option, "count", to specify the number of SKY messages it reads.  SKY
// messages are usually emitted every 5 secs, so a number close to 700
// will cover an hour's worth.
//
// Tested to work with php5.6 , although earlier versions may work.


$cellmode = 0;
if ($argc != 3){
	if (($argc != 4) || strcmp("cells", $argv[3])){
		die("usage: ${argv[0]} count imagefile.png [cells]\n");
	} else {
		$cellmode = 1;
	}
}

// How many samples to read of SKY messages.
$count = $argv[1] ;

$sz = 640;
$cellsize = 5; # degrees
$radius = 8; # pixels
$filled = 0;

$im = imageCreate($sz, $sz);
$C = colorsetup($im);
skyview($im, $sz, $C);
legend($im, $sz, $C);

$sky = array();

error_reporting(E_ALL);

// Get the port for the GPSD service.
$service_port = 2947 ;
// Get the IP address for the target host. 
$address = "127.0.0.1" ;
// Create a TCP/IP socket.
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
}

$result = socket_connect($socket, $address, $service_port);
if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
}

// Send a WATCH command.
$cmd = "?WATCH={\"enable\":true,\"json\":true};" ;

socket_write($socket, $cmd, strlen($in));

// Start the loop to start reading from gpsd.
$out = '';
$j = 0 ;
while (($out = socket_read($socket, 2048)) && ( $j < $count) ) {

	if (strpos($out, "SKY")) {
		$j = $j + 1;
		$PRN = json_decode($out,true);
// var_dump($PRN) ;
// object(stdClass)#12 (5)
//       ["PRN"]=>
//       int(137)
//       ["el"]=>
//       int(42)
//       ["az"]=>
//       int(91)
//       ["ss"]=>
//       int(32)
//       ["used"]=>
//       bool(false)

		$n =  count($PRN["satellites"]) ;
		for($i = 0; $i < $n; $i++) {
        		$sv = $PRN["satellites"][$i]["PRN"] ;
        		$el = $PRN["satellites"][$i]["el"] ;
        		$az = $PRN["satellites"][$i]["az"] ;
        		$snr = $PRN["satellites"][$i]["ss"] ;
        		$u = $PRN["satellites"][$i]["used"] ;

// Below this, Chris' original code, more or less. -- Sanjeev 20150326

			if ($cellmode){
				$az = $cellsize * (int)($az/$cellsize);
				$el = $cellsize * (int)($el/$cellsize);
			}
			if (isset($sky[$az][$el]['avg'])){
				$sky[$az][$el]['snr'] += $snr;
				$sky[$az][$el]['num']++;
			} else {
				$sky[$az][$el]['snr'] = $snr;
				$sky[$az][$el]['num'] = 1;
			}
			$sky[$az][$el]['avg'] = $sky[$az][$el]['snr'] / $sky[$az][$el]['num'];
		}
	}

}


foreach($sky as $az => $x){
	foreach ($sky[$az] as $el => $y){
		$e = array(-1, $el, $az, $sky[$az][$el]['avg'], -1);
		if ($cellmode)
			cellplot($im, $sz, $C, $cellsize, $e);
		else
			splot($im, $sz, $C, $radius, $filled, $e);
	}
}


skygrid($im, $sz, $C);	# redraw grid over satellites
imagePNG($im, $argv[2]);
imageDestroy($im);

exit(0);

###########################################################################
function colorsetup($im){
	$C['white']	= imageColorAllocate($im, 255, 255, 255);
	$C['ltgray']	= imageColorAllocate($im, 191, 191, 191);
	$C['mdgray']	= imageColorAllocate($im, 127, 127, 127);
	$C['dkgray']	= imageColorAllocate($im, 63, 63, 63);
	$C['black']	= imageColorAllocate($im, 0, 0, 0);
	$C['red']	= imageColorAllocate($im, 255, 0, 0);
	$C['brightgreen'] = imageColorAllocate($im, 0, 255, 0);
	$C['darkgreen']	= imageColorAllocate($im, 0, 192, 0);
	$C['blue']	= imageColorAllocate($im, 0, 0, 255);
	$C['cyan']	= imageColorAllocate($im, 0, 255, 255);
	$C['magenta']	= imageColorAllocate($im, 255, 0, 255);
	$C['yellow']	= imageColorAllocate($im, 255, 255, 0);
	$C['orange']	= imageColorAllocate($im, 255, 128, 0);

	return $C;
}

function legend($im, $sz, $C){
	$r = 30;
	$fn = 5;
	$x = $sz - (4*$r+7) - 2;
	$y = $sz - $r - 3;

	imageFilledRectangle($im, $x, $y, $x + 4*$r + 7, $y + $r +1, $C['dkgray']);
	imageRectangle($im, $x+0*$r+1, $y+1, $x + 1*$r + 0, $y + $r, $C['red']);
	imageRectangle($im, $x+1*$r+2, $y+1, $x + 2*$r + 2, $y + $r, $C['yellow']);
	imageRectangle($im, $x+2*$r+4, $y+1, $x + 3*$r + 4, $y + $r, $C['darkgreen']);
	imageRectangle($im, $x+4*$r+6, $y+1, $x + 3*$r + 6, $y + $r, $C['brightgreen']);
	imageString($im, $fn, $x+3+0*$r, $y+$r/3, "<30", $C['red']);
	imageString($im, $fn, $x+5+1*$r, $y+$r/3, "30+", $C['yellow']);
	imageString($im, $fn, $x+7+2*$r, $y+$r/3, "35+", $C['darkgreen']);
	imageString($im, $fn, $x+9+3*$r, $y+$r/3, "40+", $C['brightgreen']);
}

function radial($angle, $sz){
	#turn into radians
	$angle = deg2rad($angle);

	# determine length of radius
	$r = $sz * 0.5 * 0.95;

	# and convert length/azimuth to cartesian
	$x0 = sprintf("%d", (($sz * 0.5) - ($r * cos($angle))));
	$y0 = sprintf("%d", (($sz * 0.5) - ($r * sin($angle))));
	$x1 = sprintf("%d", (($sz * 0.5) + ($r * cos($angle))));
	$y1 = sprintf("%d", (($sz * 0.5) + ($r * sin($angle))));

	return array($x0, $y0, $x1, $y1);
}

function azel2xy($az, $el, $sz){
	#rotate coords... 90deg W = 180deg trig
	$az += 270;

	#turn into radians
	$az = deg2rad($az);

	# determine length of radius
	$r = $sz * 0.5 * 0.95;
	$r -= ($r * ($el/90));

	# and convert length/azimuth to cartesian
	$x = sprintf("%d", (($sz * 0.5) + ($r * cos($az))));
	$y = sprintf("%d", (($sz * 0.5) + ($r * sin($az))));
	$x = $sz - $x;

	return array($x, $y);
}

function cellplot($im, $sz, $C, $cellsize, $e){
	list($sv, $el, $az, $snr, $u) = $e;

	if ((0 == $sv) || (0 == $az + $el + $snr) ||
	    ($az < 0) || ($el < 0))
		return;

	$color = $C['brightgreen'];
	if ($snr < 40)
		$color = $C['darkgreen'];
	if ($snr < 35)
		$color = $C['yellow'];
	if ($snr < 30)
		$color = $C['red'];
	if ($snr < 15)
		$color = $C['dkgray'];

	#consider an N-degree cell plotted at (0,0). its top left corner
	#will be (0,0) and its bottom right corner will be at (N,N). The
	#sides are straight lines from (0,0)-(0,N) and (N,0)-(N,N). The
	#top and bottom edges will be approximated by segments from
	#(0,0):(0,1)..(0,N-1):(0,N) and (N,0):(N,1)...(N,N-1):(N,N).
	#Plotting that unholy mess is the job of
	# imagefilledpolygon ( $image, array $points, $num_points, $color )

	$np = 0;
	$points = array();
	for($x = $az; $x <= $az+$cellsize; $x++){
		list($px,$py) = azel2xy($x, $el, $sz);
		array_push($points, $px, $py);
		$np++;
	}
	for($x = $az+$cellsize; $x >= $az; $x--){
		list($px,$py) = azel2xy($x, $el+$cellsize, $sz);
		array_push($points, $px, $py);
		$np++;
	}
	list($px,$py) = azel2xy($az, $el, $sz);
	array_push($points, $px, $py);
	$np++;

	if ($snr > 0)
		imageFilledPolygon($im, $points, $np, $color);
}

function splot($im, $sz, $C, $r, $filled, $e){
	list($sv, $az, $el, $snr, $u) = $e;

	if ((0 == $sv) || (0 == $az + $el + $snr))
		return;

	$color = $C['brightgreen'];
	if ($snr < 40)
		$color = $C['darkgreen'];
	if ($snr < 35)
		$color = $C['yellow'];
	if ($snr < 30)
		$color = $C['red'];
	if ($snr == 0)
		$color = $C['black'];

	list($x, $y) = azel2xy($el, $az, $sz);

	if ($snr > 0){
		if ($filled)
			imageFilledArc($im, $x, $y, $r, $r, 0, 360, $color, 0);
		else
			imageArc($im, $x, $y, $r, $r, 0, 360, $color);
	}
}

function elevation($im, $sz, $C, $a){
	$b = 90 - $a;
	$a = $sz * 0.95 * ($a/180);
	imageArc($im, $sz/2, $sz/2, $a*2, $a*2, 0, 360, $C['ltgray']);
	$x = $sz/2 - 16;
	$y = $sz/2 - $a;
	imageString($im, 2, $x, $y, $b, $C['ltgray']);
}

function skyview($im, $sz, $C){
	$a = 90; $a = $sz * 0.95 * ($a/180);
	imageFilledArc($im, $sz/2, $sz/2, $a*2, $a*2, 0, 360, $C['mdgray'], 0);
	imageArc($im, $sz/2, $sz/2, $a*2, $a*2, 0, 360, $C['black']);
	$x = $sz/2 - 16; $y = $sz/2 - $a;
	imageString($im, 2, $x, $y, "0", $C['ltgray']);

	$a = 85; $a = $sz * 0.95 * ($a/180);
	imageFilledArc($im, $sz/2, $sz/2, $a*2, $a*2, 0, 360, $C['white'], 0);
	imageArc($im, $sz/2, $sz/2, $a*2, $a*2, 0, 360, $C['ltgray']);
	imageString($im, 1, $sz/2 - 6, $sz+$a, '5', $C['black']);
	$x = $sz/2 - 16; $y = $sz/2 - $a;
	imageString($im, 2, $x, $y, "5", $C['ltgray']);

	skygrid($im, $sz, $C);
	$x = $sz/2 - 16; $y = $sz/2 - 8;
	/* imageString($im, 2, $x, $y, "90", $C['ltgray']); */

	imageString($im, 4, $sz/2 + 4, 2        , 'N', $C['black']);
	imageString($im, 4, $sz/2 + 4, $sz - 16 , 'S', $C['black']);
	imageString($im, 4, 4        , $sz/2 + 4, 'E', $C['black']);
	imageString($im, 4, $sz - 10 , $sz/2 + 4, 'W', $C['black']);

}

function skygrid($im, $sz, $C){
	for($i = 0; $i < 180; $i += 15){
		list($x0, $y0, $x1, $y1) = radial($i, $sz);
		imageLine($im, $x0, $y0, $x1, $y1, $C['ltgray']);
	}

	for($i = 15; $i < 90; $i += 15)
		elevation($im, $sz, $C, $i);
}

?>
