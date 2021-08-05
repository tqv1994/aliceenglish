var Themify_Event_post;
jQuery( function( $ ){

	Themify_Event_post = {
		request: 0,
		init_map : function() {
			if ( typeof google === 'object' && typeof google.maps === 'object' ) {
				Themify_Event_post.do_maps();
			} else if ( typeof google === 'undefined' && typeof themifyEventPosts !== 'undefined' ) {
				$.getScript( '//maps.googleapis.com/maps/api/js?v=3.exp&key=' + themifyEventPosts.map_key ).done( function() {
					Themify_Event_post.do_maps();
				} );
			}
		},
		do_maps : function() {
			$( '.tep_map' ).each( function() {
				var args = $( this ).data( 'map' );
				Themify_Event_post.do_map( args.address, args.num, args.zoom, args.type, args.scroll, args.drag );
			} );
		},
		do_map : function( address, num, zoom, type, scroll, drag ){
			var delay = this.request++ * 500;
			setTimeout( function(){
				var geo = new google.maps.Geocoder(),
					latlng = new google.maps.LatLng(-34.397, 150.644),
					mapOptions = {
						'zoom': zoom,
						center: latlng,
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						scrollwheel: scroll,
						draggable: drag
					};
				switch( type.toUpperCase() ) {
					case 'ROADMAP':
						mapOptions.mapTypeId = google.maps.MapTypeId.ROADMAP;
						break;
					case 'SATELLITE':
						mapOptions.mapTypeId = google.maps.MapTypeId.SATELLITE;
						break;
					case 'HYBRID':
						mapOptions.mapTypeId = google.maps.MapTypeId.HYBRID;
						break;
					case 'TERRAIN':
						mapOptions.mapTypeId = google.maps.MapTypeId.TERRAIN;
						break;
				}
				var node = document.getElementById( 'themify_map_canvas_' + num );
				var	map = new google.maps.Map( node, mapOptions ),
					revGeocoding = $( node ).data('reverse-geocoding') ? true: false;

				/* store a copy of the map object in the dom node, for future reference */
				$( node ).data( 'gmap_object', map );

				if ( revGeocoding ) {
					var latlngStr = address.split(',', 2),
						lat = parseFloat(latlngStr[0]),
						lng = parseFloat(latlngStr[1]),
						geolatlng = new google.maps.LatLng(lat, lng),
						geoParams = { 'latLng': geolatlng };
				} else {
					var geoParams = { 'address': address };
				}

				geo.geocode( geoParams, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						var position = revGeocoding ? geolatlng : results[0].geometry.location;
						map.setCenter(position);
						var marker = new google.maps.Marker({
							map: map,
							position: position
						}),

						info = $( '#themify_map_canvas_' + num ).data( 'info-window' );
						if( undefined !== info ) {
							var contentString = '<div class="themify_builder_map_info_window">'+ info +'</div>',

							infowindow = new google.maps.InfoWindow({
								content: contentString
							});

							google.maps.event.addListener( marker, 'click', function() {
								infowindow.open( map, marker );
							});
						}
					}
				});
			}, delay );
		}
	};

	if(document.getElementsByClassName('tep_map').length>0){
		Themify_Event_post.init_map();
	}

} );
