(function (smartSlider, $, scope, undefined) {
    "use strict";

    function NextendSmartSliderSlideEditorHistory() {
        this.historyStates = 50;
        this.isEnabled = this.historyStates != 0;
        this.historyAddAllowed = true;
        this.isBatched = false;
        this.index = -1;
        this.history = [];

        this.preventUndoRedo = false;

        this.undoBTN = $('#n2-ss-undo').on('click', $.proxy(this.undo, this));
        this.redoBTN = $('#n2-ss-redo').on('click', $.proxy(this.redo, this));
        this.updateUI();
    };

    NextendSmartSliderSlideEditorHistory.prototype.updateUI = function () {
        if (this.index == 0 || this.history.length == 0) {
            this.undoBTN.removeClass('n2-active');
        } else {
            this.undoBTN.addClass('n2-active');
        }

        if (this.index == -1 || this.index >= this.history.length) {
            this.redoBTN.removeClass('n2-active');
        } else {
            this.redoBTN.addClass('n2-active');
        }
    };

    NextendSmartSliderSlideEditorHistory.prototype.throttleUndoRedo = function () {
        if (!this.preventUndoRedo) {
            this.preventUndoRedo = true;
            setTimeout($.proxy(function () {
                this.preventUndoRedo = false;
            }, this), 100);
            return false;
        }
        return true;
    };

    NextendSmartSliderSlideEditorHistory.prototype.add = function (cb) {
        if (!this.isEnabled || !this.historyAddAllowed) return;
        if (this.index != -1) {
            this.history.splice(this.index, this.history.length);
        }
        this.index = -1;
        if (!this.isBatched) {
            this.history.push([cb()]);
            this.isBatched = true;
            setTimeout($.proxy(function () {
                this.isBatched = false;
            }, this), 100);
        } else {
            this.history[this.history.length - 1].push(cb());
        }
        //this.history.push(smartSlider.slide.getLayout());
        if (this.history.length > this.historyStates) {
            this.history.unshift();
        }
        this.updateUI();
    };

    NextendSmartSliderSlideEditorHistory.prototype.off = function () {
        this.historyAddAllowed = false;
    };

    NextendSmartSliderSlideEditorHistory.prototype.on = function () {
        this.historyAddAllowed = true;
    };

    NextendSmartSliderSlideEditorHistory.prototype.undo = function (e) {
        if (e) {
            e.preventDefault();
        }
        if (this.throttleUndoRedo()) {
            return false;
        }
        this.off();
        if (this.index == -1) {
            this.index = this.history.length - 1;
        } else {
            this.index--;
        }
        if (this.index >= 0) {
            var actions = this.history[this.index];
            for (var i = actions.length - 1; i >= 0; i--) {
                var action = actions[i];
                action[0].history(action[1], action[3], action[4], action);
            }
        } else {
            this.index = 0;
            // No more undo
        }
        this.on();
        this.updateUI();
    };

    NextendSmartSliderSlideEditorHistory.prototype.redo = function (e) {
        if (e) {
            e.preventDefault();
        }
        if (this.throttleUndoRedo()) {
            return false;
        }
        this.off();
        if (this.index != -1) {
            if (this.index < this.history.length) {
                var actions = this.history[this.index];
                this.index++;
                for (var i = 0; i < actions.length; i++) {
                    var action = actions[i];
                    action[0].history(action[1], action[2], action[4], action);
                }
            } else {
                // No more redo
            }
        } else {
            // No redo
        }
        this.on();
        this.updateUI();
    };

    NextendSmartSliderSlideEditorHistory.prototype.changeFuture = function (originalScope, newScope) {
        for (var i = 0; i < this.history.length; i++) {
            for (var j = 0; j < this.history[i].length; j++) {
                if (this.history[i][j][0] === originalScope) {
                    this.history[i][j][0] = newScope;
                }
                for (var k = 0; k < this.history[i][j][4].length; k++) {
                    if (this.history[i][j][4][k] === originalScope) {
                        this.history[i][j][4][k] = newScope;
                    }
                }
            }
        }
    };

    n2(window).ready(function () {
        smartSlider.history = new NextendSmartSliderSlideEditorHistory();
    });

})(nextend.smartSlider, n2, window);
