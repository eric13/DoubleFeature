Alternate View: <a href=http://doublefeatureshow.com/list-of-films-a-z>List of Films A-Z</a>

Rather than sorting through double features, you can use this page to see every film listed in alphabetical order.  Click a movie's cover to go to the appropriate episode page, where you can also find ultra high resolution cover art.  To save you from clicking on <i>Next Page</i> over and over, this will load every cover on one page.  That might take a minute.

<?php

	mysql_pconnect ("dou1110203585232.db.6837452.hostedresource.com", "dou1110203585232", "XXX") or die("error connecting to database");
	mysql_select_db ("dou1110203585232") or die("error connecting to database");
			
	$ars = mysql_query ("SELECT * FROM wp_posts WHERE post_type='post' AND post_status='publish' AND post_author='1' ORDER BY post_title ASC  ");
	$array = array();

	for ($i = 0; $i < mysql_num_rows($ars); $i++){
		$name = mysql_result($ars,$i,"post_title");
		$name1 = strtok($name, "+");
		$name1 = trim($name1, " ");

		// Correct for Killapalooza
		if ( substr($name1, 0, 13) == "Killapalooza " ){
			$name1url = $name1;
			$name1 = substr($name1, 16);
			$name1 = trim($name1, " ");
			// Add to titles
			if ($name1=="Child's Play"){ $name1 = "Child's Play (Chucky Series)"; }
			else if ($name1=="Friday the 13th"){ $name1 = "Friday the 13th (Jason Series)"; }
			else if ($name1=="Halloween"){ $name1 = "Halloween (Michael Myers Series)"; }
			else if ($name1=="Hellraiser"){ $name1 = "Hellraiser (Pinhead Series)"; }
			else if ($name1=="A Nightmare on Elm Street"){ $name1 = "A Nightmare on Elm Street (Freddy Krueger Series)"; }
			else if ($name1=="Texas Chainsaw Massacre"){ $name1 = "Texas Chainsaw Massacre (Leatherface Series)"; }
			else { $name1="$name1 (Series)"; }
		}

		// Correct for starting with "The "
		if ( substr($name1, 0, 4) == "The " ){
			$echo1 = substr($name1, 4);
			$echo1 = "$echo1, The";
		} else {
			$echo1 = $name1;
		}

		// Correct for starting with "A "
		if ( substr($echo1, 0, 2) == "A " ){
			$echo1 = substr($echo1, 2);
			$echo1 = "$echo1, A";
		}


		$name2 = str_replace("$name1 + ", "", "$name");

		// Correct for Killapalooza
		if ( substr($name2, 0, 13) == "Killapalooza " ){
			$name2url = $name2;
			$name2 = substr($name2, 16);
			$name2 = trim($name2, " ");
			// Add to titles
			if ($name2=="Child's Play"){ $name2 = "Child's Play (Chucky Series)"; }
			else if ($name2=="Friday the 13th"){ $name2 = "Friday the 13th (Jason Series)"; }
			else if ($name2=="Halloween"){ $name2 = "Halloween (Michael Myers Series)"; }
			else if ($name2=="Hellraiser"){ $name2 = "Hellraiser (Pinhead Series)"; }
			else if ($name2=="A Nightmare on Elm Street"){ $name2 = "A Nightmare on Elm Street (Freddy Krueger Series)"; }
			else if ($name2=="Texas Chainsaw Massacre"){ $name2 = "Texas Chainsaw Massacre (Leatherface Series)"; }
			else if ($name2=="Alien + Predator"){ $name2 = "Predator (Series)"; }
			else { $name2="$name2 (Series)"; }
		}

		// Correct for starting with "The"
		if ( substr($name2, 0, 4) == "The " ){
			$echo2 = substr($name2, 4);
			$echo2 = "$echo2, The";
		} else {
			$echo2 = $name2;
		}

		// Correct for starting with "A "
		if ( substr($name2, 0, 2) == "A " ){
			$echo2 = substr($name2, 2);
			$echo2 = "$echo2, A";
		} 

		// Forms the URL to permalink style domain.com/year/month/short.html
		$url_date = mysql_result($ars,$i,"post_date");
		$url_date = substr($url_date, 0, 7);
		$url_date = str_replace("-", "/", "$url_date");
		$url_short = mysql_result($ars,$i,"post_name");
		$url = "http://doublefeatureshow.com/$url_date/$url_short.html";

if (!$name1url) {$name1url=$name1;}
		$array[$i][1] = $echo1;
		$array[$i][2] = $url;
		$array[$i][3] = $name1url;
		$name1url="";

if (!$name2url) {$name2url=$name2;}
		$fi = $i+mysql_num_rows($ars);
		$array[$fi][1] = $echo2;
		$array[$fi][2] = $url;
		$array[$fi][3] = $name2url;
		$name2url="";
	}

sort($array);
for ($i = 0; $i < (mysql_num_rows($ars)*2); $i++){
		if ($array[$i][1] != $array[$i-1][1]
		&& substr($array[$i][1], 0, 18) != "Music Box Massacre"
		&& substr($array[$i][1], 0, 19) != "Double Feature Year") {

$eurl = $array[$i][3];
$eurl = strtolower($eurl);
$eurl = str_replace(" ", "-", "$eurl");
$eurl = str_replace(" ", "-", "$eurl");
$eurl = str_replace("'", "", "$eurl");
$eurl = str_replace(":", "", "$eurl");
$eurl = str_replace("?", "", "$eurl");
$eurl = str_replace(".", "", "$eurl");
$eurl = str_replace(",", "", "$eurl");
$eurl = str_replace("!", "", "$eurl");
$eurl = str_replace("(", "", "$eurl");
$eurl = str_replace(")", "", "$eurl");

			echo "<a href=" .  $array[$i][2] . "><img src=http://doublefeatureshow.com/images/covers/tiny/tiny-$eurl.jpg alt=\"" . $array[$i][1] . "\"  style='width: 100px; height:150px; border: 1px solid #000; margin: 0px 10px 20px 10px;' align='left' /></a>";
		}
}

?>
<div style="clear: both;"">&nbsp;</div>
