(function () {
    function Animation(toParams) {
        this._tickCallback = null;
        this._progress = 0;
        this._delayTimeout = false;
        this._delay = 0;
        this._duration = 4;
        this._timeScale = 1.0;
        this._isPlaying = false;
        this._startTime = 0;
        this._eventCallbacks = {};
        this._immediateRender = true;
        this._timeline = null;
        this._isCompleted = false;
        this._isStarted = false;
        this._isReversed = false;

        this.toParams = toParams;

        this.initParameters()
    };

    Animation.prototype.initParameters = function () {
        this.parseParameters(this.toParams);

        if (typeof this.toParams !== 'object') {
            this.paused(false);
        }
    };

    Animation.prototype.parseParameters = function (params) {
        if (params) {
            if (params.delay) {
                this.delay(params.delay);
                delete params.delay;
            }
            if (typeof params.duration !== 'undefined') {
                this.duration(params.duration);
                delete params.duration;
            }
            if (params.onComplete) {
                this.eventCallback('onComplete', params.onComplete);
                delete params.onComplete;
            }
            if (params.onStart) {
                this.eventCallback('onStart', params.onStart);
                delete params.onStart;
            }
            if (params.onUpdate) {
                this.eventCallback('onUpdate', params.onUpdate);
                delete params.onUpdate;
            }
            if (params.immediateRender) {
                this._immediateRender = params.immediateRender;
                delete params.immediateRender;
            }
            if (params.paused) {
                this.paused(true);
            }
        }
    };

    Animation.prototype.setTimeline = function (timeline) {
        this._timeline = timeline;
    }

    Animation.prototype._tick = function (delta) {
        var pr = this._progress;
        if (!this._isReversed) {
            this._progress += delta / this._duration * this._timeScale;
            if (pr == 0 || !this._isStarted) {
                this._onStart();
            } else {
                if (this._progress >= 1) {
                    this._progress = 1;
                    this._isPlaying = false;
                    N2A.RAF.removeTick(this.getTickCallback());
                    this._onUpdate();
                    this._onComplete();
                } else {
                    this._onUpdate();
                }
            }
        } else {
            this._progress -= delta / this._duration * this._timeScale;
            if (pr == 1 || !this._isStarted) {
                this._onReverseStart();
            } else {
                if (this._progress <= 0) {
                    this._progress = 0;
                    this._isPlaying = false;
                    N2A.RAF.removeTick(this.getTickCallback());
                    this._onUpdate();
                    this._onReverseComplete();
                } else {
                    this._onUpdate();
                }
            }
        }
    };

    Animation.prototype._onStart = function () {
        this._isStarted = true;
        this._isPlaying = false;
        this._isCompleted = false;
        this.trigger('onStart');
        this._onUpdate();
    };

    Animation.prototype._onUpdate = function () {

        this.trigger('onUpdate');
    };

    Animation.prototype._onComplete = function () {
        this._isCompleted = true;
        this._onUpdate();
        this.trigger('onComplete');
    };

    Animation.prototype._onReverseComplete = function () {
        this._isCompleted = true;
        this._isReversed = false;
        this._onUpdate();
        this.trigger('onReverseComplete');
    };

    Animation.prototype._onReverseStart = function () {
        this._isStarted = true;
        this._isPlaying = false;
        this._isCompleted = false;
        this.trigger('onReverseStart');
        this._onUpdate();
    };

    Animation.prototype.getTickCallback = function () {
        if (!this._tickCallback) {
            var that = this;
            this._tickCallback = function () {
                that._tick.apply(that, arguments);
            };
        }
        return this._tickCallback;
    };

    Animation.prototype._clearDelayTimeout = function () {
        if (this._delayTimeout) {
            clearTimeout(this._delayTimeout);
            this._delayTimeout = false;
        }
    };

    Animation.prototype._timeToProgress = function (time) {
        return time / this._duration * this._timeScale;
    };


    Animation.prototype.delay = function () {
        if (arguments.length > 0) {
            var delay = parseFloat(arguments[0]);
            if (isNaN(delay) || delay == Infinity || !delay) {
                delay = 0;
            }
            this._delay = Math.max(0, delay);
            return this;
        }
        return this._delay;
    };

    Animation.prototype.duration = function () {
        if (arguments.length > 0) {
            var duration = parseFloat(arguments[0]);
            if (isNaN(duration) || duration == Infinity || !duration) {
                duration = 0;
            }
            this._duration = Math.max(0, duration);
            return this;
        }
        return this._duration;
    };

    Animation.prototype.eventCallback = function (type) {
        if (arguments.length > 3) {
            this._eventCallbacks[type] = [arguments[1], arguments[2], arguments[3]];
        } else if (arguments.length > 2) {
            this._eventCallbacks[type] = [arguments[1], arguments[2], this];
        } else if (arguments.length > 1) {
            this._eventCallbacks[type] = [arguments[1], [], this];
        }
        return this._eventCallbacks[type];
    };

    Animation.prototype.pause = function () {
        this._isPlaying = false;
        N2A.RAF.removeTick(this.getTickCallback());
        if (arguments.length > 0) {
            if (arguments[0] != null) {
                this.progress(this._timeToProgress(arguments[0]));
            }
        }
        return this;
    };

    Animation.prototype.paused = function () {
        if (arguments.length > 0) {
            if (arguments[0]) {
                if (this._isPlaying) {
                    this.pause();
                }
            } else {
                if (!this._isPlaying) {
                    this.play();
                }
            }
            return this;
        }
        return !this._isPlaying;
    };

    Animation.prototype.play = function () {
        var startDelay = true;
        if (arguments.length > 0) {
            if (arguments[0] != null) {
                startDelay = false;
                this._progress = this._timeToProgress(arguments[0]);
            }
        }

        this._play(startDelay);
    };

    Animation.prototype._play = function (startDelay) {

        if (this._progress < 1) {
            if (this._progress == 0 && startDelay && this._delay > 0) {
                if (!this._delayTimeout) {
                    var that = this;
                    this._delayTimeout = setTimeout(function () {
                        that.__play.apply(that, arguments);
                    }, this._delay * 1000);
                }
            } else {
                this.__play();
            }
        } else if (!this._isCompleted) {
            if (!this._isReversed) {
                this._onComplete();
            } else {
                this._onReverseComplete();
            }
        }
    };

    Animation.prototype.__play = function () {
        this._clearDelayTimeout();
        if (!this._isPlaying) {
            //this.getTickCallback().call(this, 0);
            N2A.RAF.addTick(this.getTickCallback());
            this._isPlaying = true;
        }
    };

    Animation.prototype.progress = function () {
        if (arguments.length > 0) {
            var progress = parseFloat(arguments[0]);
            if (isNaN(progress)) {
                progress = 0;
            }
            progress = Math.min(1, Math.max(0, progress));

            if (1 || this._progress != progress) {
                this._progress = progress;
                if (!this._isPlaying) {
                    if (!this._isStarted) {
                        this._onStart();
                    }
                    this._onUpdate();
                }
            }
            return this;
        }
        return this._progress;
    };

    Animation.prototype.reverse = function () {
        this._isReversed = true;
        if (this.progress() != 0) {
            this.play();
        }
    };

    Animation.prototype.restart = function () {
        if (arguments.length > 0) {
            if (arguments[0]) {
                // restart with delay
                this.pause(0);
                this.play();
                return this;
            }
        }
        this.play(0);
        return this;
    };

    Animation.prototype.seek = function (time) {
        if (time != null) {
            this._progress = this._timeToProgress(arguments[0]);
            if (!this._isPlaying) {
                this._onUpdate();
            }
        }
    };

    Animation.prototype.startTime = function () {
        if (arguments.length > 0) {
            var startTime = parseFloat(arguments[0]);
            if (isNaN(startTime)) {
                startTime = 0;
            }
            this._startTime = Math.max(0, startTime);
            return this;
        }
        return this._startTime;
    };

    Animation.prototype.timeScale = function () {
        if (arguments.length > 0) {
            var timeScale = parseFloat(arguments[0]);
            if (isNaN(timeScale)) {
                timeScale = 1;
            }
            timeScale = Math.max(0.01, timeScale);

            if (this._timeScale != timeScale) {
                this._timeScale = timeScale;
            }
            return this;
        }
        return this._timeScale;
    };

    Animation.prototype.trigger = function (type) {
        if (typeof this._eventCallbacks[type] == 'object') {
            this._eventCallbacks[type][0].apply(this._eventCallbacks[type][2], this._eventCallbacks[type][1]);
        }
    };

    Animation.prototype.totalDuration = function () {
        if (arguments.length > 0) {
            var totalDuration = parseFloat(arguments[0]);
            if (isNaN(totalDuration)) {
                totalDuration = 0;
            }
            totalDuration = Math.max(0, totalDuration);

            this.timeScale(this._duration / totalDuration);
            return this;
        }

        return this._duration * this._timeScale;
    };

    Animation.prototype.reset = function () {
        this._isCompleted = false;
        this._isStarted = false;
        this.progress(0);
    };

    N2A.Animation = Animation;
})();