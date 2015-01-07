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
	$defaults = array('numberofdays' => '7', 'posnumber' => '5', 'title' => '');
	$instance = wp_parse_args( (array) $instance, $defaults );
?>

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'posnumber' ); ?>">Number of positions:</label>
<select id="<?php echo $this->get_field_id( 'posnumber' ); ?>" name="<?php echo $this->get_field_name('posnumber'); ?>" value="<?php echo $instance['posnumber']; ?>" style="width:100%;">	
	<option value="1" <?php if ($instance['posnumber']==1) {echo "selected"; } ?>>1</option>
	<option value="2" <?php if ($instance['posnumber']==2) {echo "selected"; } ?>>2</option>
	<option value="3" <?php if ($instance['posnumber']==3) {echo "selected"; } ?>>3</option>
	<option value="4" <?php if ($instance['posnumber']==4) {echo "selected"; } ?>>4</option>
	<option value="5" <?php if ($instance['posnumber']==5) {echo "selected"; } ?>>5</option>
	<option value="6" <?php if ($instance['posnumber']==6) {echo "selected"; } ?>>6</option>
	<option value="7" <?php if ($instance['posnumber']==7) {echo "selected"; } ?>>7</option>
	<option value="8" <?php if ($instance['posnumber']==8) {echo "selected"; } ?>>8</option>
	<option value="9" <?php if ($instance['posnumber']==9) {echo "selected"; } ?>>9</option>
	<option value="10" <?php if ($instance['posnumber']==10) {echo "selected"; } ?>>10</option>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id( 'numberofdays' ); ?>">Number of days:</label>
<select id="<?php echo $this->get_field_id( 'numberofdays' ); ?>" name="<?php echo $this->get_field_name('numberofdays'); ?>" value="<?php echo $instance['numberofdays']; ?>" style="width:100%;">	
	<option value="1" <?php if ($instance['numberofdays']==1) {echo "selected"; } ?>>1</option>
	<option value="2" <?php if ($instance['numberofdays']==2) {echo "selected"; } ?>>2</option>
	<option value="3" <?php if ($instance['numberofdays']==3) {echo "selected"; } ?>>3</option>
	<option value="4" <?php if ($instance['numberofdays']==4) {echo "selected"; } ?>>4</option>
	<option value="5" <?php if ($instance['numberofdays']==5) {echo "selected"; } ?>>5</option>
	<option value="6" <?php if ($instance['numberofdays']==6) {echo "selected"; } ?>>6</option>
	<option value="7" <?php if ($instance['numberofdays']==7) {echo "selected"; } ?>>7</option>
</select>
</p>

<?php

}

function update($new_instance, $old_instance) {
$instance = $old_instance;

// Dostępne pola
$instance['title'] = strip_tags($new_instance['title']);
$instance['posnumber'] = strip_tags($new_instance['posnumber']);
$instance['numberofdays'] = strip_tags($new_instance['numberofdays']);
return $instance;
}

// wyswietlanie widgetu, front end (widget)
function widget($args, $instance) {
extract( $args );

// these are the widget options
$title = apply_filters('widget_title', $instance['title']);
$posnumber = $instance['posnumber'];
$numberofdays = $instance['numberofdays'];
echo $before_widget;

// Check if title is set
if ( $title ) {
echo $before_title . $title . $after_title;
}

$postID = get_the_ID();

echo '<div id="pp-container">';
show_views($postID, $posnumber, $numberofdays);
echo '</div>';

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