(function ($) {

    function Timeline(params) {
        this.originalParams = $.extend(true, {}, params);
        this._tweens = [];
        N2A.Animation.call(this, params);
        this._duration = 0;
    }

    Timeline.prototype = Object.create(N2A.Animation.prototype);
    Timeline.prototype.constructor = Timeline;

    Timeline.prototype._onUpdate = function () {
        if (this.tweensContainer) {

            for (var i = 0; i < this.tweensContainer.length; i++) {
                var tweenContainer = this.tweensContainer[i];
                var currentProgress = Math.min(1, (this._progress - tweenContainer.startProgress) / (tweenContainer.endProgress - tweenContainer.startProgress));
                if (tweenContainer.tween._isCompleted && currentProgress <= tweenContainer.endProgress) {
                    tweenContainer.tween.reset();
                }

                if (!tweenContainer.tween._isStarted && currentProgress >= 0 && tweenContainer.tween.progress() == 0) {
                    tweenContainer.tween._onStart();
                }
                if (tweenContainer.tween._isStarted) {
                    if (currentProgress == 1 && !tweenContainer.tween._isCompleted) {
                        tweenContainer.tween.progress(currentProgress);
                        tweenContainer.tween._onComplete();
                    } else if (currentProgress >= 0 && currentProgress < 1) {
                        tweenContainer.tween.progress(currentProgress);
                    } else if (currentProgress < 0 && tweenContainer.tween.progress() != 0) {
                        tweenContainer.tween.progress(0);
                    }
                }
            }
        }
        N2A.Animation.prototype._onUpdate.call(this);
        if (!N2A.RAF._isTicking) {
            N2A.RAF.postTick();
        }
    };

    Timeline.prototype.addTween = function (tween) {
        tween.pause();
        tween.setTimeline(this);
        var position = 0;
        if (arguments.length > 1) {
            position = this._parsePosition(arguments[1]);
        } else {
            position = this._parsePosition();
        }

        var delay = tween.delay();
        if (delay > 0) {
            position += delay;
            tween.delay(0);
        }

        tween.startTime(position);
        this._tweens.push(tween);
        var duration = tween.totalDuration() + position;
        if (duration > this._duration) {
            this._duration = duration;
        }
        this.makeCache();
    };

    Timeline.prototype.clear = function () {
        if (!this.paused()) {
            this.pause();
        }
        Timeline.call(this, this.originalParams);
    };

    Timeline.prototype.add = function (tween, position) {
        this.addTween(tween, position);
    };

    Timeline.prototype.set = function (element, to, position) {
        this.addTween(NextendTween.to(element, 0.05, to), position);
    };

    Timeline.prototype.to = function (element, duration, to, position) {
        this.addTween(NextendTween.to(element, duration, to), position);
    };

    Timeline.prototype.fromTo = function (element, duration, from, to, position) {
        this.addTween(NextendTween.fromTo(element, duration, from, to), position);
    };

    Timeline.prototype.from = function (element, duration, from, position) {
        this.addTween(NextendTween.from(element, duration, from), position);
    };

    Timeline.prototype._play = function () {
        if (this._progress == 0) {

            for (var i = 0; i < this._tweens.length; i++) {
                this._tweens[i].pause(0);

            }
        }
        N2A.Animation.prototype._play.apply(this, arguments);
    };

    Timeline.prototype._parsePosition = function () {
        var positionString = '+=0';
        if (arguments.length > 0 && typeof arguments[0] !== 'undefined' && !isNaN(arguments[0])) {
            positionString = arguments[0];
        }
        var position = 0;

        switch (typeof positionString) {
            case 'string':
                switch (positionString.substr(0, 2)) {
                    case'+=':
                        position = this.duration() + parseFloat(positionString.substr(2));
                        break;
                    case'-=':
                        position = this.duration() - parseFloat(positionString.substr(2));
                        break;
                }
                break;
            default:
                position = parseFloat(positionString);
        }

        return Math.max(0, position);
    };

    Timeline.prototype.makeCache = function () {
        var totalDuration = this.totalDuration();
        this.tweensContainer = [];
        for (var i = 0; i < this._tweens.length; i++) {
            var tween = this._tweens[i];

            var startProgress = tween.startTime() / totalDuration,
                endProgress = (tween.startTime() + tween.totalDuration()) / totalDuration;
            this.tweensContainer.push({
                tween: tween,
                startProgress: startProgress,
                endProgress: endProgress,
                range: endProgress - startProgress
            });
        }
    };

    window.NextendTimeline = Timeline;
})
(n2);