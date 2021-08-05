<?php
/**
 * Create the options page for the Event Posts plugin
 *
 * @since 1.0.0
 */
class Themify_Event_Post_Admin {

	var $options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'setup_options_page' ), 100 );
		add_action( 'admin_init', array( $this, 'page_init' ) );
		add_action( 'updated_option', array( $this, 'updated_option' ), 10, 3 );
	}

	public function setup_options_page() {
		add_submenu_page( 'edit.php?post_type=event', __( 'Event Settings', 'themify-event-post' ), __( 'Event Settings', 'themify-event-post' ), 'manage_options', 'themify-event-post', array( $this, 'create_admin_page' ) );
	}

	public function create_admin_page() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Themify Event Post', 'themify-event-post' ); ?></h2>           
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'themify_event_post' );   
				do_settings_sections( 'themify-event-post' );
				submit_button(); 
				?>
			</form>
		</div>
		<?php
    }
	
	/**
	 * Register and add settings
	 */
	public function page_init() {        
		register_setting(
			'themify_event_post', // Option group
			'themify_event_post' // Option name
		);

		add_settings_section(
			'themify_event_post_integration', // ID
			__( 'Integration', 'themify-event-post' ), // Title
			null, // Callback
			'themify-event-post' // Page
		);
		add_settings_section(
			'themify_event_post_permalink', // ID
			__( 'Permalink', 'themify-event-post' ), // Title
			null, // Callback
			'themify-event-post' // Page
		);

		add_settings_field(
			'google_maps_key', // ID
			__( 'Google Maps API Key', 'themify-event-post' ), // Title 
			array( $this, 'google_maps_key_callback' ), // Callback
			'themify-event-post', // Page
			'themify_event_post_integration' // Section
		);

		add_settings_field(
			'single_permalink', // ID
			__( 'Single Permalink', 'themify-event-post' ), // Title 
			array( $this, 'single_permalink_callback' ), // Callback
			'themify-event-post', // Page
			'themify_event_post_permalink' // Section
		);

		add_settings_field(
			'category_permalink', // ID
			__( 'Category Permalink', 'themify-event-post' ), // Title 
			array( $this, 'category_permalink_callback' ), // Callback
			'themify-event-post', // Page
			'themify_event_post_permalink' // Section
		);
    }

	public function google_maps_key_callback() {
		$value = Themify_Event_Post::get_instance()->get_option( 'google_maps_key' );
		printf(
			'<input type="text" class="regular-text" id="title" name="themify_event_post[google_maps_key]" value="%s" />',
			$value
		);
		printf( '<p class="description">' . __( '<a href="https://developers.google.com/maps/documentation/javascript/get-api-key#key" target="_blank">Generate an API</a> key and insert it here. This is required for displaying the event location on a map.', 'themify-event-post' ) . '</p>');
	}

	public function single_permalink_callback() {
		$value = Themify_Event_Post::get_instance()->get_option( 'single_permalink', 'event' );
		printf(
			'<input type="text" class="regular-text" id="title" name="themify_event_post[single_permalink]" value="%s" />',
			$value
		);
	}

	public function category_permalink_callback() {
		$value = Themify_Event_Post::get_instance()->get_option( 'category_permalink', 'event-category' );
		printf(
			'<input type="text" class="regular-text" id="title" name="themify_event_post[category_permalink]" value="%s" />',
			$value
		);
	}

	/**
	 * Callback for after plugin's options are saved
	 *
	 * Resets the permalinks to save new rewrite slug
	 *
	 * @since 1.0.0
	 */
	function updated_option( $option_name, $old_value, $value ) {
		if ( $option_name === 'themify_event_post' ) {
			/* re-register the post type to set the new rewrite slug */
			themify_event_post_register_post_type();
			/* flush permalinks to save the new rewrite slug */
			flush_rewrite_rules();
		}
	}
}
