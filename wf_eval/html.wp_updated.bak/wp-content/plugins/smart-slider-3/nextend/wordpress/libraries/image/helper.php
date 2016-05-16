<?php

class N2ImageHelper extends N2ImageHelperAbstract
{

    public static function initLightbox() {
        static $inited = false;
        if (!$inited) {
            wp_enqueue_media();
            $inited = true;
        }
    }

    public static function getLightboxFunction() {
        return 'function (callback) {
        var frame = new wp.media();

        frame.on("select", $.proxy(function () {
            var attachment = frame.state().get("selection").first().toJSON();
            callback(this.make(attachment.url));
        }, this));
        frame.on("close", function () {
            setTimeout(function () {
                NextendEsc.pop();
            }, 50)
        });
        NextendEsc.add(function () {
            return false;
        });
        frame.open();
    }';
    }

    public static function getLightboxMultipleFunction() {
        return 'function (callback) {
        var frame = new wp.media({
            multiple: "add"
        });

        frame.on("select", $.proxy(function () {
            var attachments = frame.state().get("selection").toJSON(),
                images = [];

            for (var i = 0; i < attachments.length; i++) {
                var attachment = attachments[i];
                images.push({
                    title: attachment.title,
                    description: attachment.description,
                    image: this.make(attachment.url)
                })
            }
            callback(images);
        }, this));
        frame.on("close", function () {
            setTimeout(function () {
                NextendEsc.pop();
            }, 50)
        });
        frame.open();
        NextendEsc.add(function () {
            return false;
        });
    }';
    }
}