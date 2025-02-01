<?php defined( 'ABSPATH' ) || exit; ?>
<div class="inside">
	<table width="100%">
		<tr>
			<td valign="middle">
				<label for="hfp_header_hide">
					<input type="checkbox"
					       <?php echo checked( $hide_header, 'on', false ) ?>name="hfp_header_hide"
					       id="hfp_header_hide"/>Hide from header
				</label>
			</td>
			<td valign="top">
				<p>
					<label for="hfp_header"><?php _e( "add script / style to be added to the header of the page", 'oh_add_script' ); ?></label>
					<textarea style="display:block;width:100%;min-height:150px;direction:ltr" id="hfp_header"
					          name="hfp_header" size="25"><?php echo $header ?></textarea>
				</p>
			</td>
		</tr>
		<tr>
			<td valign="middle">
				<label for="hfp_footer_hide">
					<input type="checkbox" <?php echo checked( $hide_footer, 'on', false ) ?>
					       name="hfp_footer_hide"
					       id="hfp_footer_hide"/>Hide from footer
				</label>
			</td>
			<td valign="top">
				<p>
					<label for="hfp_footer">
						<?php _e( "add script to be added to the footer of the page before the </body> (e.g Google Re-Marketing / Google Conversion )", 'oh_add_script_footer' ); ?></label>
					<textarea style="display:block;width:100%;min-height:150px;direction:ltr" id="hfp_footer"
					          name="hfp_footer" size="25"><?php echo $footer ?></textarea>
				</p>
				<p><?php _e( "You should put the code with the script tags<code> &lt;script type='text/javascript'&gt; the code &lt;/script&gt;</code>", 'oh_add_script_footer' ); ?></p>
			</td>
		</tr>
	</table>
</div>