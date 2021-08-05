(function($) {
	'use strict';

	if( typeof themifyEventPostsMCE !== 'object' )
		return;

	$( '<script type="text/html" id="tmpl-themify-event-post-shortcode">' + themifyEventPostsMCE.template + '</script>' ).appendTo( 'body' );

	tinymce.PluginManager.add( 'btnthemifyEventPosts', function( editor, url ) {

		editor.addButton( 'btnthemifyEventPosts', {
			title: themifyEventPostsMCE.labels.menuName,
			onclick: function(){
				var fields = [];
				jQuery.each( themifyEventPostsMCE.fields, function( i, field ){
					if( field.type == 'colorbox' ) {
						field.onaction = createColorPickAction()
					}
					fields.push( field );
				} );

				editor.windowManager.open({
					'title' : themifyEventPostsMCE.labels.menuName,
					'body' : fields,
					onSubmit : function( e ){
						var values = this.toJSON(); // get form field values
						values.selectedContent = editor.selection.getContent();
						var template = wp.template( 'themify-event-post-shortcode' );
						editor.insertContent( template( values ) );
					}
				});
			}
		});
	});
})(jQuery);