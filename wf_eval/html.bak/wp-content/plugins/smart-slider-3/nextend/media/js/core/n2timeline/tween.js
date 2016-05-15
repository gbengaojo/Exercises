(function ($) {
    var css = new N2A.CSS(),
        MODE = {
            FROM: 1,
            FROMTO: 2,
            TO: 3
        };

    function Tween(target, duration) {
        this.ease = 'linear';
        this._tweenContainer = null;
        this._setContainer = null;
        var fromParams = null, toParams;
        switch (arguments.length) {
            case 4:
                fromParams = $.extend(true, {}, arguments[2]);
                toParams = arguments[3];
                if (!toParams) {
                    this._mode = MODE.FROM;
                } else {
                    this._mode = MODE.FROMTO;
                    toParams = $.extend(true, {}, toParams);
                }
                break;
            default:
                this._mode = MODE.TO;
                fromParams = {};
                toParams = $.extend(true, {}, arguments[2]);
        }

        this._target = $(target);

        this.fromParams = fromParams;

        N2A.Animation.call(this, toParams);

        this.parseParameters({
            duration: duration
        });

        if ((this._mode == MODE.FROM || this._mode == MODE.FROMTO) && this._immediateRender) {
            if (this._tweenContainer === null) {
                this._makeTweenContainer(this.fromParams, this.toParams);
            }
            for (var k in this._tweenContainer) {
                var tween = this._tweenContainer[k];
                css.set(this._target, k, tween.startValue, tween.unit);
            }
            for (var k in this._setContainer) {
                var tween = this._setContainer[k];
                css.set(this._target, k, tween.endValue, tween.unit);
            }
        }
    }

    Tween.prototype = Object.create(N2A.Animation.prototype);
    Tween.prototype.constructor = Tween;

    Tween.prototype.initParameters = function () {

        this.parseParameters(this.fromParams);

        N2A.Animation.prototype.initParameters.apply(this, arguments);
    };

    Tween.prototype.parseParameters = function (params) {
        if (params) {
            if (params.ease) {
                this.ease = params.ease;
                delete params.ease;
            }

            N2A.Animation.prototype.parseParameters.apply(this, arguments);
        }
    }

    Tween.prototype._onStart = function () {
        if (this._tweenContainer === null) {
            this._makeTweenContainer(this.fromParams, this.toParams);
        }

        for (var k in this._setContainer) {
            var tween = this._setContainer[k];
            css.set(this._target, k, tween.endValue, tween.unit);
        }

        N2A.Animation.prototype._onStart.call(this);
    };

    Tween.prototype._onUpdate = function () {
        for (var k in this._tweenContainer) {
            var tween = this._tweenContainer[k];
            css.set(this._target, k, N2A.easings[this.ease](this._progress, tween.startValue, tween.range * this._progress, 1), tween.unit);
        }
        //this._target.css(this._property, this._range * this._progress);
        N2A.Animation.prototype._onUpdate.call(this);
    };

    Tween.prototype._makeTweenContainer = function (from, to) {
        this._setContainer = {};
        this._tweenContainer = {};
        if (to) {
            for (var k  in to) {
                var container = css.makeTransitionData(this._target, k, from[k], to[k]);
                if (container.range == 0) {
                    this._setContainer[k] = container;
                } else {
                    this._tweenContainer[k] = container;
                }
            }
        } else {
            for (var k  in from) {
                var container = css.makeTransitionData(this._target, k, from[k]);
                if (container.range == 0) {
                    this._setContainer[k] = container;
                } else {
                    this._tweenContainer[k] = container;
                }
            }
        }
    };

    Tween.set = function (element, to) {
        for (var k in to) {
            css.set($(element), k, to[k], '');
        }
    };

    Tween.to = function (element, duration, to) {
        return new Tween(element, duration, to);
    };

    Tween.fromTo = function (element, duration, from, to) {
        return new Tween(element, duration, from, to);
    };

    Tween.from = function (element, duration, from) {
        return new Tween(element, duration, from, null);
    };

    window.NextendTween = Tween;

})(n2);