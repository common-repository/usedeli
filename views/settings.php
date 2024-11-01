<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="usedeli-header">
	<div class="usedeli-logo">
	<img src="<?php echo esc_url( usedeli_uri( 'assets/img/deli-logo.svg' ) ); ?>" alt="Usedeli">
	</div>
</div>

<?php
$usedeli_api          = get_option( 'usedeli_api' );
$usedeli_mls_id       = get_option( 'usedeli_mls_id' );
$usedeli_logo         = get_option( 'usedeli_logo' );
$usedeli_display_name = get_option( 'usedeli_display_name' );
$usedeli_display_on   = get_option( 'usedeli_display_on' );
$usedeli_post_ids     = get_option( 'usedeli_post_ids' );

if ( ! $usedeli_post_ids ) {
	$usedeli_post_ids = array();
}

// if logo contain http.
if ( strpos( $usedeli_logo, 'http' ) !== false ) {
	$usedeli_logo_url = $usedeli_logo;
} else {
	$usedeli_logo_url = wp_get_attachment_image_url( $usedeli_logo, 'full' );
}

$usedeli_color  = get_option( 'usedeli_color' ) ? get_option( 'usedeli_color' ) : '#0062FF';
$usedeli_status = get_option( 'usedeli_status' ) ? get_option( 'usedeli_status' ) : false;

