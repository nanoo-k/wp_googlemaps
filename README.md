wp_googlemaps
=============

Add Google Maps to your Wordpress blog. With this plugin, adding a map is as easy as creating a Category, and then you add infowindows just like any other post.

At present, you need to upload this plugin manually. Once uploaded, this plugin gives you several functions that let you place a Google Map on a category page.


Installing these functions
==========================

Follow the instructions in the code to include these functions in your Wordpress theme. Then include Google's Map API in the head of your webpage. Choose whichever method works best for you. My method has been to include the code directly in my header.php file.

<!--Googlemap-->
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<!--[end]Googlemap-->

How to create a map
===================

Once functions are included, create a map by creating a new category. Then assign a center point (latitude and longitude in the form of 38.087013, -103.546944) and zoom level (number between 1 - 9) from the Edit Category page. (Consult the function files or email me if you don't see the Googlemap-specific textboxes).


How to add infowindows to the map
=================================

Assign a post to a map by choosing the map name as the post category. Then assign a custom field called "latlong" with a latitude and longitude in the form of 42.813537,-76.664171.