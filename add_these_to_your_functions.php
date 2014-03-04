<?php
/**
 * You must include this function before your category page loop.
 *
 */
function google_map_embed_before($LatLng, $zoom) {
	$map_script = "
	<script type='text/javascript'>
		function initialize() {
			var map_canvas = document.getElementById('map_canvas');
			var map_options = {
				center: new google.maps.LatLng($LatLng),
				zoom: $zoom,
				mapTypeId: google.maps.MapTypeId.TERRAIN,
				mapTypeControlOptions: {
					mapTypeIds: [google.maps.MapTypeId.TERRAIN, google.maps.MapTypeId.HYBRID]
				}
			}
			var stylesArray = [
				{
					'featureType': 'road',
					'elementType': 'geometry.fill',
					'stylers': [
					  { 'visibility': 'on' },
					  { 'weight': 0.4 },
					  { 'color': '#d8e4cc' }
					]
				}
			 ];
			map = new google.maps.Map(map_canvas, map_options)
			map.setOptions({styles: stylesArray});";

	echo $map_script;
}
/**
 * You must include this function after your category page loop.
 *
 */
function google_map_embed_after(){

	$map_script = "
	for (var i = 0, marker; marker = markers[i]; i++) {
			google.maps.event.addListener(marker, 'click', function(e) {
				infowindow.setContent(this.contents);
				infowindow.open(map, this);
		  });
		}
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	</script>";
	
	echo $map_script;
}

/**
 * wp_gmaps_ui.js contains a function that resizes the the google map
 * whenever the browser height changes. You may copy the javascript
 * to your existing .js files or include it as I do below. Up to you.
 *
 */
function wp_gmaps_ui.js(){
	wp_enqueue_script(
		'mericawa_ui.js',
		get_stylesheet_directory_uri() . '/js/mericawa_ui.js',
		array( 'jquery' ),
		'',
		true);
	wp_enqueue_script('jquery');
}
add_action( 'wp_enqueue_scripts', 'wp_gmaps_ui.js' );


/**
 *	Below is use of the tax-meta class, developed by Bainternet
 * (see FAQ at http://en.bainternet.info/2012/tax-meta-class-faq).
 * If you already have tax-meta class, then use your own distri-
 * bution, but create a new Tax_Meta_Class with the configuration
 * below.
 *
 * This creates the meta-data fields that store the latitude, long-
 * itude, and zoom level for categories.
 *
 */
require_once("Tax-meta-class/Tax-meta-class.php");
$config = array(
   'id' => 'google_maps_meta',
   'title' => 'Google Maps information for category page maps',
   'pages' => array('category'),
   'context' => 'normal',
   'fields' => array(),
   'local_images' => false,)
   'use_with_theme' => true
);
$googlemap = new Tax_Meta_Class($config);
$googlemap->addText('latlong',array('name'=> __('Google Maps Lat/Long', 'gmlatlong')));
$googlemap->addText('zoomlevel',array('name'=> __('Google Maps zoom level', 'gmzoom')));
$googlemap->Finish();
?>