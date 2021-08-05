<?php

class Builder_Contact_Admin {

	public function __construct() {
		add_action( 'admin_menu', array( __CLASS__, 'setup_options' ), 100 );
		add_action( 'admin_init', array( __CLASS__, 'page_init' ) );
	}

	public static function setup_options() {
		add_submenu_page(
			'edit.php?post_type=contact_messages',
			__( 'Captcha Settings', 'builder-contact' ),
			__( 'Captcha Settings', 'builder-contact' ),
			'manage_options',
			'builder-contact',
			array( __CLASS__, 'create_admin_page' )
		);

	}

    public static function create_admin_page() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Builder Contact Captcha', 'builder-contact' ); ?></h2>
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'builder_contact' );   
				do_settings_sections( 'builder-contact' );
				self::show_recaptcha_guide();
				submit_button(); 
				?>
			</form>
		</div>
		<?php
    }

	/**
	 * Register and add settings
	 */
	public static function page_init() {        
		register_setting(
			'builder_contact', // Option group
			'builder_contact' // Option name
		);

		add_settings_section(
			'builder-contact-recaptcha', // ID
			__( 'reCAPTCHA Settings', 'builder-contact' ), // Title
			null, // Callback
			'builder-contact' // Page
		);

		add_settings_field(
			'recapthca_version', // ID
			__( 'ReCaptcha Version', 'builder-contact' ), // Title
			array( __CLASS__, 'recapthca_version_callback' ), // Callback
			'builder-contact', // Page
			'builder-contact-recaptcha' // Section
		);

		add_settings_field(
			'recapthca_public_key', // ID
			__( 'ReCaptcha Public Key', 'builder-contact' ), // Title 
			array( __CLASS__, 'recapthca_public_key_callback' ), // Callback
			'builder-contact', // Page
			'builder-contact-recaptcha' // Section           
		);

		add_settings_field(
			'recapthca_private_key', // ID
			__( 'ReCaptcha Private Key', 'builder-contact' ), // Title 
			array( __CLASS__, 'recapthca_private_key_callback' ), // Callback
			'builder-contact', // Page
			'builder-contact-recaptcha' // Section           
		);
    }

	public function recapthca_version_callback() {
		$value = Builder_Contact::get_option( 'recapthca_version','v2' );
		$selected = ' selected="selected"';
	    $options = sprintf(
			'<option value="v2"%s>%s</option><option value="v3"%s>%s</option>'
			,'v2' === $value ? $selected : ''
            ,__('Version 2','builder-contact')
			,'v3' === $value ? $selected : ''
			,__('Version 3','builder-contact')
            );
	    printf(
			'<select class="regular-text" id="version" name="builder_contact[recapthca_version]">%s</select>',
			$options
		);
	}

	public function recapthca_public_key_callback() {
		printf(
			'<input type="text" class="regular-text" id="title" name="builder_contact[recapthca_public_key]" value="%s" />',
			esc_attr( Builder_Contact::get_option( 'recapthca_public_key' ) )
		);
	}

	public static function recapthca_private_key_callback() {
		printf(
			'<input type="text" class="regular-text" id="title" name="builder_contact[recapthca_private_key]" value="%s" />',
			esc_attr( Builder_Contact::get_option( 'recapthca_private_key' ) )
		);
	}

	private static function show_recaptcha_guide() { ?>
		<h3><?php _e( 'To set up your Captcha:', 'builder-contact' ); ?></h3>
		<p><?php printf( __( 'Go to <a href="%s">reCAPTCHA Admin Console</a> to create API keys for your domain. A Google account is required.', 'builder-contact' ), 'https://www.google.com/recaptcha/admin' ); ?></p>
		<p><?php _e( 'On the register a new site box, enter the Domains that you would like the reCaptcha form to appear (your website\'s URL address), then copy the ReCaptcha Public Key and the Secret key to this page.', 'builder-contact' ); ?></p>
	<?php }
}
