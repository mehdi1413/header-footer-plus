jQuery(document).ready(function ($) {
    if (window.wp && wp.codeEditor) {
        let header_editor = $('#hfp_header_textarea');
        let footer_editor = $('#hfp_footer_textarea');
        if (header_editor) {
            wp.codeEditor.initialize(header_editor, hpf_code_mirror);
        }
        if (footer_editor) {
            wp.codeEditor.initialize(footer_editor, hpf_code_mirror);
        }
    }
});