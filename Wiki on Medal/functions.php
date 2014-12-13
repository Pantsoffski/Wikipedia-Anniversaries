<?php

function wikiPL() {
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,"http://pl.wikipedia.org/wiki/Wikipedia:Strona_g%C5%82%C3%B3wna");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_MAXREDIRS,10);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,70);
		curl_setopt($ch,CURLOPT_USERAGENT,"wiki on medal");
		curl_setopt($ch,CURLOPT_HTTP_VERSION,'CURLOPT_HTTP_VERSION_1_1');
	$data = curl_exec($ch);
	$data = strip_tags($data); //wywala ca³y html
	$data = trim(preg_replace('/\s+/', ' ', $data)); //usuwa wszystkie, niepotrzebne przerwy, entery itp.
	$start = "medal";
	$end = "Czytaj";

	function getTextBetweenTags($start, $end, $data){
 		$matches = array();
    	$pattern = "/$start(.*?)$end/";
    	if (preg_match($pattern, $data, $matches)) {
			echo "<div class=\"wikimedal\">" . $matches[1] . "</div>";
		}
 	}

	return getTextBetweenTags($start, $end, $data);
}

function wikiEN() {
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,"http://en.wikipedia.org/wiki/Main_Page");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_MAXREDIRS,10);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,70);
		curl_setopt($ch,CURLOPT_USERAGENT,"wiki on medal");
		curl_setopt($ch,CURLOPT_HTTP_VERSION,'CURLOPT_HTTP_VERSION_1_1');
	$data = curl_exec($ch);
	$data = strip_tags($data); //wywala ca³y html
	$data = trim(preg_replace('/\s+/', ' ', $data)); //usuwa wszystkie, niepotrzebne przerwy, entery itp.
	$start = "featured article";
	$end = "\(Full";

	function getTextBetweenTags($start, $end, $data){
 		$matches = array();
    	$pattern = "/$start(.*?)$end/";
    	if (preg_match($pattern, $data, $matches)) {
			echo "<div class=\"wikimedal\">" . $matches[1] . "</div>";
		}
 	}

	return getTextBetweenTags($start, $end, $data);
}

function wikiDE() {
	curl_setopt($ch,CURLOPT_URL,"http://de.wikipedia.org/wiki/Wikipedia:Hauptseite");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_MAXREDIRS,10);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,70);
		curl_setopt($ch,CURLOPT_USERAGENT,"wiki on medal");
		curl_setopt($ch,CURLOPT_HTTP_VERSION,'CURLOPT_HTTP_VERSION_1_1');
	$data = curl_exec($ch);
	$data = strip_tags($data); //wywala ca³y html
	$data = trim(preg_replace('/\s+/', ' ', $data)); //usuwa wszystkie, niepotrzebne przerwy, entery itp.
	$start = "des Tages";
	$end = 'â€“ Zum'; // em dash w stanie czystym

	function getTextBetweenTags($start, $end, $data){
 		$matches = array();
    	$pattern = "/$start(.*?)$end/";
    	if (preg_match($pattern, $data, $matches)) {
			echo "<div class=\"wikimedal\">" . $matches[1] . "</div>";
		}
 	}

	return getTextBetweenTags($start, $end, $data);
}

?>