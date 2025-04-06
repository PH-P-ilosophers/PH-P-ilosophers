<div class="top-bar">
	<div class="top-bar-wrapper">
		<div class="login-wrapper">
			
			<?php 
				if ( is_user_logged_in() ) { 
				?>
				
					<a class = "logout-button" href = "<?php echo wp_logout_url(); ?>">Logout</a>

				<?php 
				} else { 
				?>

					<a class = "login-button" href = "<?php echo esc_url(site_url('../../wp-login.php')) ?>">Login</a>
					<a class = "signup-button" href = "<?php echo esc_url(site_url('../../wp-signup.php')) ?>">Sign Up</a>

				<?php
				}
			?>
			
		</div>
		<?php $description = get_bloginfo( 'description', 'display' );

		if ( $description || is_customize_preview() ) : ?>
			<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
		<?php endif; ?>

		<?php karuna_social_menu(); ?>
		
	</div><!-- .top-bar-wrapper -->
</div><!-- .top-bar -->