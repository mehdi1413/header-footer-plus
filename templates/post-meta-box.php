<?php defined( 'ABSPATH' ) || exit; ?>
<div class="inside">
    <table width="100%">
        <tr>
            <td valign="middle">
                <label for="hfp_header_hide">
                    <input type="checkbox" <?php echo checked( esc_attr( $hide_header ), 'on', false );?> name="hfp_header_hide" id="hfp_header_hide"/>Hide from header
                </label>
            </td>
            <td valign="top">
                <p>
                    <label for="hfp_header">add script / style to be added to the header of the page</label>
                    <textarea style="display:block;width:100%;min-height:150px;direction:ltr" id="hfp_header" name="hfp_header" size="25"><?php echo wp_kses( $header, $allowed_type);?></textarea>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="middle">
                <label for="hfp_footer_hide">
                    <input type="checkbox" <?php echo checked( esc_attr($hide_footer), 'on', false );?> name="hfp_footer_hide" id="hfp_footer_hide"/>Hide from footer
                </label>
            </td>
            <td valign="top">
                <p>
                    <label for="hfp_footer">add script to be added to the footer of the page before the (e.g Google Re-Marketing / Google Conversion )</label>
                    <textarea style="display:block;width:100%;min-height:150px;direction:ltr" id="hfp_footer" name="hfp_footer" size="25"><?php echo wp_kses( $footer, $allowed_type);?></textarea>
                </p>
                <p>You should put the code with the script tags<code>&lt;script type='text/javascript'&gt; the code &lt;/script&gt;</code>
                </p>
            </td>
        </tr>
    </table>
</div>