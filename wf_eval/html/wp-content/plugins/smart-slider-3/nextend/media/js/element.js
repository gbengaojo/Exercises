;
(function ($, scope) {

    function NextendElement() {
        this.element.data('field', this);
    };

    NextendElement.prototype.triggerOutsideChange = function () {
        this.element.triggerHandler('outsideChange', this);
        this.element.triggerHandler('nextendChange', this);
    };

    NextendElement.prototype.triggerInsideChange = function () {
        this.element.triggerHandler('insideChange', this);
        this.element.triggerHandler('nextendChange', this);
    };

    scope.NextendElement = NextendElement;


    function NextendElementContextMenu(selector, type) {
        $.contextMenu({
            selector: selector,
            build: function ($triggerElement, e) {

                var items = {};
                items['copy'] = {name: "Copy", icon: "copy"};


                var copied = $.jStorage.get(type + 'copied');

                if (copied !== null) {
                    items['paste'] = {
                        name: "Paste",
                        icon: "paste",
                        callback: function () {
                            $(this).find('input[type="hidden"]').data('field').insideChange(copied);
                        }
                    }
                }

                return {
                    animation: {duration: 0, show: 'show', hide: 'hide'},
                    zIndex: 1000000,
                    callback: function (key, options) {
                        $.jStorage.set(type + 'copied', $(this).find('input[type="hidden"]').val());
                    },
                    items: items
                };
            }
        });
    };

    scope.NextendElementContextMenu = NextendElementContextMenu;

})(n2, window);
