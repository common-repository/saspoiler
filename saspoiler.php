<?
/*
Plugin Name: SASpoiler
Plugin URI: http://www.thedailyblitz.org/saspoiler-a-wordpress-plugin
Description: Hides text behind a black text/black background tile. Holding the mouse over the text reveals it. Insipred by Something Awful's spoiler system.
Version: 1.0
Author: Andy "Weasel" Moore
Author URI: http://www.thedailyblitz.org

Usage: Simply put a [SPOILER]tag around your text[/SPOILER] that you wish to become "spoilered." Works in both comments and posts.

*/

// Hooks the WP functions:
add_filter('the_content', 'tr_spoiler', 2);
add_filter('the_content', 'sq_spoiler', 2);
add_filter('comment_text', 'tr_spoiler', 4);
add_filter('comment_text', 'sq_spoiler', 4);

function tr_spoiler($content) // Searches for triangly-bracketed spoiler tags
{
  return preg_replace_callback(
    "%<spoiler.*(?:'([^']*)')?\s*(?:'([^']*)')?\s*>(.*)</spoiler>%isU",
    "spoilerify",
    $content);
} 

function sq_spoiler($content) // Searches for square-bracketed spoiler tags
{
  return preg_replace_callback(
    "%\[spoiler.*(?:/([^'/]*)/)?\s*(?:/([^'/]*)/)?\s*\](.*)\[/spoiler\]%isU",
    "spoilerify",
    $content);
}

function spoilerify($m) // This is the string that replaces the [spoiler] tags and text within
{
  return "<span class='spoiler' onmouseover=\"this.style.color='#FFFFFF';\" onmouseout=\"this.style.color=this.style.backgroundColor='#000000'\">".$m[3]."</span>";
}

function add_spoiler_header($text) // Adds some CSS styling to the header
{
  echo "
	<style type='text/css'>
	span.spoiler {background: #000; color: #000;}
	</style>";
  return $text;
}

// Hooks WP's header generation to add the spoiler CSS
add_action('wp_head', 'add_spoiler_header');
?>