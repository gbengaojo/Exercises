/**
 * Abstract class for all the main animations
 * @type {NextendSmartSliderMainAnimationAbstract}
 * @abstract
 */
(function ($, scope, undefined) {
    function NextendSmartSliderMainAnimationAbstract(slider, parameters) {

        this.state = 'ended';
        this.isTouch = false;
        this.isReverseAllowed = true;
        this.isReverseEnabled = false;
        this.reverseSlideIndex = -1;

        this.slider = slider;

        this.parameters = $.extend({
            duration: 1500,
            ease: 'easeInOutQuint'
        }, parameters);

        this.parameters.duration /= 1000;

        this.sliderElement = slider.sliderElement;

        this.timeline = new NextendTimeline({
            paused: true
        });

        this.sliderElement.on('mainAnimationStart', $.proxy(function (e, animation, currentSlideIndex, nextSlideIndex) {
            this.currentSlideIndex = currentSlideIndex;
            this.nextSlideIndex = nextSlideIndex;
        }, this));
    };

    NextendSmartSliderMainAnimationAbstract.prototype.enableReverseMode = function () {
        this.isReverseEnabled = true;

        this.reverseTimeline = new NextendTimeline({
            paused: true
        });

        this.sliderElement.triggerHandler('reverseModeEnabled', this.reverseSlideIndex);
    };

    NextendSmartSliderMainAnimationAbstract.prototype.disableReverseMode = function () {
        this.isReverseEnabled = false;
    };

    NextendSmartSliderMainAnimationAbstract.prototype.setTouch = function (direction) {
        this.isTouch = direction;
    };

    NextendSmartSliderMainAnimationAbstract.prototype.setTouchProgress = function (progress) {
        if (this.isReverseEnabled) {
            this._setTouchProgressWithReverse(progress);
        } else {
            this._setTouchProgress(progress);
        }
    };

    NextendSmartSliderMainAnimationAbstract.prototype._setTouchProgress = function (progress) {
        if (this.state != 'ended') {
            if (progress <= 0) {
                this.timeline.progress(Math.max(progress, 0.000001), false);
            } else if (progress >= 0 && progress <= 1) {
                this.timeline.progress(progress);
            }
        }
    };

    NextendSmartSliderMainAnimationAbstract.prototype._setTouchProgressWithReverse = function (progress) {
        if (progress == 0) {
            this.reverseTimeline.progress(0);
            this.timeline.progress(progress, false);
        } else if (progress >= 0 && progress <= 1) {
            this.reverseTimeline.progress(0);
            this.timeline.progress(progress);
        } else if (progress < 0 && progress >= -1) {
            this.timeline.progress(0);
            this.reverseTimeline.progress(Math.abs(progress));
        }
    };


    NextendSmartSliderMainAnimationAbstract.prototype.setTouchEnd = function (hasDirection, progress, duration) {
        if (this.state != 'ended') {
            if (this.isReverseEnabled) {
                this._setTouchEndWithReverse(hasDirection, progress, duration);
            } else {
                this._setTouchEnd(hasDirection, progress, duration);
            }
        }
    };

    NextendSmartSliderMainAnimationAbstract.prototype._setTouchEnd = function (hasDirection, progress, duration) {
        if (hasDirection && progress > 0) {
            this.fixTouchDuration(this.timeline, progress, duration);
            this.timeline.play();
        } else {
            this.revertCB(this.timeline);
            this.fixTouchDuration(this.timeline, 1 - progress, duration);
            this.timeline.reverse();

            this.willRevertTo(this.currentSlideIndex, this.nextSlideIndex);
        }
    };

    NextendSmartSliderMainAnimationAbstract.prototype._setTouchEndWithReverse = function (hasDirection, progress, duration) {
        if (hasDirection) {
            if (progress < 0 && this.reverseTimeline.totalDuration() > 0) {
                this.fixTouchDuration(this.reverseTimeline, progress, duration);
                this.reverseTimeline.play();

                this.willRevertTo(this.reverseSlideIndex, this.nextSlideIndex);
            } else {

                this.willCleanSlideIndex(this.reverseSlideIndex);
                this.fixTouchDuration(this.timeline, progress, duration);
                this.timeline.play();
            }
        } else {
            if (progress < 0) {
                this.revertCB(this.reverseTimeline);
                this.fixTouchDuration(this.reverseTimeline, 1 - progress, duration);
                this.reverseTimeline.reverse();
            } else {
                this.revertCB(this.timeline);
                this.fixTouchDuration(this.timeline, 1 - progress, duration);
                this.timeline.reverse();
            }

            this.willCleanSlideIndex(this.reverseSlideIndex);

            this.willRevertTo(this.currentSlideIndex, this.nextSlideIndex);
        }
    };

    NextendSmartSliderMainAnimationAbstract.prototype.fixTouchDuration = function (timeline, progress, duration) {
        var totalDuration = timeline.totalDuration(),
            modifiedDuration = Math.max(totalDuration / 3, Math.min(totalDuration, duration / Math.abs(progress) / 1000));
        if (modifiedDuration != totalDuration) {
            timeline.totalDuration(modifiedDuration);
        }
    };

    NextendSmartSliderMainAnimationAbstract.prototype.getState = function () {
        return this.state;
    };

    NextendSmartSliderMainAnimationAbstract.prototype.timeScale = function () {
        if (arguments.length > 0) {
            this.timeline.timeScale(arguments[0]);
            return this;
        }
        return this.timeline.timeScale();
    };

    NextendSmartSliderMainAnimationAbstract.prototype.preChangeToPlay = function (deferred, currentSlide, nextSlide) {
        var deferredHandled = {
            handled: false
        };

        this.sliderElement.trigger('preChangeToPlay', [deferred, deferredHandled, currentSlide, nextSlide]);

        if (!deferredHandled.handled) {
            deferred.resolve();
        }
    };

    NextendSmartSliderMainAnimationAbstract.prototype.changeTo = function (currentSlideIndex, currentSlide, nextSlideIndex, nextSlide, reversed, isSystem) {

        this._initAnimation(currentSlideIndex, currentSlide, nextSlideIndex, nextSlide, reversed);

        this.state = 'initAnimation';

        this.timeline.paused(true);
        this.timeline.eventCallback('onStart', this.onChangeToStart, [currentSlideIndex, nextSlideIndex, isSystem], this);
        this.timeline.eventCallback('onComplete', this.onChangeToComplete, [currentSlideIndex, nextSlideIndex, isSystem], this);
        this.timeline.eventCallback('onReverseComplete', null);

        this.revertCB = $.proxy(function (timeline) {
            timeline.eventCallback('onReverseComplete', this.onReverseChangeToComplete, [nextSlideIndex, currentSlideIndex, isSystem], this);
        }, this);

        if (this.slider.parameters.dynamicHeight) {
            var tl = new NextendTimeline();
            this.slider.responsive.doResize(false, tl, nextSlideIndex, 0.6);
            this.timeline.add(tl);
        }


        // If the animation is in touch mode, we do not need to play the timeline as the touch will set the actual progress and also play later...
        if (!this.isTouch) {
            var deferred = $.Deferred();

            deferred.done($.proxy(function () {
                this.play();
            }, this.timeline));

            this.preChangeToPlay(deferred, currentSlide, nextSlide);
        } else {
            this.slider.callOnSlide(currentSlide, 'onOutAnimationsPlayed');
        }
    };


    NextendSmartSliderMainAnimationAbstract.prototype.willRevertTo = function (slideIndex, originalNextSlideIndex) {

        this.sliderElement.triggerHandler('mainAnimationWillRevertTo', [slideIndex, originalNextSlideIndex]);

        this.sliderElement.one('mainAnimationComplete', $.proxy(this.revertTo, this, slideIndex, originalNextSlideIndex));
    };


    NextendSmartSliderMainAnimationAbstract.prototype.revertTo = function (slideIndex, originalNextSlideIndex) {
        this.slider.revertTo(slideIndex, originalNextSlideIndex);

        // Cancel the pre-initialized layer animations on the original next slide.
        this.slider.slides.eq(originalNextSlideIndex).triggerHandler('mainAnimationStartInCancel');
    };


    NextendSmartSliderMainAnimationAbstract.prototype.willCleanSlideIndex = function (slideIndex) {

        this.sliderElement.one('mainAnimationComplete', $.proxy(this.cleanSlideIndex, this, slideIndex));
    };

    NextendSmartSliderMainAnimationAbstract.prototype.cleanSlideIndex = function () {

    };

    /**
     * @abstract
     * @param currentSlideIndex
     * @param currentSlide
     * @param nextSlideIndex
     * @param nextSlide
     * @param reversed
     * @private
     */
    NextendSmartSliderMainAnimationAbstract.prototype._initAnimation = function (currentSlideIndex, currentSlide, nextSlideIndex, nextSlide, reversed) {

    };

    NextendSmartSliderMainAnimationAbstract.prototype.onChangeToStart = function (previousSlideIndex, currentSlideIndex, isSystem) {

        this.state = 'playing';

        var parameters = [this, previousSlideIndex, currentSlideIndex, isSystem];

        n2c.log('Event: mainAnimationStart: ', parameters, '{NextendSmartSliderMainAnimationAbstract}, previousSlideIndex, currentSlideIndex, isSystem');
        this.sliderElement.trigger('mainAnimationStart', parameters);

        this.slider.slides.eq(previousSlideIndex).trigger('mainAnimationStartOut', parameters);
        this.slider.slides.eq(currentSlideIndex).trigger('mainAnimationStartIn', parameters);
    };

    NextendSmartSliderMainAnimationAbstract.prototype.onChangeToComplete = function (previousSlideIndex, currentSlideIndex, isSystem) {
        var parameters = [this, previousSlideIndex, currentSlideIndex, isSystem];

        this.clearTimelines();

        this.disableReverseMode();

        this.slider.slides.eq(previousSlideIndex).trigger('mainAnimationCompleteOut', parameters);
        this.slider.slides.eq(currentSlideIndex).trigger('mainAnimationCompleteIn', parameters);

        this.state = 'ended';

        n2c.log('Event: mainAnimationComplete: ', parameters, '{NextendSmartSliderMainAnimationAbstract}, previousSlideIndex, currentSlideIndex, isSystem');
        this.sliderElement.trigger('mainAnimationComplete', parameters);
    };

    NextendSmartSliderMainAnimationAbstract.prototype.onReverseChangeToComplete = function (previousSlideIndex, currentSlideIndex, isSystem) {
        NextendSmartSliderMainAnimationAbstract.prototype.onChangeToComplete.apply(this, arguments);
    };

    NextendSmartSliderMainAnimationAbstract.prototype.clearTimelines = function () {
        // When the animation done, clear the timeline
        this.revertCB = function () {
        };
        this.timeline.clear();
        this.timeline.timeScale(1);
        //this.reverseTimeline.clear();
        //this.reverseTimeline.timeScale(1);

    }

    NextendSmartSliderMainAnimationAbstract.prototype.getEase = function () {
        if (this.isTouch) {
            return 'linear';
        }
        return this.parameters.ease;
    };
    scope.NextendSmartSliderMainAnimationAbstract = NextendSmartSliderMainAnimationAbstract;
})(n2, window);