<?php defined( 'ABSPATH' ) || exit; ?>
<tr class="form-field term-group-wrap">
    <th scope="row">
        <label for="hfp_tax_header_hide">Hide header script</label>
    </th>
    <td>
        <input type="checkbox" <?php echo checked( esc_attr( $hide_header ), 'on', false );?> name="hfp_tax_header_hide" id="hfp_tax_header_hide" title="active equal hide script"/>
    </td>
</tr>
<tr class="form-field term-group-wrap">
    <th scope="row">
        <label for="hfp_tax_footer_hide">Hide footer script</label>
    </th>
    <td>
        <input type="checkbox" <?php echo checked( esc_attr( $hide_footer ), 'on', false );?> name="hfp_tax_footer_hide" id="hfp_tax_footer_hide" title="active equal hide script"/>
    </td>
</tr>
<tr class="form-field term-group-wrap">
    <th scope="row">
        <label for="hfp_tax_header">Custom header script</label>
    </th>
    <td>
        <textarea class="large-text" cols="50" rows="5" id="hfp_tax_header" name="hfp_tax_header" style="direction:ltr"><?php echo wp_kses( $header, $allowed_type ); ?></textarea>
    </td>
</tr>
<tr class="form-field term-group-wrap">
    <th scope="row">
        <label for="hfp_tax_footer">Custom footer script</label>
    </th>
    <td>
        <textarea class="large-text" cols="50" rows="5" id="hfp_tax_footer" name="hfp_tax_footer" style="direction:ltr"><?php echo wp_kses( $footer, $allowed_type ); ?></textarea>
    </td>
</tr>