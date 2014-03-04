<?php
/**
 * Displays a Google Map on category pages. To include a Google Map
 * only on specific categories, place this code in 
 * "category-yourcategoryname.php."
 *
 * This is an example page for the wp_googlemap plugin.
 * This example uses Bootstrap to format the page. See a
 * live example at americawasnotfree.org/category/the-conquest
 *
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>

	<header class="row jumbotron" role="heading">
		<h1> <?php single_cat_title( '', true ); ?></h1>
	</header>
	
	
	<div class="row map-padding">
	
		<!-- In this example, the map (#map_canvas) is placed before the description -->
		<div id="map_canvas" class="col-xs-24 col-sm-16" role="main"></div>
		
		
		<script type="text/javascript">
		// This function triggers the resize function for the google map (and the category description) to be 90% the height of the browser window. If you only want to resize the google map, include only the lines related to responsiveHeight('#map_canvas',0.9);
			(function( $ ){
				$(document).ready( function() {
					responsiveHeight('#map_canvas',0.9);
					mapDescriptionHeight(responsiveHeight, '20em', '#map_description',0.9);
					$('#map_btn').click( function() {
						mapdescription_toggle();
					});
				});
				$(window).resize( function() {
					responsiveHeight('#map_canvas',0.9);
					mapDescriptionHeight(responsiveHeight,'20em', '#map_description',0.9);
				});
			})( jQuery );
		</script>
		<!--
			Below the map description is echoed and formatted using Bootstrap and several JavaScript functions. But to display the map description, you only need...
		
			if ( category_description() ) :
				echo category_description();
			endif;
			
			Place that wherever you want it.
		-->
		<?php if ( category_description() ) : // Show an optional category description ?>
		<div id="map_description" class="col-xs-24 col-sm-8 row">
			<input id="map_btn" class="col-xs-24 col-sm-2" type="button" value="&#9658"/>
			<div id="description" class="col-xs-24 col-sm-22" role="article">
				<?php echo category_description(); ?>
			</div>
		</div>
		<?php endif; ?>
		
	</div>
	
<?php
	/**
	 * Below, $latlong and $zoom are properties of the category. These
	 * are inputted on the categories page, and created using the
	 * Tax_Meta_Class created by Bainternet.
	 *
	 */
	$field = 'name';
	$value = single_cat_title( '', false );
	$taxonomy = 'category';
	$term = get_term_by( $field, $value, $taxonomy);
	$term_id = $term->term_id;
	
	$latlong = get_tax_meta($term_id,'latlong',false);
	$zoom = get_tax_meta($term_id,'zoomlevel',false);

	/**
	 * google_map_embed_before($latlong, $zoom); must be placed before
	 * the loop.
	 *
	 */
	google_map_embed_before($latlong, $zoom); ?>
<?php // include embedGoogleMap.php; ?>
<?php

	/**
	 * If you include the below loop as is (including the 6 lines of code
	 * before the loop), all the posts associated with this category will
	 * be placed on the map as an infowindow.
	 *
	 */
	$counter = 0;
	echo "\n// Infowindows\n";
	echo "\n var markers = [];";
	echo "\n var myLatlng = [];";
	echo "\n var infowindow = new google.maps.InfoWindow();";

	/* The Loop */
	while ( have_posts() ) : the_post();
		$latlong = get_post_custom_values('latlong', $post->ID);
		echo "\n// A post";
		echo "\n myLatlng[$counter] = new google.maps.LatLng($latlong[0]);";

		$post = get_the_content();
		$clean_post =  htmlentities($post, ENT_QUOTES, 'UTF-8');
		$clean_post = preg_replace("/\r\n|\r|\n/",'<br/>',$clean_post);
		$title = get_the_title();
		$clean_title =  htmlentities($title, ENT_QUOTES, 'UTF-8');

		$contentString = "<div>$clean_post</div>";
		echo "\n markers[$counter] = new google.maps.Marker({
								  position: myLatlng[$counter],
								  map: map,
								  title: '" . $clean_title . "',
								  contents: '" . $contentString . "'
							  });";
		$counter++;
	 endwhile;
	/* End Loop */
?>
<?php /* Must include google_map_embed_after(); after the loop */ ?>
<?php google_map_embed_after(); ?>
<?php endif; ?>
<?php /* Code below is not necessary. Inputted just for example. */ ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>