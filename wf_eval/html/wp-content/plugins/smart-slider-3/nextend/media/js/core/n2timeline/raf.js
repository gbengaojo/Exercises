(function () {

    // http://stackoverflow.com/questions/3954438/remove-item-from-array-by-value
    var N2ArrayRemove = function (arr) {
        var what, a = arguments, L = a.length, ax;
        while (L > 1 && arr.length) {
            what = a[--L];
            while ((ax = arr.indexOf(what)) !== -1) {
                arr.splice(ax, 1);
            }
        }
        return arr;
    };

    function RAF() {
        this._isTicking = false;
        this._isMobile = false;
        this._lastTick = 0;
        this._ticks = [];
        this._postTickCallbacks = [];


        /* rAF shim. Gist: https://gist.github.com/julianshapiro/9497513 */
        var rAFShim = (function () {
            var timeLast = 0;

            return window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function (callback) {
                    var timeCurrent = (new Date()).getTime(),
                        timeDelta;

                    /* Dynamically set delay on a per-tick basis to match 60fps. */
                    /* Technique by Erik Moller. MIT license: https://gist.github.com/paulirish/1579671 */
                    timeDelta = Math.max(0, 16 - (timeCurrent - timeLast));
                    timeLast = timeCurrent + timeDelta;

                    return setTimeout(function () {
                        callback(timeCurrent + timeDelta);
                    }, timeDelta);
                };
        })();

        /* Ticker function. */
        this._raf = window.requestAnimationFrame || rAFShim;

        var _this = this;
        /* Inactive browser tabs pause rAF, which results in all active animations immediately sprinting to their completion states when the tab refocuses.
         To get around this, we dynamically switch rAF to setTimeout (which the browser *doesn't* pause) when the tab loses focus. We skip this for mobile
         devices to avoid wasting battery power on inactive tabs. */
        /* Note: Tab focus detection doesn't work on older versions of IE, but that's okay since they don't support rAF to begin with. */
        if (!this._isMobile && document.hidden !== undefined) {
            document.addEventListener("visibilitychange", function () {
                /* Reassign the rAF function (which the global tick() function uses) based on the tab's focus state. */
                if (document.hidden) {
                    this._raf = function (callback) {
                        /* The tick function needs a truthy first argument in order to pass its internal timestamp check. */
                        return setTimeout(function () {
                            callback(_this.now());
                        }, 16);
                    };

                    /* The rAF loop has been paused by the browser, so we manually restart the tick. */
                    _this._tick(_this.now());
                } else {
                    _this._raf = window.requestAnimationFrame || rAFShim;
                }
            });
        }
    }

    RAF.prototype.addTick = function (callback) {
        if (this._ticks.indexOf(callback) == -1) {
            this._ticks.push(callback);
        }
        if (!this._isTicking) {
            this._isTicking = true;
            this._raf.call(null, this.getTickStart());
        }
    }

    RAF.prototype.removeTick = function (callback) {
        N2ArrayRemove(this._ticks, callback);

        if (this._ticks.length === 0 && this._isTicking) {
            this._lastTick = 0;
            this._isTicking = false;
        }
    }

    RAF.prototype._tickStart = function (time) {
        this._lastTick = time;
        //this._tick(time);

        if (this._isTicking) {
            this._lastTick = time;
            this._raf.call(null, this.getTick());
        }
    }


    RAF.prototype._tick = function (time) {
        var delta = (time - this._lastTick) / 1000;
        if (delta != 0) {
            for (var i = 0; i < this._ticks.length; i++) {
                this._ticks[i].call(null, delta);
            }

            this.postTick();
        }
        this._continueTick(time);
    };

    RAF.prototype._continueTick = function (time) {

        if (this._isTicking) {
            this._lastTick = time;
            this._raf.call(null, this.getTick());
        }
    };

    RAF.prototype.getTick = function () {
        var that = this;
        return function () {
            that._tick.apply(that, arguments);
        };
    }

    RAF.prototype.getTickStart = function () {
        var that = this;
        return function () {
            that._tickStart.apply(that, arguments);
        };
    }

    RAF.prototype.now = function () {
        return performance.now();
    }

    RAF.prototype.postTick = function () {
        for (var i = 0; i < this._postTickCallbacks.length; i++) {
            this._postTickCallbacks[i]();
        }
        this._postTickCallbacks = [];
    }

    RAF.prototype.addPostTick = function (callback) {
        this._postTickCallbacks.push(callback);
    };

    window.N2A = {
        RAF: new RAF(),
        isArray: function (arg) {
            return Object.prototype.toString.call(arg) === '[object Array]';
        },
        isFunction: function (arg) {
            return typeof arg === 'function';
        },
        isString: function (arg) {
            return typeof arg === 'string';
        }
    };
})();