<?php

//zbieranie danych
function add_views($postID) {
	global $wpdb;
	$popular_posts_statistics_table = $wpdb->prefix . 'popular_posts_statistics';
	if (!$wpdb->query("SELECT hit_count FROM $popular_posts_statistics_table WHERE post_id = $postID") && $postID != 1 && $postID != 27227) { //jeśli nie istnieje rekord hit_count w z podanym ID oraz ID nie jest równe 1
		$result = $wpdb->query("INSERT INTO $popular_posts_statistics_table (post_id, hit_count, date) VALUES ($postID, 1, NOW())"); //dodaje do tablicy id postu, date oraz hit
	}elseif ($postID != 1 && $postID != 27227) { //w innym przypadku...
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
			$post_link = get_permalink($post_number); //zdobywanie permalinka
			$countbeginning = "<br /><span id=\"pp-count\">";
			$countending = " visits</span></span><br />";
			$post_name_by_id = $wpdb->get_results("SELECT post_title FROM $posts_table WHERE ID = $post_number", ARRAY_A);
			if (!$post_name_by_id){ //sprawdza, czy post o danym ID istnieje, jeśli nie - kasuje rekord i przerywa skrypt (który by wyświetlał błąd w pierwszej linii)
				$wpdb->query("DELETE FROM $popular_posts_statistics_table WHERE post_id = $post_number");
				break;
			}
			if ($i == 0){
				echo '<span id="pp-1-title">' . '<a href="' . $post_link . '">' . $post_name_by_id[0]['post_title'] . '</a>';
				echo $countbeginning . $result[$i]['hit_count'] . $countending;
			} else if($i == 1){
				echo '<span id="pp-2-title">' . $post_name_by_id[0]['post_title'];
				echo $countbeginning . $result[$i]['hit_count'] . $countending;
			} else if($i == 2){
				echo '<span id="pp-3-title">' . $post_name_by_id[0]['post_title'];
				echo $countbeginning . $result[$i]['hit_count'] . $countending;
			} else if($i == 3){
				echo '<span id="pp-4-title">' . $post_name_by_id[0]['post_title'];
				echo $countbeginning . $result[$i]['hit_count'] . $countending;
			} else if($i == 4){
				echo '<span id="pp-5-title">' . $post_name_by_id[0]['post_title'];
				echo $countbeginning . $result[$i]['hit_count'] . $countending;
			} else if($i == 5){
				echo '<span id="pp-6-title">' . $post_name_by_id[0]['post_title'];
				echo $countbeginning . $result[$i]['hit_count'] . $countending;
			} else if($i == 6){
				echo '<span id="pp-7-title">' . $post_name_by_id[0]['post_title'];
				echo $countbeginning . $result[$i]['hit_count'] . $countending;
			} else if($i == 7){
				echo '<span id="pp-8-title">' . $post_name_by_id[0]['post_title'];
				echo $countbeginning . $result[$i]['hit_count'] . $countending;
			} else if($i == 8){
				echo '<span id="pp-9-title">' . $post_name_by_id[0]['post_title'];
				echo $countbeginning . $result[$i]['hit_count'] . $countending;
			} else if($i == 9){
				echo '<span id="pp-10-title">' . $post_name_by_id[0]['post_title'];
				echo $countbeginning . $result[$i]['hit_count'] . $countending;
			}
		}
	}
}

//wybór stylu
function choose_style($cssselector) {
	if($cssselector == 1){
		return 'style-popular-posts-statistics-1.css';
	} elseif($cssselector == 2){
		return 'style-popular-posts-statistics-2.css';
	} elseif($cssselector == 3){
		return 'style-popular-posts-statistics-3.css';
	}
}

?>