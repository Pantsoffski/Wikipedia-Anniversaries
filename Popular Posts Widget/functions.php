<?php

//zbieranie danych
function add_views($postID) {
	global $wpdb;
	$popular_posts_statistics_table = $wpdb->prefix . 'popular_posts_statistics';
	if (!$wpdb->query("SELECT hit_count FROM $popular_posts_statistics_table WHERE post_id = $postID") && $postID != 1) {
		$result = $wpdb->query("INSERT INTO $popular_posts_statistics_table (post_id, hit_count, date) VALUES ($postID, 1, NOW())");
	}elseif ($postID != 1) {
		$hitsnumber = $wpdb->get_results("SELECT hit_count FROM $popular_posts_statistics_table WHERE post_id = $postID", ARRAY_A);
		$hitsnumber = $hitsnumber[0]['hit_count'];
		$result = $wpdb->query("UPDATE $popular_posts_statistics_table SET hit_count = $hitsnumber + 1 WHERE post_id = $postID");
	}
}

//wyświetlanie wyników
function show_views($postID) {
	global $wpdb;
	$popular_posts_statistics_table = $wpdb->prefix . 'popular_posts_statistics';
	$posts_table = $wpdb->prefix . 'posts';
	if ($wpdb->query("SELECT hit_count FROM $popular_posts_statistics_table")) {
		$result = $wpdb->get_results("SELECT hit_count FROM $popular_posts_statistics_table ORDER BY hit_count DESC", ARRAY_A);
		$post_id_number = $wpdb->get_results("SELECT post_id FROM $popular_posts_statistics_table", ARRAY_A);
		$ids = implode(":", $post_id_number);
		$post_name_by_id = $wpdb->get_results("SELECT post_title FROM $posts_table WHERE ID IN (7,9,10)", ARRAY_A);
		print json_encode($post_id_number) . "<br />";
		for ($i = 0; $i < count($result); ++$i) {
//		print $post_name_by_id[$i]['post_title'] . " | ";
		print $result[$i]['hit_count'] . "<br />";
		}
	}
}

?>