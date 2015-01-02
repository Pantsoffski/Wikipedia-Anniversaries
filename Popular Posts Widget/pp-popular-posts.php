<?php
/*
Plugin Name: Popular Posts Statistics
Plugin URI: http://smartfan.pl/
Description: Widget which displays statistics of most popular posts based on mumber of visits.
Author: Piotr Pesta
Version: 1.0.0
Author URI: http://smartfan.pl/
License: GPL12
*/

include 'functions.php';

register_activation_hook(__FILE__, 'popular_posts_statistics_activate'); //akcja podczas aktywacji pluginu
register_uninstall_hook(__FILE__, 'popular_posts_statistics_uninstall'); //akcja podczas deaktywacji pluginu

// instalacja i zakładanie tabeli w mysql
function popular_posts_statistics_activate() {
	global $wpdb;
	$popular_posts_statistics_table = $wpdb->prefix . 'popular_posts_statistics';
		$wpdb->query("CREATE TABLE IF NOT EXISTS $popular_posts_statistics_table (
		id BIGINT(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		post_id BIGINT(50) NOT NULL,
		hit_count BIGINT(50),
		date DATETIME
		);");
}

// podczas odinstalowania - usuwanie tabeli
function popular_posts_statistics_uninstall() {
	global $wpdb;
	$popular_posts_statistics_table = $wpdb->prefix . 'popular_posts_statistics';
	$wpdb->query( "DROP TABLE IF EXISTS $popular_posts_statistics_table" );
}

class popular_posts_statistics extends WP_Widget {

// konstruktor widgetu
function popular_posts_statistics() {

	$this->WP_Widget(false, $name = __('Popular Posts Statistics', 'wp_widget_plugin'));

}

// tworzenie widgetu, back end (form)
function form($instance) {

// nadawanie i łączenie defaultowych wartości
	$defaults = array('title' => '');
	$instance = wp_parse_args( (array) $instance, $defaults );
?>

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
</p>

<?php

}

function update($new_instance, $old_instance) {
$instance = $old_instance;

// Dostępne pola
$instance['title'] = strip_tags($new_instance['title']);
return $instance;
}

// wyswietlanie widgetu, front end (widget)
function widget($args, $instance) {
extract( $args );

// these are the widget options
$title = apply_filters('widget_title', $instance['title']);

echo $before_widget;

// Check if title is set
if ( $title ) {
echo $before_title . $title . $after_title;
}

$postID = get_the_ID();

show_views($postID);

add_views($postID);

echo $after_widget;
}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("popular_posts_statistics");'));

add_action('wp_enqueue_scripts', function () { 
        wp_enqueue_style( 'popular_posts_statistics', plugins_url('style-popular-posts-statistics.css', __FILE__));
    });

?>