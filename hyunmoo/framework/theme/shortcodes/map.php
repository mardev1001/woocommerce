<?php
	function hyunmoo_shortcode_map( $atts, $content = '' ) {
		$default_atts = array(
			'element' => 'map_canvas',
			'width' => '100%',
			'height' => '500px',
			'zoom' => '7',
			'center' => '38.9613433, 125.8279959',
			'scroll' => 'false',
			'address' => 'Pyongyang,Korea'
		);
	
		# Overwrite Default Attributes
		$atts = shortcode_atts( $default_atts, $atts );
		
		extract($atts);
		
		//Google Map Address to Lat/Long
		$location = $center;
		$info = @file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . urlencode( $address ) . '&sensor=false');
		$json = json_decode( $info );
		if( !empty( $json->results ) ) {
			$location = $json->results[0]->geometry->location->lat . ',' . $json->results[0]->geometry->location->lng;
		}
		wp_enqueue_script( 'googlemap', 'http://maps.googleapis.com/maps/api/js?sensor=false' );
		ob_start();
?>
<script type="text/javascript">
jQuery(document).ready(function() {
    // Set the Map variable
    var map;
	//Set the InfoWindow variable
	var infowindow;
    function initialize() {	
		var options = {
			scrollwheel: <?php echo $scroll ?>,
			zoom: <?php echo $zoom ?>,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var infoWindow = new google.maps.InfoWindow;
		map = new google.maps.Map(document.getElementById('<?php echo $element ?>'), options);
		// Set the center of the map
		var pos = new google.maps.LatLng(<?php echo $center ?>);
		map.setCenter(pos);
		infowindow = new google.maps.InfoWindow();
		function infoCallback(content, marker) {
			return function() {
				infowindow.setContent(content);
				infowindow.open(map, marker);
			};
		}
		latlngset = new google.maps.LatLng(<?php echo $location ?>);
		var marker = new google.maps.Marker({
			map :	map,
			position :	latlngset,
			animation :	google.maps.Animation.DROP,
			icon :	'<?php echo get_bloginfo( 'template_url' ) . '/images/mapicon.png' ?>'
		});
		var content = '<div class="map-content"><?php echo $content ?></div>';
		google.maps.event.addListener(
			marker,
			'click',
			infoCallback(content, marker)
		);
    };
    // Initializes the Google Map
    google.maps.event.addDomListener(window, 'load', initialize);
});
</script>
<div id="<?php echo $element ?>" style="height: <?php echo $height ?>;width: <?php echo $width ?>;margin:auto;"></div>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	add_shortcode( 'map', 'hyunmoo_shortcode_map' );
?>