// Registration url with UTM parameters
$registration_url = add_query_arg(
	array(
		'utm_source'   => 'deli',
		'utm_medium'   => 'plugin',
		'utm_campaign' => 'deli',
	),
	'https://usedeli.com/pricing'
);
?>
<div class="usedeli-wrapper">
	<form class="usedeli-form" id="usedeli-settings">
		<input type="hidden" name="action" value="usedeli_save_settings">
		<?php wp_nonce_field( 'usedeli', 'security' ); ?>
		<div class="usedeli-grid">
			<div class="usedeli-col-8">
				<div class="usedeli-box">
					<div class="usedeli-box__header">
						<?php echo esc_html__( 'Activation', 'usedeli' ); ?>
						<div class="usedeli-status loading">
							<?php echo esc_html__( 'Checking...', 'usedeli' ); ?>
						</div>
					</div>
					<div class="usedeli-box__body">
						<div class="usedeli-field">
							<label for="usedeli_api"><?php echo esc_html__( 'Widget key', 'usedeli' ); ?></label>
							<input type="text" id="usedeli_api" name="usedeli_api" value="<?php echo esc_attr( $usedeli_api ); ?>">
							<p class="usedeli-field__help"><?php echo wp_kses_post( __( 'Obtain your key and whitelist your domain in your <a href="https://chat.usedeli.com/" target="_blank">Deli dashboard</a>.', 'usedeli' ) ); ?></p>
						</div>
						<div class="usedeli-field">
							<label for="usedeli_mls_id"><?php echo esc_html__( 'MLS ID', 'usedeli' ); ?></label>
							<input type="text" id="usedeli_mls_id" name="usedeli_mls_id" value="<?php echo esc_attr( $usedeli_mls_id ); ?>">
							<p class="usedeli-field__help"><?php echo wp_kses_post( __( 'Type your MLS ID associated with your MLS membership.', 'usedeli' ) ); ?></p>

						</div>
					</div>
					<div class="usedeli-box__footer">
						<button type="submit" class="button button-primary usedeli-save">
							<?php echo esc_html__( 'Save Changes', 'usedeli' ); ?>
						</button>
					</div>
				</div>

				<div class="usedeli-box">
					<div class="usedeli-box__header">
						<?php echo esc_html__( 'Customization', 'usedeli' ); ?>
					</div>
					<div class="usedeli-box__body">
						<div class="usedeli-field">
							<label><?php echo esc_html__( 'Logo', 'usedeli' ); ?></label>
							<div class="usedeli-image-field">
								<div class="usedeli-image-field__preview">
									<?php if ( $usedeli_logo ) { ?>
										<img src="<?php echo esc_url( $usedeli_logo_url ); ?>" alt="">
									<?php } else { ?>
										<img src="<?php echo esc_url( usedeli_uri( 'assets/img/deli-logo.svg' ) ); ?>" alt="">
									<?php } ?>
								</div>
								<button class="button usedeli-upload">
									<?php echo esc_html__( 'Upload Image', 'usedeli' ); ?>
								</button>
								<input type="hidden" name="usedeli_logo" value="<?php echo esc_attr( $usedeli_logo ? absint( $usedeli_logo ) : '' ); ?>">
							</div>
						</div>
						<div class="usedeli-field">
							<label for="usedeli_color">
								<?php echo esc_html__( 'Branding Color', 'usedeli' ); ?>
							</label>
							<div class="usedeli-color-field">
								<div class="usedeli-color-field__preview" style="background-color: <?php echo esc_attr( $usedeli_color ); ?>;"></div>
								<input type="text" id="usedeli_color" class="usedeli-color" name="usedeli_color" value="<?php echo esc_attr( $usedeli_color ); ?>">
							</div>
						</div>
						<div class="usedeli-field">
							<label for="usedeli_display_name">
								<?php echo esc_html__( 'Display Name', 'usedeli' ); ?>
							</label>
							<input type="text" name="usedeli_display_name" id="usedeli_display_name" value="<?php echo esc_attr( $usedeli_display_name ? $usedeli_display_name : '' ); ?>">
							<p class="usedeli-field__help"><?php echo esc_html__( 'Enter a custom display name. Leave this field blank to use display name set in your Deli dashboard.', 'usedeli' ); ?></p>
						</div>
					</div>
					<div class="usedeli-box__footer">
						<button type="submit" class="button button-primary usedeli-save">
							<?php echo esc_html__( 'Save Changes', 'usedeli' ); ?>
						</button>
					</div>
				</div>
			</div>
			<div class="usedeli-col-4">
				<div class="usedeli-box">
					<div class="usedeli-box__header">
						<?php
						echo esc_html__( 'Don\'t Have an Account?', 'usedeli' );
						?>
					</div>

					<div class="usedeli-box__body">
						<p><?php echo esc_html__( 'Give your website visitors an all new search experience. Deli matches dream home descriptions with precision AI to help your site visitors find property in seconds.', 'usedeli' ); ?></p>
						<a href="<?php echo esc_url( $registration_url ); ?>" class="button button-primary"><?php echo esc_html__( 'Sign Up Now', 'usedeli' ); ?></a>
					</div>
				</div>
				<div class="usedeli-box">
					<div class="usedeli-box__header">
						<?php echo esc_html__( 'Display Rules', 'usedeli' ); ?>
					</div>
					<div class="usedeli-box__body">
						<div class="usedeli-field">
							<label for="usedeli_display_on"><?php echo esc_html__( 'Display Widget on', 'usedeli' ); ?></label>
							<select name="usedeli_display_on" id="usedeli_display_on">
								<option value="all" <?php selected( 'all', $usedeli_display_on ); ?>><?php echo esc_html__( 'Entire Site', 'usedeli' ); ?></option>
								<option value="front" <?php selected( 'front', $usedeli_display_on ); ?>><?php echo esc_html__( 'Front Page', 'usedeli' ); ?></option>
								<option value="specific" <?php selected( 'specific', $usedeli_display_on ); ?>><?php echo esc_html__( 'Specific Pages or Posts', 'usedeli' ); ?></option>
							</select>
						</div>

						<?php
						$pages = get_posts(
							array(
								'post_type'      => 'page',
								'post_status'    => 'publish',
								'posts_per_page' => -1,
							)
						);

						$posts = get_posts(
							array(
								'post_type'      => 'post',
								'post_status'    => 'publish',
								'posts_per_page' => -1,
							)
						);
						?>
						<div class="usedeli-field usedeli-field-post-ids">
							<label for="usedeli_post_ids"><?php echo esc_html__( 'Select Pages / Posts', 'usedeli' ); ?></label>
							<select name="usedeli_post_ids[]" id="usedeli_post_ids" multiple="multiple">
								<optgroup label="<?php echo esc_attr__( 'Pages', 'usedeli' ); ?>">
									<?php foreach ( $pages as $page ) { ?>
										<?php
										$selected = in_array( $page->ID, $usedeli_post_ids ) ? 'selected' : '';
										?>
										<option value="<?php echo esc_attr( $page->ID ); ?>" <?php echo $selected; ?>>
											<?php echo esc_attr( $page->post_title ); ?>
										</option>
									<?php } ?>
								</optgroup>
								<optgroup label="<?php echo esc_attr__( 'Posts', 'usedeli' ); ?>">
									<?php foreach ( $posts as $post ) { ?>
										<?php
										$selected = in_array( $post->ID, $usedeli_post_ids ) ? 'selected' : '';
										?>
										<option value="<?php echo esc_attr( $post->ID ); ?>" <?php echo $selected; ?>>
											<?php echo esc_attr( $post->post_title ); ?>
										</option>
									<?php } ?>
								</optgroup>
							</select>
						</div>
					</div>
					<div class="usedeli-box__footer">
						<button type="submit" class="button button-primary usedeli-save">
							<?php echo esc_html__( 'Save Changes', 'usedeli' ); ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>