function initializeMediaUploader() {
    var mediaUploader;

    jQuery(document).ready(function () {
        var $ = jQuery; // Usar jQuery como símbolo $

        $(".upload_image_button").click(function (e) {
            e.preventDefault();

            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            mediaUploader = wp.media({
                title: "Upload Image",
                button: {
                    text: "Use this image",
                },
                multiple: false,
            });

            mediaUploader.on("select", function () {
                var attachment = mediaUploader
                    .state()
                    .get("selection")
                    .first()
                    .toJSON();
                $("#about_image_field").val(attachment.url);
                $("#about_image_preview").attr("src", attachment.url);
            });

            mediaUploader.open();
        });
    });
}

// Llama a la función dentro de jQuery.ready
jQuery(document).ready(function ($) {
    console.log("El script admin.js se ha cargado correctamente");

    initializeMediaUploader();
});
