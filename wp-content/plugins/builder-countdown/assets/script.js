/*rendro/countdown*/
(function(Themify){
    'use strict';
	const defaultOptions={date:'June 7, 2087 15:03:25',refresh:1e3,offset:0,onEnd(){},render(t){this.el.innerHTML=t.years+" years, "+t.days+" days, "+this.leadingZeros(t.hours)+" hours, "+this.leadingZeros(t.min)+" min and "+this.leadingZeros(t.sec)+" sec"}},Countdown=function(t,i){this.el=t,this.options={},this.interval=!1,this.mergeOptions=function(t){for(var i in defaultOptions)defaultOptions.hasOwnProperty(i)&&(this.options[i]=void 0!==t[i]?t[i]:defaultOptions[i],"date"===i&&"object"!=typeof this.options.date&&(this.options.date=new Date(this.options.date)),"function"==typeof this.options[i]&&(this.options[i]=this.options[i].bind(this)));"object"!=typeof this.options.date&&(this.options.date=new Date(this.options.date))}.bind(this),this.mergeOptions(i),this.getDiffDate=function(){var t=(this.options.date.getTime()-Date.now()+this.options.offset)/1e3,i={years:0,days:0,hours:0,min:0,sec:0,millisec:0};return t<=0?this.interval&&(this.stop(),this.options.onEnd()):(31557600<=t&&(i.years=Math.floor(t/31557600),t-=365.25*i.years*86400),86400<=t&&(i.days=Math.floor(t/86400),t-=86400*i.days),3600<=t&&(i.hours=Math.floor(t/3600),t-=3600*i.hours),60<=t&&(i.min=Math.floor(t/60),t-=60*i.min),i.sec=Math.round(t),i.millisec=t%1*1e3),i}.bind(this),this.leadingZeros=function(t,i){return i=i||2,(t=String(t)).length>i?t:(Array(i+1).join("0")+t).substr(-i)},this.update=function(t){return"object"!=typeof t&&(t=new Date(t)),this.options.date=t,this.render(),this}.bind(this),this.stop=function(){return this.interval&&(clearInterval(this.interval),this.interval=!1),this}.bind(this),this.render=function(){return this.options.render(this.getDiffDate()),this}.bind(this),this.start=function(){if(!this.interval)return this.render(),this.options.refresh&&(this.interval=setInterval(this.render,this.options.refresh)),this}.bind(this),this.updateOffset=function(t){return this.options.offset=t,this}.bind(this),this.restart=function(t){return this.mergeOptions(t),this.interval=!1,this.start(),this}.bind(this),this.start()};	
	Themify.on( 'builder_load_module_partial',function(el,type,isLazy){
		if(isLazy===true && !el[0].classList.contains('module-countdown')){
			return;
		}
		const items = Themify.selectWithParent('builder-countdown-holder',el);
		for(let i=items.length-1;i>-1;--i){
			let data = items[i].getAttribute( 'data-target-date' );
			if(data){
				new Countdown(items[i],{
						date : new Date( data * 1000 ),
						render( data ){
								const texts = this.el.getElementsByClassName('date-counter');
								for(let j=texts.length-1;j>-1;--j){
									let cl=texts[j].parentNode.classList,
										text='';
									if(cl.contains('years')){
										text=this.leadingZeros( data.years, 2 );
									}
									else if(cl.contains('days')){
										text=this.leadingZeros( data.days, 2 );
									}
									else if(cl.contains('hours')){
										text=this.leadingZeros( data.hours, 2 );
									}
									else if(cl.contains('minutes')){
										text=this.leadingZeros( data.min, 2 );
									}
									else if(cl.contains('seconds')){
										text=data.sec?this.leadingZeros( data.sec, 2 ):'00';
									}
									texts[j].textContent=text;
								}
						},
						onEnd(){
							 if (!Themify.is_builder_active && this.el.getAttribute( 'data-target-refresh' ) !== 'y') {
								window.location.reload();
							}
						}
				});
			}
		}
    });

})( Themify );