<?php defined( 'ABSPATH' ) || exit; ?>
<div class="wrap">
    <h2>header & footer plus settings</h2>
    <form action="options.php" method="post">
		<?php
		settings_fields( 'hfp_option_group' );
		do_settings_sections( 'hfp-settings' );
		submit_button(); ?>
    </form>
</div>