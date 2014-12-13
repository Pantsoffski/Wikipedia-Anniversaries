<?php

function wikiPLkalendarium() {
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,"http://pl.wikipedia.org/wiki/Wikipedia:Strona_g%C5%82%C3%B3wna");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch,CURLOPT_MAXREDIRS,10);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,70);
		curl_setopt($ch,CURLOPT_USERAGENT,"wiki on day");
		curl_setopt($ch,CURLOPT_HTTP_VERSION,'CURLOPT_HTTP_VERSION_1_1');
	$data = curl_exec($ch);
	$data = strip_tags($data, '<ul>, <li>'); //wywala ca≥y html
	$data = trim(preg_replace('/\s+/', ' ', $data)); //usuwa wszystkie, niepotrzebne przerwy, entery itp.
	$start = "Rocznice";
	$end = "([0-9]|[0-9][0-9])(\s)(stycznia|lutego|marca|kwietnia|maja|czerwca|lipca|sierpnia|wrzeúnia|paüdziernika|listopada|grudnia)";

	function getTextBetweenTagsKalendarium($start, $end, $data){
 		$matches = array();
    	$pattern = "/$start.(.*?).$end/";
    	if (preg_match($pattern, $data, $matches)) {
			echo "<div class=\"wikiday\">" . $matches[1] . "</div>";
		}
 	}

	return getTextBetweenTagsKalendarium($start, $end, $data);
}

function wikiENkalendarium() {
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,"http://en.wikipedia.org/wiki/Main_Page");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_MAXREDIRS,10);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,70);
		curl_setopt($ch,CURLOPT_USERAGENT,"wiki on day");
		curl_setopt($ch,CURLOPT_HTTP_VERSION,'CURLOPT_HTTP_VERSION_1_1');
	$data = curl_exec($ch);
	$data = strip_tags($data, '<ul>, <li>'); //wywala ca≥y html
	$data = trim(preg_replace('/\s+/', ' ', $data)); //usuwa wszystkie, niepotrzebne przerwy, entery itp.
	$start = "On this day...";
	$end = "More anniversaries";

	function getTextBetweenTagsKalendarium($start, $end, $data){
 		$matches = array();
    	$pattern = "/$start.(.*?).$end/";
    	if (preg_match($pattern, $data, $matches)) {
			echo "<div class=\"wikiday\">" . $matches[1] . "</div>";
		}
 	}

	return getTextBetweenTagsKalendarium($start, $end, $data);
}

function wikiDEkalendarium() {
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,"http://de.wikipedia.org/wiki/Wikipedia:Hauptseite");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_MAXREDIRS,10);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,70);
		curl_setopt($ch,CURLOPT_USERAGENT,"wiki on day");
		curl_setopt($ch,CURLOPT_HTTP_VERSION,'CURLOPT_HTTP_VERSION_1_1');
	$data = curl_exec($ch);
	$data = strip_tags($data, '<ul>, <li>'); //wywala ca≥y html
	$data = trim(preg_replace('/\s+/', ' ', $data)); //usuwa wszystkie, niepotrzebne przerwy, entery itp.
	$start = "Was geschah am .{1,2}.\s\D+\?";
	$end = "Weitere Ereignisse";

	function getTextBetweenTagsKalendarium($start, $end, $data){
 		$matches = array();
    	$pattern = "/$start.(.*?).$end/";
    	if (preg_match($pattern, $data, $matches)) {
			echo "<div class=\"wikiday\">" . $matches[1] . "</div>";
		}
 	}

	return getTextBetweenTagsKalendarium($start, $end, $data);
}

?>