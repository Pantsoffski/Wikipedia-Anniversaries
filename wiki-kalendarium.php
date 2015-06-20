<?php
/*
Plugin Name: Wikipedia Anniversaries
Plugin URI: http://smartfan.pl/
Description: Widget that shows anniversaries from Wikipedia.
Author: Piotr Pesta
Version: 1.1.0
Author URI: http://smartfan.pl/
License: GPL12
*/

include 'functions.php';

class wiki_this_day extends WP_Widget {

// konstruktor widgetu
function wiki_this_day() {

	$this->WP_Widget(false, $name = __('Wikipedia Anniversaries', 'wp_widget_plugin') );

}

function update($new_instance, $old_instance) {
$instance = $old_instance;
// Pola
$instance['title'] = strip_tags($new_instance['title']);
$instance['languages'] = strip_tags($new_instance['languages']);
return $instance;
}

// tworzenie widgetu, back end (form)

function form($instance) {

// nadawanie i łączenie defaultowych wartości
	$defaults = array('languages' => '1', 'title' => '');
	$instance = wp_parse_args( (array) $instance, $defaults );
?>

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'languages' ); ?>">Wiki language:</label>
<select id="<?php echo $this->get_field_id('languages'); ?>" name="<?php echo $this->get_field_name('languages'); ?>" value="<?php echo $instance['languages']; ?>" style="width:100%;">	
	<option value="1" <?php if ($instance['languages']==1) {echo "selected"; } ?>>English</option>
	<option value="2" <?php if ($instance['languages']==2) {echo "selected"; } ?>>Deutsch</option>
	<option value="3" <?php if ($instance['languages']==3) {echo "selected"; } ?>>Polish</option>
	<option value="4" <?php if ($instance['languages']==4) {echo "selected"; } ?>>Persian</option>
</select>
</p>

<?php

}

// wyswietlanie widgetu, front end (widget)
function widget($args, $instance) {
extract( $args );

// these are the widget options
$title = apply_filters('widget_title', $instance['title']);
$languages = $instance['languages'];
echo $before_widget;

// Check if title is set
if ( $title ) {
echo $before_title . $title . $after_title;
}

if ($languages == 1) {
	$f = new wikiLeech('http://en.wikipedia.org/wiki/Main_Page');
	$f->showWiki('On this day...', 'More anniversaries');
}
elseif ($languages == 2) {
	$f = new wikiLeech('http://de.wikipedia.org/wiki/Wikipedia:Hauptseite');
	$f->showWiki('Was geschah am [^<>]*\?', 'Weitere Ereignisse');
}
elseif ($languages == 4) {
	$f = new wikiLeech('http://fa.wikipedia.org/wiki/صفحهٔ_اصلی');
	$f->showWiki('امروز', '→');
}
elseif ($languages == 3) {
	$f = new wikiLeech('http://pl.wikipedia.org/wiki/Wikipedia:Strona_g%C5%82%C3%B3wna');
	$f->showWiki('Rocznice', '([0-9]|[0-9][0-9])(\s)(stycznia|lutego|marca|kwietnia|maja|czerwca|lipca|sierpnia|września|października|listopada|grudnia)(\s)');
}

echo $after_widget;
}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wiki_this_day");'));

add_action('wp_enqueue_scripts', function () { 
        wp_enqueue_style( 'wiki_this_day', plugins_url('style-wiki-this-day.css', __FILE__));
    });

?>