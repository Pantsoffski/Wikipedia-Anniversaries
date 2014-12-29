<?php

function add_views($postID) {
	global $wpdb;
	$popular_posts_statistics_table = $wpdb->prefix . 'popular_posts_statistics';
	if (!$wpdb->query("SELECT hit_count FROM $popular_posts_statistics_table WHERE post_id = $postID")) {
		$result = $wpdb->query("INSERT INTO $popular_posts_statistics_table (post_id, hit_count, date) VALUES ($postID, 1, NOW())");
	}else{
		$hitsnumber = $wpdb->get_results("SELECT hit_count FROM $popular_posts_statistics_table WHERE post_id = $postID", ARRAY_A);
		$hitsnumber = $hitsnumber[0]['hit_count'];
		$result = $wpdb->query("UPDATE $popular_posts_statistics_table SET hit_count = $hitsnumber + 1 WHERE post_id = $postID");
	}
	return ($result);
}

?>