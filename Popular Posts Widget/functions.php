<?php

//zbieranie danych
function add_views($postID) {
	global $wpdb;
	$popular_posts_statistics_table = $wpdb->prefix . 'popular_posts_statistics';
	if (!$wpdb->query("SELECT hit_count FROM $popular_posts_statistics_table WHERE post_id = $postID") && $postID != 1) { //jeśli nie istnieje rekord hit_count w z podanym ID oraz ID nie jest równe 1
		$result = $wpdb->query("INSERT INTO $popular_posts_statistics_table (post_id, hit_count, date) VALUES ($postID, 1, NOW())"); //dodaje do tablicy id postu, date oraz hit
	}elseif ($postID != 1) { //w innym przypadku...
		$hitsnumber = $wpdb->get_results("SELECT hit_count FROM $popular_posts_statistics_table WHERE post_id = $postID", ARRAY_A);
		$hitsnumber = $hitsnumber[0]['hit_count'];
		$result = $wpdb->query("UPDATE $popular_posts_statistics_table SET hit_count = $hitsnumber + 1, date =  NOW() WHERE post_id = $postID");
	}
}

//wyświetlanie wyników
function show_views($postID, $posnumber, $numberofdays) {
	global $wpdb;
	$popular_posts_statistics_table = $wpdb->prefix . 'popular_posts_statistics';
	$posts_table = $wpdb->prefix . 'posts';
	if ($wpdb->query("SELECT hit_count FROM $popular_posts_statistics_table")) {
		$result = $wpdb->get_results("SELECT hit_count FROM $popular_posts_statistics_table WHERE date >= CURDATE() - INTERVAL $numberofdays DAY ORDER BY hit_count DESC", ARRAY_A);
		$post_id_number = $wpdb->get_results("SELECT post_id FROM $popular_posts_statistics_table WHERE date >= CURDATE() - INTERVAL $numberofdays DAY ORDER BY hit_count DESC LIMIT $posnumber", ARRAY_A);
		for ($i = 0; $i < count($post_id_number); ++$i) {
			$post_number = $post_id_number[$i]['post_id'];
			$post_name_by_id = $wpdb->get_results("SELECT post_title FROM $posts_table WHERE ID = $post_number", ARRAY_A);
			echo $post_name_by_id[0]['post_title'] . " | ";
			echo $result[$i]['hit_count'] . "<br />";
		}
	}
}

?>