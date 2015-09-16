<?php

class wikiLeech {
	public $data2;
	public $start;
	public $end;
	
	public function __construct($url) {
		$data = file_get_contents($url);
		$data = strip_tags($data, '<ul>, <li>, <hr>'); //wywala cały html
		$this->data2 = trim(preg_replace('/\s+/', ' ', $data)); //usuwa wszystkie, niepotrzebne przerwy, entery itp.
	}
	
	public function showWiki($start, $end){
		$data = $this->data2;
 		$matches = array();
    	$pattern = "/$start.(.*?).$end/";
    	if (preg_match($pattern, $data, $matches)) {
			return "<div class=\"wikiday\">" . $matches[1] . "</div>";
		}
 	}
}

?>