(function ($, scope, undefined) {

    function QuickSlides(ajaxUrl) {

        var button = $('#n2-quick-slides-edit');
        if (button.length < 1) {
            return;
        }

        this.ajaxUrl = ajaxUrl;

        button.on('click', $.proxy(this.openEdit, this));
    };

    QuickSlides.prototype.openEdit = function (e) {
        e.preventDefault();
        var slides = $('#n2-ss-slides .n2-box-slide');

        var that = this;
        this.modal = new NextendModal({
            zero: {
                fit: true,
                fitX: false,
                overflow: 'auto',
                size: [
                    1200,
                    700
                ],
                title: n2_('Quick Edit - Slides'),
                back: false,
                close: true,
                content: '<form class="n2-form"><table></table></form>',
                controls: [
                    '<a href="#" class="n2-button n2-button-big n2-button-green n2-uc n2-h4">' + n2_('Save') + '</a>'
                ],
                fn: {
                    show: function () {

                        var button = this.controls.find('.n2-button-green'),
                            form = this.content.find('.n2-form').on('submit', function (e) {
                                e.preventDefault();
                                button.trigger('click');
                            }),
                            table = form.find('table');

                        slides.each($.proxy(function (i, el) {
                            var slide = $(el),
                                tr = $('<tr />').appendTo(table),
                                id = slide.data('slideid');
                            tr.append($('<td />').append('<img src="' + slide.data('image') + '" style="width:100px;"/>'));
                            tr.append($('<td />').append(that.createInput('Name', 'title-' + id, slide.data('title'), 'width: 240px;')));
                            tr.append($('<td />').append(that.createTextarea('Description', 'description-' + id, slide.data('description'), 'width: 330px;height:24px;')));
                            var link = slide.data('link').split('|*|');
                            tr.append($('<td />').append(that.createLink('Link', 'link-' + id, link[0], 'width: 180px;')));
                            tr.append($('<td />').append(that.createTarget('Target', 'target-' + id, link.length > 1 ? link[1] : '_self', '')));

                            new NextendElementUrl('link-' + id, nextend.NextendElementUrlParams);

                        }, this));


                        button.on('click', $.proxy(function (e) {

                            var changed = {};
                            slides.each($.proxy(function (i, el) {
                                var slide = $(el),
                                    id = slide.data('slideid'),
                                    name = $('#title-' + id).val(),
                                    description = $('#description-' + id).val(),
                                    link = $('#link-' + id).val() + '|*|' + $('#target-' + id).val();

                                if (name != slide.data('title') || description != slide.data('description') || link != slide.data('link')) {
                                    changed[id] = {
                                        name: name,
                                        description: description,
                                        link: link
                                    };
                                }
                            }, this));

                            if (jQuery.isEmptyObject(changed)) {
                                this.hide(e);
                            } else {
                                this.hide(e);
                                NextendAjaxHelper.ajax({
                                    type: "POST",
                                    url: NextendAjaxHelper.makeAjaxUrl(that.ajaxUrl),
                                    data: {changed: Base64.encode(JSON.stringify(changed))},
                                    dataType: 'json'
                                }).done($.proxy(function (response) {
                                    var slides = response.data;
                                    for (var slideID in slides) {
                                        var slideBox = $('.n2-box-slide[data-slideid="' + slideID + '"]');
                                        slideBox.find('.n2-box-placeholder a.n2-h4').html(slides[slideID].title);

                                        slideBox.attr('data-title', slides[slideID].rawTitle);
                                        slideBox.data('title', slides[slideID].rawTitle);
                                        slideBox.attr('data-description', slides[slideID].rawDescription);
                                        slideBox.data('description', slides[slideID].rawDescription);
                                        slideBox.attr('data-link', slides[slideID].rawLink);
                                        slideBox.data('link', slides[slideID].rawLink);
                                    }
                                }, this));
                            }
                        }, this));
                    }
                }
            }
        });

        this.modal.setCustomClass('n2-ss-quick-slides-edit-modal');
        this.modal.show();

    };

    QuickSlides.prototype.createInput = function (label, id, value) {
        var style = '';
        if (arguments.length == 4) {
            style = arguments[3];
        }
        var nodes = $('<div class="n2-form-element-mixed"><div class="n2-mixed-group"><div class="n2-mixed-label"><label for="' + id + '">' + label + '</label></div><div class="n2-mixed-element"><div class="n2-form-element-text n2-border-radius"><input type="text" id="' + id + '" class="n2-h5" autocomplete="off" style="' + style + '"></div></div></div></div>');
        nodes.find('input').val(value);
        return nodes;
    };

    QuickSlides.prototype.createTextarea = function (label, id, value) {
        var style = '';
        if (arguments.length == 4) {
            style = arguments[3];
        }
        var nodes = $('<div class="n2-form-element-mixed"><div class="n2-mixed-group"><div class="n2-mixed-label"><label for="' + id + '">' + label + '</label></div><div class="n2-mixed-element"><div class="n2-form-element-textarea n2-border-radius"><textarea id="' + id + '" class="n2-h5" autocomplete="off" style="resize:y;' + style + '"></textarea></div></div></div></div>');
        nodes.find('textarea').val(value);
        return nodes;
    };

    QuickSlides.prototype.createLink = function (label, id, value) {
        var style = '';
        if (arguments.length == 4) {
            style = arguments[3];
        }
        var nodes = $('<div class="n2-form-element-mixed"><div class="n2-mixed-group"><div class="n2-mixed-label"><label for="' + id + '">' + label + '</label></div><div class="n2-mixed-element"><div class="n2-form-element-text n2-border-radius"><input type="text" id="' + id + '" class="n2-h5" autocomplete="off" style="' + style + '"><a href="#" class="n2-form-element-clear"><i class="n2-i n2-it n2-i-empty n2-i-grey-opacity"></i></a><a id="' + id + '_button" class="n2-form-element-button n2-h5 n2-uc" href="#">Link</a></div></div></div></div>');
        nodes.find('input').val(value);
        return nodes;
    };


    QuickSlides.prototype.createTarget = function (label, id, value) {
        var style = '';
        if (arguments.length == 4) {
            style = arguments[3];
        }
        var nodes = $('<div class="n2-form-element-mixed"><div class="n2-mixed-group"><div class="n2-mixed-label"><label for="' + id + '">' + label + '</label></div><div class="n2-mixed-element"><div class="n2-form-element-list"><select id="' + id + '" autocomplete="off" style="' + style + '"><option value="_self">Self</option><option value="_blank">Blank</option></select</div></div></div></div>');
        nodes.find('select').val(value);
        return nodes;
    };

    scope.NextendSmartSliderQuickSlides = QuickSlides;
})(n2, window);