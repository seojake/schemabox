<?php
/*
Plugin Name: Schema Box
Plugin URI:   https://www.seojake.com/
Description:  Lightweight meta box to add your Schema.org markup to your posts and pages.
Version:      1.0.1
Author:       SEO Jake
Author URI:   https://www.complexdigital.co.uk/
License:      GNU General Public License v3.0
License URI:  https://www.gnu.org/licenses/gpl-3.0.en.html
Text Domain:  schema-box
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Add meta box */
function schema_box_meta_box(){
    add_meta_box('schema-box', __('Schema Box', 'schema-box'), 'schema_box_field', [
        'post',
        'page'
    ]);
} add_action('add_meta_boxes', 'schema_box_meta_box');

/* Add Schema Box */
function schema_box_field($post){
    $schema_box = get_post_meta($post->ID, '_schema_box', true);
    $output = '<p>Learn more about Schema.org <a href="https://schema.org/" target="_blank">here.</a>';
    $output .= '<textarea onkeydown="tabIndent()" name="schema_box" id="schema_box" class="postbox schema_box_textarea" style="margin-top: 15px; padding: 20px; width: 100%; resize: vertical; min-height: 300px; max-height: 700px;" placeholder="Paste your Schema.org markup here..." >'. $schema_box .'</textarea>';
    echo $output;
}

/* Save user input */
function save_schema_box($post_id){
    update_post_meta($post_id, '_schema_box', $_POST['schema_box']);
} add_action('save_post', 'save_schema_box');

/* Add Schema Box to <head> tags */
function add_schema_box_front_end(){
    global $post;
    echo '<script type="application/ld+json">';
    echo get_post_meta($post->ID, '_schema_box', true);
    echo '</script>';
} add_action('wp_head', 'add_schema_box_front_end');
