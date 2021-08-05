var ThemifyMapsProInit;
(function ($, Themify) {
    'use strict';
    let geo = null,
        isInit=null;
    const addRessCache = [],
    result = function (address,data) {
        if (addRessCache[address] === undefined) {
            addRessCache[address] = data;
        }
        return data;
    },
    resolve_address = async function (address) {
        if (address === null || address.trim() === '') {
            return null;
        }
        if (addRessCache[address] !== undefined) {
            return result(address,addRessCache[address]);
        }
        const position = address.match(/^([-+]?[1-8]?\d(\.\d+)?|90(\.0+)?),?\s*([-+]?180(\.0+)?|[-+]?((1[0-7]\d)|([1-9]?\d))(\.\d+)?)(,\d+z)?$/);/* matches a valid lat/long value */
	
        if (Array.isArray(position)) {
            return result(address,new google.maps.LatLng(position[1], position[4]));
        } else {
            return new Promise(function(resolve, reject) {
                    geo.geocode({'address': address}, function (results, status) {
                            if (status === google.maps.GeocoderStatus.OK) {
                                    return resolve(result(address,results[0].geometry.location));
                            }
                            return reject('Couldnt\'t find the location ' + address);
                    });
            });
        }
    },
    Init = function(el) {
        const g=google.maps;
        if(geo===null){
            geo = new g.Geocoder();
        }
        const items = Themify.selectWithParent('module-maps-pro',el);
        for(let i=items.length-1;i>-1;--i){
            let item=items[i],
                canvas=item.getElementsByClassName('maps-pro-canvas')[0];
            if (canvas===undefined) {
                continue;
            }
            let config = {
                        'zoom'           :null,
                        'type'           : null,
                        'address'        : null,
                        'width'          : null,
                        'height'         : null,
                        'style_map'      : null,
                        'scrollwheel'    : null,
                        'polyline'       : null,
                        'geodesic'       : null,
                        'polylinestroke' :null,
                        'polylinecolor'  : null,
                        'draggable'      : null,
                        'disable_map_ui' :null
                },
                map_options = {};
                for(let j in config){
                    config[j] = item.getAttribute('data-'+j);
                }
                
                map_options.zoom = parseInt(config.zoom);
                map_options.center = new g.LatLng(-34.397, 150.644);
                map_options.mapTypeId = g.MapTypeId[ config.type ];
                map_options.scrollwheel = config.scrollwheel === 'enable';
                map_options.draggable = config.draggable === 'enable';
                map_options.disableDefaultUI = config.disable_map_ui === 'yes';
				const trigger = ( item.getAttribute( 'data-trigger' ) === 'hover' && ! Themify.isTouch ) ? 'mouseenter' : 'click';
                if (config.style_map !== '' && typeof map_pro_styles !== 'undefined') {
                    map_options.styles = map_pro_styles[config.style_map];
                }
                if (typeof builderMapsPro !== 'undefined' && builderMapsPro.styles) {
                    map_options.styles = builderMapsPro.styles[ config.style_map ];
                }
                
                let map = new g.Map(canvas, map_options),
                    poly = false;

                if (config.polyline === 'yes') {
                    let polylineColor = '#FF0000',
                        polylineOpacity = 1;
                    if (config.polylinecolor!=='' && config.polylinecolor!==null) {
                        let colorArr = config.polylinecolor.split('_');
                        polylineColor = colorArr[0];
                        colorArr.length > 1 && (polylineOpacity = colorArr[1]);
                    }
                    poly = new g.Polyline({
                        geodesic: config.geodesic === 'yes',
                        strokeColor: polylineColor,
                        strokeOpacity: polylineOpacity,
                        strokeWeight: config.polylinestroke || 2
                    });

                    poly.setMap(map);
                }
               // node.data('gmap_object', map);
				const markers = item.getElementsByClassName( 'maps-pro-marker' );
				if ( config.address === '' && markers.length ) {
					// center the map on first marker
					config.address = markers[0].getAttribute( 'data-address' );
				}
                resolve_address(config.address).
				then(function(position){
					if(position){
						map.setCenter(position);
						for(let k=markers.length-1;k>-1;--k){
							let m=markers[k];
							Themify.requestIdleCallback(function(){
								resolve_address(m.getAttribute('data-address')).then(function(pos){
									if(pos){
										const marker = new g.Marker({
											map: map,
											position: pos,
											icon: m.getAttribute('data-image')
										}),
										title=m.innerHTML.trim();

										if (title !== '') {
											const isActive=Themify.is_builder_active===true?' contenteditable="false" data-repeat="markers" data-name="title" data-no-update data-index="'+k+'"':'',
											infowindow = new g.InfoWindow({
												content: '<div class="maps-pro-content"'+isActive+'>' + title + '</div>'
											});
											g.event.addListener(marker, trigger, function () {
												infowindow.open(map, marker);
											});
										}
										if (poly) {
											poly.getPath().push(marker.getPosition());
										}
									}
								});
							},400);
						}
					}
				});
                
        }
    };
	ThemifyMapsProInit=function(){
        isInit=true;
        Themify.trigger('themify_google_map_pro_loaded');
    };
    if (!Themify.is_builder_active) {
        /* reload the map when switching tabs (Builder Tabs module) */
        Themify.on('tb_tabs_switch', function (activeTab, menu,id) {
            $(activeTab).find('.module-maps-pro').each(function () {
                const mapInit = $(this).find('.map-container').data('gmap_object'),
                    center = mapInit.getCenter();
                google.maps.event.trigger(mapInit, 'resize');
                mapInit.setCenter(center);
            });
        });
    }
    Themify.on( 'builder_load_module_partial',function(el,type,isLazy){
        if(isLazy===true && !el[0].classList.contains('module-maps-pro')){
            return;
        }
		const items = Themify.selectWithParent('module-maps-pro',el);
		if(items.length>0){
			Themify.requestIdleCallback(function(){
				if (isInit===null && (!window['google'] || typeof window['google'].maps !== 'object')) {
					if (!themify_vars.map_key) {
							themify_vars.map_key = '';
					}
					Themify.LoadAsync('//maps.googleapis.com/maps/api/js', function(){
							if(isInit===true){
									Init(el);
							}
							else{
								if(window['google'] && typeof window['google'].maps === 'object'){
									Init(el);
								}
								else{
									Themify.on('themify_google_map_pro_loaded',function(){
										Init(el);
									},true);
								}
							}
					}, 'v=3.exp&callback=ThemifyMapsProInit&key=' + themify_vars.map_key, null, function () {
						return  !!window['google'] && typeof window['google'].maps === 'object';
					});
				}
				else{
					isInit=true;
					Init(el);
				}
			},100);
		}
    });

})(jQuery,Themify);