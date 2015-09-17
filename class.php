<?php

class wikiLeech {
	public $data2;
	public $start;
	public $end;
	public $cache_file;
	
	public function __construct() {
		$this->cache_file = plugin_dir_path(__FILE__).'anniversaries.cache';
	}
	
	public function leechMe($url) {
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
 	
	public function cacheMeOrNot($cache, $url, $start, $end) {
		if($cache == 1) {
			if(file_exists($this->cache_file) && (filesize($this->cache_file) > 50) && (filemtime($this->cache_file) > (time() - 3600 * 5 ))) {
				$cached = file_get_contents($this->cache_file);
				echo $cached;
			}else {
				$this->leechMe($url);
				$to_file = $this->showWiki($start, $end);
				file_put_contents($this->cache_file, $to_file);
				$cached = file_get_contents($this->cache_file);
				echo $cached;
			}
		}else {
			$this->leechMe($url);
			echo $this->showWiki($start, $end);
		}
	}
}

?>