<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* This file contains all the functions pertaining to the cache type Images */

/* They come from the Categories Image plugin by www.zahlen.net */

	        add_action('cachetype_add_form_fields', 'ocwscc_add_taxonomy_field');
			add_action('cachetype_edit_form_fields', 'ocwscc_edit_taxonomy_field');
			add_filter( 'manage_edit-cachetype_columns', 'ocwscc_taxonomy_columns' );
			add_filter( 'manage_cachetype_custom_column', 'ocwscc_taxonomy_column', 10, 3 );

function ocwscc_add_style() {
	echo '<style type="text/css" media="screen">
		th.column-thumb {width:60px;}
		.form-field img.taxonomy-image {border:1px solid #eee;max-width:300px;max-height:300px;}
		.inline-edit-row fieldset .thumb label span.title {width:48px;height:48px;border:1px solid #eee;display:inline-block;}
		.column-thumb span {width:48px;height:48px;border:1px solid #eee;display:inline-block;}
		.inline-edit-row fieldset .thumb img,.column-thumb img {width:48px;height:48px;}
	</style>';
}

// add image field in add form
function ocwscc_add_taxonomy_field() {
	if (get_bloginfo('version') >= 3.5)
		wp_enqueue_media();
	else {
		wp_enqueue_style('thickbox');
		wp_enqueue_script('thickbox');
	}
	
	echo '<div class="form-field">
		<label for="creationcache_image">' . __('Image', 'creationcache') . '</label>
		<input type="text" name="creationcache_image" id="creationcache_image" value="" />
		<br/>
		<button class="ocwscc_upload_image_button button">Upload/Add image</button>
	</div>'.ocwscc_upload_script();
}

// add image field in edit form
function ocwscc_edit_taxonomy_field() {
	if (get_bloginfo('version') >= 3.5)
		wp_enqueue_media();
	else {
		wp_enqueue_style('thickbox');
		wp_enqueue_script('thickbox');
	}
	
        $term_id = "";
        
        if (isset($_GET['tag_ID'])){
        $term_id = trim($_GET['tag_ID']);
        
        }
	/* if (ocwscc_creationcache_image_url( $term_id, NULL, TRUE ) == OCWSCC_IMAGE_PLACEHOLDER) 
		$image_url = "";
	else */
		$image_url = ocws_ctype_id_image_url($term_id);
                $image_url2 = "";
                if (!($image_url == OCWSCC_IMAGE_PLACEHOLDER)){
                    $image_url2 = $image_url;
                }
                // $image_url = ocwscc_creationcache_image_url( $term_id, NULL, TRUE );
	echo '<tr class="form-field">
		<th scope="row" valign="top"><label for="creationcache_image">Image</label></th>
		<td><img class="taxonomy-image" src="' . $image_url . '"/><br/><input type="text" name="creationcache_image" id="creationcache_image" value="'.$image_url2.'" /><br />
		<button class="ocwscc_upload_image_button button">Upload/Add image</button>
		<button class="ocwscc_remove_image_button button">Remove image</button>
		</td>
	</tr>'.ocwscc_upload_script();
}

// upload using wordpress upload
function ocwscc_upload_script() {
	return '<script type="text/javascript">
	    jQuery(document).ready(function($) {
			var wordpress_ver = "'.get_bloginfo("version").'", upload_button;
			$(".ocwscc_upload_image_button").click(function(event) {
				upload_button = $(this);
				var frame;
				if (wordpress_ver >= "3.5") {
					event.preventDefault();
					if (frame) {
						frame.open();
						return;
					}
					frame = wp.media();
					frame.on( "select", function() {
						// Grab the selected attachment.
						var attachment = frame.state().get("selection").first();
						frame.close();
						if (upload_button.parent().prev().children().hasClass("tax_list")) {
							upload_button.parent().prev().children().val(attachment.attributes.url);
							upload_button.parent().prev().prev().children().attr("src", attachment.attributes.url);
						}
						else
							$("#creationcache_image").val(attachment.attributes.url);
					});
					frame.open();
				}
				else {
					tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
					return false;
				}
			});
			
			$(".ocwscc_remove_image_button").click(function() {
				$(".taxonomy-image").attr("src", "'.OCWSCC_IMAGE_PLACEHOLDER.'");
				$("#creationcache_image").val("");
				$(this).parent().siblings(".title").children("img").attr("src","' . OCWSCC_IMAGE_PLACEHOLDER . '");
				$(".inline-edit-col :input[name=\'creationcache_image\']").val("");
				return false;
			});
			
			if (wordpress_ver < "3.5") {
				window.send_to_editor = function(html) {
					imgurl = $("img",html).attr("src");
					if (upload_button.parent().prev().children().hasClass("tax_list")) {
						upload_button.parent().prev().children().val(imgurl);
						upload_button.parent().prev().prev().children().attr("src", imgurl);
					}
					else
						$("#creationcache_image").val(imgurl);
					tb_remove();
				}
			}
			
			$(".editinline").click(function() {	
			    var tax_id = $(this).parents("tr").attr("id").substr(4);
			    var thumb = $("#tag-"+tax_id+" .thumb img").attr("src");

				if (thumb != "' . OCWSCC_IMAGE_PLACEHOLDER . '") {
					$(".inline-edit-col :input[name=\'creationcache_image\']").val(thumb);
				} else {
					$(".inline-edit-col :input[name=\'creationcache_image\']").val("");
				}
				
				$(".inline-edit-col .title img").attr("src",thumb);
			});
	    });
	</script>';
}

// save our taxonomy image while edit or save term
add_action('edit_term','ocwscc_save_taxonomy_image');
add_action('create_term','ocwscc_save_taxonomy_image');
function ocwscc_save_taxonomy_image($term_id) {
    if(isset($_POST['creationcache_image']))
        update_option('ocwscc_creationcache_image'.$term_id, $_POST['creationcache_image'], NULL);
}

// get attachment ID by image url
function ocwscc_get_attachment_id_by_url($image_src) {
    global $wpdb;
    $query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid = %s", $image_src);
    $id = $wpdb->get_var($query);
    return (!empty($id)) ? $id : NULL;
}

// get taxonomy image url for the given term_id (Place holder image by default)
function ocwscc_creationcache_image_url($term_id = NULL, $size = 'full', $return_placeholder = FALSE) {
	/*
        if (!$term_id) {
		if (is_category())
			$term_id = get_query_var('cat');
		elseif (is_tax()) {
			$current_term = get_term_by('slug', get_query_var('term'), get_query_var('creationcache'));
			$term_id = $current_term->term_id;
		}
	}
        */
	
    $creationcache_image_url = get_option('ocwscc_creationcache_image'.$term_id);
    if(!empty($creationcache_image_url)) {
	    $attachment_id = ocwscc_get_attachment_id_by_url($creationcache_image_url);
	    if(!empty($attachment_id)) {
	    	$creationcache_image_url = wp_get_attachment_image_src($attachment_id, $size);
		    $creationcache_image_url = $creationcache_image_url[0];
	    }
	}

    if ($return_placeholder)
		return ($creationcache_image_url != '') ? $creationcache_image_url : OCWSCC_IMAGE_PLACEHOLDER;
	else
		return $creationcache_image_url;
}

function ocwscc_quick_edit_custom_box($column_name, $screen, $name) {
	if ($column_name == 'thumb') 
		echo '<fieldset>
		<div class="thumb inline-edit-col">
			<label>
				<span class="title"><img src="" alt="Thumbnail"/></span>
				<span class="input-text-wrap"><input type="text" name="creationcache_image" value="" class="tax_list" /></span>
				<span class="input-text-wrap">
					<button class="ocwscc_upload_image_button button">Upload/Add image</button>
					<button class="ocwscc_remove_image_button button">Remove image</button>
				</span>
			</label>
		</div>
	</fieldset>';
}

/**
 * Thumbnail column added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @return void
 */
function ocwscc_taxonomy_columns( $columns ) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['thumb'] = 'Image';

	unset( $columns['cb'] );

	return array_merge( $new_columns, $columns );
}

/**
 * Thumbnail column value added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @param mixed $column
 * @param mixed $id
 * @return void
 */
function ocwscc_taxonomy_column( $columns, $column, $id ) {
	if ( $column == 'thumb' )
		$columns = '<span><img src="' . ocwscc_creationcache_image_url($id, 'thumbnail', TRUE) . '" alt="Thumbnail" class="wp-post-image" /></span>';
	
	return $columns;
}

// Change 'insert into post' to 'use this image'
function ocwscc_change_insert_button_text($safe_text, $text) {
    return str_replace("Insert into Post", "Use this image", $text);
}

// Style the image in category list
if ( strpos( $_SERVER['SCRIPT_NAME'], 'edit-tags.php' ) > 0 ) {
	add_action( 'admin_head', 'ocwscc_add_style' );
	add_action('quick_edit_custom_box', 'ocwscc_quick_edit_custom_box', 10, 3);
	add_filter("attribute_escape", "ocwscc_change_insert_button_text", 10, 2);
}

// display taxonomy image for the given term_id
function ocwscc_creationcache_image($term_id = NULL, $size = 'full', $attr = NULL, $echo = TRUE) {
	if (!$term_id) {
		if (is_category())
			$term_id = get_query_var('cat');
		elseif (is_tax()) {
			$current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
			$term_id = $current_term->term_id;
		}
	}
	
    $taxonomy_image_url = get_option('ocwscc_creationcache_image'.$term_id);
    if(!empty($taxonomy_image_url)) {
	    $attachment_id = ocwscc_get_attachment_id_by_url($taxonomy_image_url);
	    if(!empty($attachment_id))
	    	$taxonomy_image = wp_get_attachment_image($attachment_id, $size, FALSE, $attr);
	    else {
	    	$image_attr = '';
	    	if(is_array($attr)) {
	    		if(!empty($attr['class']))
	    			$image_attr .= ' class="'.$attr['class'].'" ';
	    		if(!empty($attr['alt']))
	    			$image_attr .= ' alt="'.$attr['alt'].'" ';
	    		if(!empty($attr['width']))
	    			$image_attr .= ' width="'.$attr['width'].'" ';
	    		if(!empty($attr['height']))
	    			$image_attr .= ' height="'.$attr['height'].'" ';
	    		if(!empty($attr['title']))
	    			$image_attr .= ' title="'.$attr['title'].'" ';
	    	}
	    	$taxonomy_image = '<img src="'.$taxonomy_image_url.'" '.$image_attr.'/>';
	    }
	}

	if ($echo)
		echo $taxonomy_image;
	else
		return $taxonomy_image;
}

/*
 * This function finds the appropriate cache image url from the creation cache id
 */
function ocwscc_ctype_image_url($cache_id){
        $cimage_url = OCWSCC_IMAGE_PLACEHOLDER;
        $cimage_url_id = "";
        if (!$cache_id){
                $terms = get_the_terms( $cache_id , 'cachetype' );
                if($terms) {
                        foreach( $terms as $term ) {
                                $cimage_url_id = $term->term_id;
                        }
                } 
                $cimage_url_str = "ocwscc_creationcache_image".strval($cimage_url_id);
                if (!get_option($cimage_url_str)){
                    $cimage_url = OCWSCC_IMAGE_PLACEHOLDER;
                } else {
                    $cimage_url = get_option($cimage_url_str);
                }
        }
        
        return $cimage_url;
}

/*
 * This function finds the appropriate cache image url from the cachetype id
 */
function ocws_ctype_id_image_url($ctype_id){
    $cimage_url_str = "ocwscc_creationcache_image".strval($ctype_id);
                if (!get_option($cimage_url_str)){
                    $cimage_url = OCWSCC_IMAGE_PLACEHOLDER;
                } else {
                    $cimage_url = get_option($cimage_url_str);
                }
    return $cimage_url;
}


?>