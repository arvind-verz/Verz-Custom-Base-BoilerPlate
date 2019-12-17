/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

// CREATE SLUG
function slugify(text)
{
return text.toString().toLowerCase()
    .replace(/\s+/g, '-')           // Replace spaces with -
    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '');            // Trim - from end of text
}

// TINYMCE EDITOR
var editor_config = {
    path_absolute: "/",
    selector: "textarea.my-editor",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern",
        "autolink autoresize autosave"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | restoredraft | forecolor backcolor",
    valid_elements: "*[*]",
    valid_children: "+body[a],+a[div|h1|h2|h3|h4|h5|h6|p|#text]",
    forced_root_block: false,
    relative_urls: false,
    file_browser_callback: function (field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
            'body')[0].clientWidth;
        var y = window.innerHeight || document.documentElement.clientHeight || document
            .getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
            file: cmsURL,
            title: 'Filemanager',
            width: x * 0.8,
            height: y * 0.8,
            resizable: "yes",
            close_previous: "no"
        });
    }
};

tinymce.init(editor_config);

// MULTIPLE DELETE/ARCHIVE
$("body").on("change", "input[data-checkboxes='mygroup']", function() {
    var array_list = [];
    $.each($("input[data-checkboxes='mygroup']:checked"), function() {
        array_list.push($(this).val());
    });
    var index = array_list.indexOf('on');
    if(index > -1)
    {
        array_list.splice(index, 1);
    }
    $("a.destroy, a.archive, a.excel").removeClass("d-none");
    if(array_list.length<1)
    {
        $("a.destroy, a.archive, a.excel").addClass("d-none");
    }
    $("span.badge-transparent").text(array_list.length);
    $("input[name='multiple_delete'], input[name='multiple_archive'], input[name='excel_id']").val(array_list);
});
