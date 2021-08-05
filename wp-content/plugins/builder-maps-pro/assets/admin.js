(function( $ ) {
'use strict';
let map,
	geo,
	markers = [], 
	poly,
    top_window = window.top,
    top_iframe = top_window.document,
	map_styles = null;
function builderMapsProInit(){
	geo = new top_window.google.maps.Geocoder();
	map = new top_window.google.maps.Map( top_iframe.getElementById( 'map-canvas' ), {
		center: new top_window.google.maps.LatLng( -34.397, 150.644 ),
                draggable:true,
                scrollwheel:true,
                zoomControl:true,
                scaleControl:true,
                mapTypeControl:true
	} );

	poly = new top_window.google.maps.Polyline( {} );
	poly.setMap( map );
	builderMapsPro_update_map_preview();
	const _markers = $( '#markers',top_iframe ).find( '.tb_repeatable_field' ),
		len=_markers.length,
		recursiv = function(i){
			setTimeout(function(){
				const row = $( _markers[i] ),
					lat = row.find( 'textarea.latlng' ),
					v = lat.val() !== ''?lat.val():row.find( '.address .tb_lb_option_child' ).val();
					row.attr( 'data-marker_index', i );
				// lat/lng has already been resolved
				builderMapsPro_add_new_marker( v, row.find( '.title .tb_lb_option_child' ).val(), row.find( '.tb_uploader_input' ).val(), i, row,function(){
					++i;
					if(i<len){
						recursiv(i);
					}
				} );
			},100);
		};
		if(len>0){
			recursiv(0);
		}
}
function builderMapsPro_update_map_preview() {
	if(typeof geo ==='undefined'){
		return;
	}
	const $ = jQuery,
	options = {
		zoom : parseInt( $( '#zoom_map',top_iframe ).val() ),
		mapTypeId : top_window.google.maps.MapTypeId[ $( '#type_map',top_iframe ).val() ],
		disableDefaultUI : $( '#disable_map_ui',top_iframe ).val() === 'yes',
		draggable : false,
		scrollwheel : false
	};
	geo.geocode( { 'address': $( '#map_center',top_iframe ).val() }, function( results, status ) {
		if (status === top_window.google.maps.GeocoderStatus.OK) {
			map.setCenter( results[0].geometry.location );
		}
	});
	map.setOptions( options );

	builderMapsPro_get_styles( function() {
		map.setOptions( {
			styles : map_styles[ $( '#style_map', top_iframe ).val() ]
		} );
	} );

	// Polyline update
	poly.setOptions( {
		geodesic: $( '#map_polyline_geodesic', top_iframe ).val() === 'yes',
		strokeColor: $( '#map_polyline_color', top_iframe ).val(),
		strokeOpacity: $( '#map_polyline_color', top_iframe ).parent().next( '.color_opacity' ).val() || 1,
		strokeWeight: $( '#map_polyline_stroke', top_iframe ).val(),
		visible: $( '#map_polyline', top_iframe ).val() === 'yes'
	} );
}
function builderMapsPro_add_new_marker( address, title, image, index, row,callback ) {
	if( address === null || address.trim() === '' ) {
		return null;
	}
        /* matches a valid lat/long value */
        const position = address.match( /^([-+]?[1-8]?\d(\.\d+)?|90(\.0+)?),?\s*([-+]?180(\.0+)?|[-+]?((1[0-7]\d)|([1-9]?\d))(\.\d+)?)(,\d+z)?$/ ),
            finish = function(p){
                    poly && poly.getPath().push( p );
                    markers[index] = new top_window.google.maps.Marker({
                            map : map,
                            position: p,
                            icon : image
                    });
                    if(!image){
                        markers[index].setIcon();
                    }
                    if( title.trim() !== '' ) {
                            const infowindow = new top_window.google.maps.InfoWindow({
                                    content: '<div class="maps-pro-content">' + title + '</div>'
                            });
                            top_window.google.maps.event.addListener( markers[index], 'click', function() {
                                    infowindow.open( map, markers[index] );
                            });
                    }

                    row.find( 'textarea.latlng' ).val( p.lat() + ',' + p.lng() );
                    if(callback){
                        callback();
                    }
            };
            if( $.isArray( position ) ) {
                    finish( new top_window.google.maps.LatLng( position[1], position[4] ) );
            } else {
                    geo.geocode( { 'address': address }, function( results, status ) {
                            if (status === top_window.google.maps.GeocoderStatus.OK) {
                                    finish( results[0].geometry.location );
                            }
                            return null;
                    });
            }
}

function builderMapsPro_remove_marker( index ) {
	if( markers[index] !== undefined ) {
		markers[index].setMap( null );
		markers[index] = null;
	}
}

/**
 * Retrieve list of custom map styles, located in builder-maps-pro/styles folder
 *
 * @param function callback called when data is ready
 */
function builderMapsPro_get_styles( callback ) {
	if ( map_styles === null ) {
		$.ajax( {
			url : themifyBuilder.ajaxurl,
			dataType: 'json',
			type: 'POST',
			data: {
				action: 'tb_get_maps_pro_styles',
				tb_load_nonce: themifyBuilder.tb_load_nonce,
			},
			success : function( response ) {
				map_styles = response;
				callback();
			}
		} );
	} else {
		callback();
	}
}

let is_loaded = null;
tb_app.Constructor['map_pro'] = {
	render:function(data, self){
		if(is_loaded===null){
			is_loaded=true;
			top_window.Themify.LoadCss(builderMapsPro.admin_css,builderMapsPro.v);
		}
		const $lightbox = ThemifyBuilderCommon.Lightbox.$lightbox,
			preview = document.createElement('div'),
			canvas = document.createElement('div'),
			description = document.createElement('div');
			preview.id='map-preview';
			canvas.id='map-canvas';
			description.className='tb_group_element_static';
			description.textContent = data.help;
			preview.appendChild(canvas);
			preview.appendChild(self.create([data.options]));
			preview.appendChild(description);

		   $lightbox
				.on( 'change.map_pro', '#map_center, #zoom_map, #type_map, #style_map, #disable_map_ui, #map_polyline, #map_polyline_geodesic, #map_polyline_stroke, #map_polyline_color', function(e){
						if(! e.isTrigger || $( '#map_polyline_color', top_iframe ).is( e.target ) ){
								builderMapsPro_update_map_preview();
					}
				} )
			.on( 'change.map_pro', '#markers .tb_lb_option_child', function(){
				const row = $( this ).closest( '.tb_repeatable_field' ),
					index = ( row.data( 'marker_index' ) === undefined ) ? markers.length : row.data( 'marker_index' );
					row.attr( 'data-marker_index',index); 
					// make sure it's removed first
					builderMapsPro_remove_marker( index );
					markers[index] = builderMapsPro_add_new_marker( row.find( '.address .tb_lb_option_child' ).val(), row.find( '.title .tb_lb_option_child' ).val(), row.find( '.image .tb_lb_option_child' ).val(), index, row );
			} )
			.on( 'click.map_pro', '#markers .tb_delete_row', function(){
				builderMapsPro_remove_marker( $( this ).closest( '.tb_repeatable_field' ).data( 'marker_index' ) );
			} );
			Themify.body.one('themify_builder_lightbox_close',function(e){
				$lightbox.off('.map_pro');
				map=poly=geo=null;
				markers = [];
			});
			setTimeout(function(){
				if (typeof top_window.google !== 'object' || top_window.google===null) {
					top_window.Themify.LoadAsync('//maps.google.com/maps/api/js?v=3.exp&key='+builderMapsPro.key, function(){
						const interval = setInterval(function(){
							if(typeof top_window.google === 'object' && top_window.google!==null && typeof top_window.google.maps === 'object'){

								clearInterval(interval);
								builderMapsProInit();
							}
						},300);
					},false, '3', function(){
						return typeof top_window.google === 'object' && top_window.google!==null && typeof top_window.google.maps === 'object';
					});
				} else {
					builderMapsProInit();
				}
			},10);
			return preview;
	}  
};
	
}( jQuery ));
