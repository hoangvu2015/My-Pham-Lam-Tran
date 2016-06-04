/**
 * Created by Nguyen Tuan Linh on 2015-11-04.
 */

CKEDITOR.editorConfig = function (config) {
    config.extraPlugins = 'videodetector';
    // Toolbar configuration generated automatically by the editor based on config.toolbarGroups.
    config.toolbar = [
        ['FontSize'],
        ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
        ['TextColor', 'BGColor'],
        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
        ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote'],
        ['Maximize', 'ShowBlocks'],
        ['Source'],
        // ['Find', 'Replace', '-', 'SelectAll', '-', 'RemoveFormat'],
        '/',
        // ['Styles', 'Format', 'Font', 'FontSize'],
        ['Link', 'Unlink'],
        ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'],
        // ['Link', 'Unlink', 'Anchor'],
        ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'Iframe', 'VideoDetector'],
        
    ];
};
