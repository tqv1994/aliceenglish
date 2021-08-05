(function ($,Themify) {
    'use strict';
    const args=tbLocalScript['addons']['pro-slider'],
    loaded={},
    v='1.2.1',
    _click=function(e){
		e.preventDefault();
		const slider = $(this.closest('.slider-pro')).data('sliderPro'),
			action = this.getAttribute('href')==='#next-slide'? 'nextSlide' :'previousSlide';
		typeof slider === 'object' && slider[action].call(slider);
    },
    _lazyLoading=function(el,self){
            const div=el.getElementsByClassName('bsp_frame')[0];
				if(el.hasAttribute('data-bg')){
						el.style['backgroundImage']='url('+el.getAttribute('data-bg')+')';
						el.removeAttribute('data-bg');
				}
            if(div){
                    const url = div.getAttribute('data-url'),
					attr = Themify.parseVideo(url),
                            iframe = document.createElement('iframe');
                    let src = '',
                            allow='';

                    if(attr.type==='youtube'){
                                    src = 'https://www.youtube.com/embed/'+attr.id+'?autohide=1&border=0&wmode=opaque';
                                    allow='accelerometer;encrypted-media;gyroscope;picture-in-picture';
                    }
                    else {
                                    src='//player.vimeo.com/video/'+attr.id+'?portrait=0&title=0&badge=0';
                                    allow='fullscreen';
                    }
				let queryStr=url.split('?')[1];
				const params=queryStr?new URLSearchParams(queryStr):false;
				if(params && params.get('autoplay')){
					src+='&autoplay=1';
					allow+=';autoplay';
				}
                    iframe.className='tf_abs tf_w tf_h sp-video';
                    iframe.setAttribute('allowfullscreen', '');
                    iframe.setAttribute('allow', allow);
                    iframe.setAttribute('src', src);
                    div.parentNode.replaceChild(iframe,div);
            }
			else{
				const video=el.getElementsByTagName('video')[0];
				if(video){
					if(video.preload==='none'){
						video.addEventListener('canplay',function(){
							if(this.paused){
								this.play();
							}
						},{passive:true,once:true});
                        if(self.options.autoplay===true && self.isTimerRunning===true){
                            video.addEventListener('ended',function(){
                                if ( self.settings.autoplayDirection === 'normal' ){
                                    self.nextSlide();
                                }
								else if ( self.settings.autoplayDirection === 'backwards' ){
                                    self.previousSlide();
                                }
                            },{passive:true});
                        }
						video.setAttribute('preload','metadata');
						video.setAttribute('autoplay','autoplay');
					}
					else if(video.paused){
						video.play();
					}
				}
			}
    },
    callback = function (items) {
        for(let i=items.length-1;i>-1;--i){
            Themify.imagesLoad(items[i],function(instance){
				const item=instance.elements[0],
					sw=item.getAttribute('data-slider-width'),
					sh=item.getAttribute('data-slider-height'),
					autoPlay=item.getAttribute('data-autoplay'),
					tw=item.getAttribute('data-thumbnail-width'),
					th=item.getAttribute('data-thumbnail-height'),
                    pasue_last=item.getAttribute('data-pause-last')==='1',
					config = {
						slideDistance : 0,
						buttons:!item.classList.contains('pager-none') && !item.classList.contains('pager-type-thumb'),
						arrows:true,
						loop:item.getAttribute('data-loop')==='1',
						responsive:true,
						autoHeightOnReize:true,
						autoHeight:false,
						thumbnailTouchSwipe:true,// this is required for the thumbnail click action to work
						thumbnailWidth:tw?parseFloat(tw):'',
						thumbnailHeight:th?parseFloat(th):'',
						timer_bar:item.getAttribute('data-timer-bar') === 'yes',
						autoplayDelay:autoPlay && autoPlay!=='off'?parseFloat(autoPlay):5000,
						autoplay:autoPlay!=='off',
                        autoScaleLayers:false,
						autoplayOnHover:item.getAttribute('data-hover-pause'),
						width:sw && sw !== '100%'? parseInt(sw):'100%', // set default slider width to 100%
						fadeOutPreviousSlide:false,
						touchSwipe:( Themify.isTouch && item.getAttribute('data-touch-swipe-mobile' ) === 'yes' ) || ( ! Themify.isTouch && item.getAttribute('data-touch-swipe-desktop' ) === 'yes' ),
						gotoSlide(e){
							if(e.index===this.slides.length-1 && this.options.autoplay===true && pasue_last && this.options.loop===false){
                                this.stopAutoplay();
                            }
						    for(let j=0;j<2;++j){
								let index=e.index+j,
									el=this.getSlideAt(index);
								if(el){
									el=el.$slide[0];
									if(el){
										_lazyLoading(el,this);
									}
								}
							}
						},
						init() {
							_lazyLoading(this.getSlideAt(0).$slide[0],this);
							const el=this.instance,
								buttons=el.getElementsByClassName('bsp-slide-button');
							for(let j=buttons.length-1;j>-1;--j){
								let href=buttons[j].getAttribute('href');
								if(href==='#next-slide' || href==='#prev-slide'){
									buttons[j].addEventListener('click',_click);
								}
							}
							el.classList.remove('tf_hidden','tf_lazy');
							el.classList.add('tf_bsp_ready');
						}
					};
					if ( sh === '' ) {
						config.aspectRatio = 1.9;
					} else {
						config.height = sh;
					}

				$(instance.elements[0].getElementsByClassName('slider-pro')[0]).sliderPro(config);
            });
        }
    },
    check=function(items){
        if(loaded['imageloaded']===true && loaded['sliderPro']===true){
            callback(items);
        }
    },
    init = function (el) {
        const items = Themify.selectWithParent('module-pro-slider',el);
        if (items.length > 0) {
            const css={
                    'button':'bsp-slide-button',
                    'excerpt':'bsp-slide-excerpt',
                    'image':'sp-slide-image',
                    'video':'sp-video',
                    'thumbnails':'sp-thumbnail'
                },
                needToLoad={},
                callback=function(){
                    if(loaded['sliderPro']===true){
                            const proModules=args.url+'sliderpro/',
                            checkModules=function(){
                                    let allLoaded =true;
                                    for(let k in needToLoad){
                                            if(loaded[k]!==true){
                                                    allLoaded=false;
                                                    break;
                                            }
                                    }
                                    if(allLoaded===true){
                                            check(items);
                                    }
                            };
                            for(let k in needToLoad){
                                    if(loaded[k]===undefined && k.indexOf('css_')===-1){
                                            Themify.LoadAsync(proModules + k+'.js', function () {
                                                    loaded[k]=true;
                                                    checkModules(items);
                                            }, v, null, function () {
                                                    return !!loaded[k];
                                            });
                                    }
                            }
                            checkModules(items);
                    }
                };
            for(let i=items.length-1;i>-1;--i){
                if(( Themify.isTouch && items[i].getAttribute('data-touch-swipe-mobile' ) === 'yes' ) || ( ! Themify.isTouch && items[i].getAttribute('data-touch-swipe-desktop' ) === 'yes' )){
                    if(!loaded['touchSwipe']){
                        needToLoad['touchSwipe']=true;
                    }
                }
                for(let k in css){
                    if(items[i].getElementsByClassName(css[k])[0]){
                        if(!Themify.cssLazy['bsp_'+k]){
							needToLoad['css_'+k]=true;
							let m=k==='video'?k+'.min':k;
							Themify.LoadCss(args.url + 'modules/'+m+'.css',args.ver,null,null,function(){
								loaded['css_'+k]=true;
								Themify.cssLazy['bsp_'+k]=true;
								callback();
							});
						}
                        if(k==='video' || k==='thumbnails'){
                            if(!loaded[k]){
                                needToLoad[k]=true;
                            }
                            if(k==='thumbnails' && (!loaded['thumbnailtouchSwipe'] && (needToLoad['touchSwipe']===true || loaded['touchSwipe']===true))){
                               needToLoad['thumbnailtouchSwipe']=true;
                            }
                        }
                    }
                }
            }
            if(!loaded['imageloaded']){
                Themify.imagesLoad(function(){
                    loaded['imageloaded']=true;
                    callback();
                });
            }
            if(!loaded['twoSlidesFixer'] && items.length===2){
                needToLoad['twoSlidesFixer']=true;
            }
            if(!loaded['sliderPro']){
                Themify.LoadAsync(args.url + 'jquery.sliderPro.js', function () {
                    loaded['sliderPro']=true;
                    callback();
                }, v, null, function () {
                        return 'undefined' !== typeof $.fn.sliderPro;
                });
            }
            else{
                callback();
            }
        }
    };
    if (Themify.is_builder_active) {
        Themify.body.on('tb_module_sort tb_grid_changed', function(e,el){
            init(el);
        });
    }
    Themify.on('builder_load_module_partial', function ( el, type,isLazy) {
        if(isLazy===true && !el[0].classList.contains('module-pro-slider')){
            return;
        }
        init(el);
    });
}(jQuery,Themify));
