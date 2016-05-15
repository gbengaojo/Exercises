(function ($, scope, undefined) {


    function NextendSmartSliderMainAnimationSimple(slider, parameters) {

        this.postBackgroundAnimation = false;
        this._currentBackgroundAnimation = false;

        parameters = $.extend({
            delay: 0,
            parallax: 0.45,
            type: 'horizontal',
            shiftedBackgroundAnimation: 'auto'
        }, parameters);
        parameters.delay /= 1000;

        NextendSmartSliderMainAnimationAbstract.prototype.constructor.apply(this, arguments);

        this.setActiveSlide(this.slider.slides.eq(this.slider.currentSlideIndex));

        this.animations = [];

        switch (this.parameters.type) {
            case 'fade':
                this.animations.push(this._mainAnimationFade);
                break;
            case 'vertical':
                if (this.parameters.parallax == 1) {
                    this.animations.push(this._mainAnimationVertical);
                } else {
                    this.animations.push(this._mainAnimationVerticalParallax);
                }
                break;
            case 'no':
                this.animations.push(this._mainAnimationNo);
                break;
            case 'fade':
                this.animations.push(this._mainAnimationFade);
                break;
            case 'fade':
                this.animations.push(this._mainAnimationFade);
                break;
            default:
                if (this.parameters.parallax == 1) {
                    this.animations.push(this._mainAnimationHorizontal);
                } else {
                    this.animations.push(this._mainAnimationHorizontalParallax);
                }
        }
    };

    NextendSmartSliderMainAnimationSimple.prototype = Object.create(NextendSmartSliderMainAnimationAbstract.prototype);
    NextendSmartSliderMainAnimationSimple.prototype.constructor = NextendSmartSliderMainAnimationSimple;


    NextendSmartSliderMainAnimationSimple.prototype.changeTo = function (currentSlideIndex, currentSlide, nextSlideIndex, nextSlide, reversed, isSystem) {
        if (this.postBackgroundAnimation) {
            this.postBackgroundAnimation.start(currentSlideIndex, nextSlideIndex);
        }

        NextendSmartSliderMainAnimationAbstract.prototype.changeTo.apply(this, arguments);
    };

    /**
     * Used to hide non active slides
     * @param slide
     */
    NextendSmartSliderMainAnimationSimple.prototype.setActiveSlide = function (slide) {
        var notActiveSlides = this.slider.slides.not(slide);
        for (var i = 0; i < notActiveSlides.length; i++) {
            this._hideSlide(notActiveSlides.eq(i));
        }
    };

    /**
     * Hides the slide, but not the usual way. Simply positions them outside of the slider area.
     * If we use the visibility or display property to hide we would end up corrupted YouTube api.
     * If opacity 0 might also work, but that might need additional resource from the browser
     * @param slide
     * @private
     */
    NextendSmartSliderMainAnimationSimple.prototype._hideSlide = function (slide) {
        NextendTween.set(slide.get(0), {
            left: '-100000px'
        });
    };

    NextendSmartSliderMainAnimationSimple.prototype._showSlide = function (slide) {
        NextendTween.set(slide.get(0), {
            left: 0
        });
    };

    NextendSmartSliderMainAnimationAbstract.prototype.cleanSlideIndex = function (slideIndex) {
        this._hideSlide(this.slider.slides.eq(slideIndex));
    };


    NextendSmartSliderMainAnimationSimple.prototype.revertTo = function (slideIndex, originalNextSlideIndex) {

        var originalNextSlide = this.slider.slides.eq(originalNextSlideIndex)
            .css('zIndex', '');
        this._hideSlide(originalNextSlide);

        NextendSmartSliderMainAnimationAbstract.prototype.revertTo.apply(this, arguments);
    };

    NextendSmartSliderMainAnimationSimple.prototype._getAnimation = function () {
        return $.proxy(this.animations[Math.floor(Math.random() * this.animations.length)], this);
    };

    NextendSmartSliderMainAnimationSimple.prototype._initAnimation = function (currentSlideIndex, currentSlide, nextSlideIndex, nextSlide, reversed) {
        var animation = this._getAnimation();

        animation(currentSlide, nextSlide, reversed, currentSlideIndex, nextSlideIndex);
    };

    NextendSmartSliderMainAnimationSimple.prototype.onChangeToComplete = function (previousSlideIndex, currentSlideIndex, isSystem) {

        this._hideSlide(this.slider.slides.eq(previousSlideIndex));

        NextendSmartSliderMainAnimationAbstract.prototype.onChangeToComplete.apply(this, arguments);
    };

    NextendSmartSliderMainAnimationSimple.prototype.onReverseChangeToComplete = function (previousSlideIndex, currentSlideIndex, isSystem) {

        this._hideSlide(this.slider.slides.eq(previousSlideIndex));

        NextendSmartSliderMainAnimationAbstract.prototype.onReverseChangeToComplete.apply(this, arguments);
    };

    NextendSmartSliderMainAnimationSimple.prototype._mainAnimationNo = function (currentSlide, nextSlide) {

        this._showSlide(nextSlide);

        this.slider.unsetActiveSlide(currentSlide);

        nextSlide.css('opacity', 0);

        this.slider.setActiveSlide(nextSlide);

        var totalDuration = this.timeline.totalDuration(),
            extraDelay = this.getExtraDelay();

        if (this._currentBackgroundAnimation && this.parameters.shiftedBackgroundAnimation) {
            if (this._currentBackgroundAnimation.shiftedPreSetup) {
                this._currentBackgroundAnimation._preSetup();
            }
        }

        if (totalDuration == 0) {
            totalDuration = 0.00001;
            extraDelay += totalDuration;
        }

        this.timeline.set(currentSlide, {
            opacity: 0
        }, extraDelay);

        this.timeline.set(nextSlide, {
            opacity: 1
        }, totalDuration);

        this.sliderElement.on('mainAnimationComplete.n2-simple-no', $.proxy(function (e, animation, currentSlideIndex, nextSlideIndex) {
            this.sliderElement.off('mainAnimationComplete.n2-simple-no');
            this.slider.slides.eq(currentSlideIndex)
                .css('opacity', '');
            this.slider.slides.eq(nextSlideIndex)
                .css('opacity', '');
        }, this));
    };

    NextendSmartSliderMainAnimationSimple.prototype._mainAnimationFade = function (currentSlide, nextSlide) {
        currentSlide.css('zIndex', 5);
        this._showSlide(nextSlide);

        this.slider.unsetActiveSlide(currentSlide);
        this.slider.setActiveSlide(nextSlide);

        var adjustedTiming = this.adjustMainAnimation();

        if (this.parameters.shiftedBackgroundAnimation != 0) {
            var needShift = false,
                resetShift = false;
            if (this.parameters.shiftedBackgroundAnimation == 'auto') {
                if (currentSlide.data('slide').$layers.length > 0) {
                    needShift = true;
                } else {
                    resetShift = true;
                }
            } else {
                needShift = true;
            }

            if (this._currentBackgroundAnimation && needShift) {
                this.timeline.shiftChildren(adjustedTiming.outDuration - adjustedTiming.extraDelay);
                if (this._currentBackgroundAnimation.shiftedPreSetup) {
                    this._currentBackgroundAnimation._preSetup();
                }
            } else if (resetShift) {
                this.timeline.shiftChildren(adjustedTiming.extraDelay);
                if (this._currentBackgroundAnimation.shiftedPreSetup) {
                    this._currentBackgroundAnimation._preSetup();
                }
            }
        }

        this.timeline.to(currentSlide.get(0), adjustedTiming.outDuration, {
            opacity: 0,
            ease: this.getEase()
        }, adjustedTiming.outDelay);

        nextSlide.css('opacity', 1);

        this.sliderElement.on('mainAnimationComplete.n2-simple-fade', $.proxy(function (e, animation, currentSlideIndex, nextSlideIndex) {
            this.sliderElement.off('mainAnimationComplete.n2-simple-fade');
            this.slider.slides.eq(currentSlideIndex)
                .css('zIndex', '')
                .css('opacity', '');
            this.slider.slides.eq(nextSlideIndex)
                .css('opacity', '');
        }, this));
    };

    NextendSmartSliderMainAnimationSimple.prototype._mainAnimationHorizontal = function (currentSlide, nextSlide, reversed, currentSlideIndex, nextSlideIndex) {
        this.__mainAnimationDirection(currentSlide, nextSlide, 'horizontal', 1, reversed, currentSlideIndex, nextSlideIndex);
    };

    NextendSmartSliderMainAnimationSimple.prototype._mainAnimationVertical = function (currentSlide, nextSlide, reversed, currentSlideIndex, nextSlideIndex) {
        this._showSlide(nextSlide);
        this.__mainAnimationDirection(currentSlide, nextSlide, 'vertical', 1, reversed, currentSlideIndex, nextSlideIndex);
    };

    NextendSmartSliderMainAnimationSimple.prototype._mainAnimationHorizontalParallax = function (currentSlide, nextSlide, reversed) {
        this.__mainAnimationDirection(currentSlide, nextSlide, 'horizontal', this.parameters.parallax, reversed);
    };

    NextendSmartSliderMainAnimationSimple.prototype._mainAnimationVerticalParallax = function (currentSlide, nextSlide, reversed) {
        this._showSlide(nextSlide);
        this.__mainAnimationDirection(currentSlide, nextSlide, 'vertical', this.parameters.parallax, reversed);
    };

    NextendSmartSliderMainAnimationSimple.prototype.__mainAnimationDirection = function (currentSlide, nextSlide, direction, parallax, reversed, currentSlideIndex, nextSlideIndex) {
        var property = '',
            propertyValue = 0,
            parallaxProperty = '',
            originalPropertyValue = 0;

        if (direction == 'horizontal') {
            property = 'left';
            parallaxProperty = 'width';
            originalPropertyValue = propertyValue = this.slider.dimensions.slideouter.width;
        } else if (direction == 'vertical') {
            property = 'top';
            parallaxProperty = 'height';
            originalPropertyValue = propertyValue = this.slider.dimensions.slideouter.height;
        }

        if (reversed) {
            propertyValue *= -1;
        }

        var inProperties = {
                ease: this.getEase()
            },
            outProperties = {
                ease: this.getEase()
            };
        var from = {};
        if (parallax != 1) {
            if (!reversed) {
                currentSlide.css('zIndex', 6);
                propertyValue *= parallax;
                nextSlide.css(property, propertyValue);
                from[property] = propertyValue;
            } else {
                currentSlide.css('zIndex', 6);
                inProperties[parallaxProperty] = -propertyValue;
                propertyValue *= parallax;
                from[property] = propertyValue;
                from[parallaxProperty] = -propertyValue;
            }
        } else {
            nextSlide.css(property, propertyValue);
            from[property] = propertyValue;
        }

        nextSlide.css('zIndex', 5);

        if (reversed || parallax == 1) {
            currentSlide.css('zIndex', 4);
        }

        this.slider.unsetActiveSlide(currentSlide);
        this.slider.setActiveSlide(nextSlide);

        var adjustedTiming = this.adjustMainAnimation();

        inProperties[property] = 0;

        this.timeline.fromTo(nextSlide.get(0), adjustedTiming.inDuration, from, inProperties, adjustedTiming.inDelay);
        outProperties[property] = -propertyValue;
        if (!reversed && parallax != 1) {
            outProperties[parallaxProperty] = propertyValue;
        }

        if (this.parameters.shiftedBackgroundAnimation != 0) {
            var needShift = false,
                resetShift = false;
            if (this.parameters.shiftedBackgroundAnimation == 'auto') {
                if (currentSlide.data('slide').$layers.length > 0) {
                    needShift = true;
                } else {
                    resetShift = true;
                }
            } else {
                needShift = true;
            }

            if (this._currentBackgroundAnimation && needShift) {
                this.timeline.shiftChildren(adjustedTiming.outDuration - adjustedTiming.extraDelay);
                if (this._currentBackgroundAnimation.shiftedPreSetup) {
                    this._currentBackgroundAnimation._preSetup();
                }
            } else if (resetShift) {
                this.timeline.shiftChildren(adjustedTiming.extraDelay);
                if (this._currentBackgroundAnimation.shiftedPreSetup) {
                    this._currentBackgroundAnimation._preSetup();
                }
            }
        }


        this.timeline.to(currentSlide.get(0), adjustedTiming.outDuration, outProperties, adjustedTiming.outDelay);

        if (this.isTouch && this.isReverseAllowed && parallax == 1) {
            var reverseSlideIndex = reversed ? currentSlideIndex + 1 : currentSlideIndex - 1;
            if (reverseSlideIndex < 0) {
                if (this.slider.parameters.carousel) {
                    reverseSlideIndex = this.slider.slides.length - 1;
                } else {
                    reverseSlideIndex = currentSlideIndex;
                }
            } else if (reverseSlideIndex >= this.slider.slides.length) {
                if (this.slider.parameters.carousel) {
                    reverseSlideIndex = 0;
                } else {
                    reverseSlideIndex = currentSlideIndex;
                }
            }
            this.reverseSlideIndex = reverseSlideIndex;
            if (reverseSlideIndex != nextSlideIndex) {

                if (reverseSlideIndex != currentSlideIndex) {
                    this.enableReverseMode();

                    var reverseSlide = this.slider.slides.eq(reverseSlideIndex);
                    if (direction == 'vertical') {
                        this._showSlide(reverseSlide);
                    }
                    reverseSlide.css(property, propertyValue);
                    var reversedInFrom = {},
                        reversedInProperties = {
                            ease: this.getEase()
                        },
                        reversedOutFrom = {},
                        reversedOutProperties = {
                            ease: this.getEase()
                        };

                    reversedInProperties[property] = 0;
                    reversedInFrom[property] = -propertyValue;
                    reversedOutProperties[property] = propertyValue
                    reversedOutFrom[property] = 0;

                    reverseSlide.trigger('mainAnimationStartIn', [this, currentSlideIndex, reverseSlideIndex, false]);
                    this.reverseTimeline.paused(true);
                    this.reverseTimeline.eventCallback('onComplete', this.onChangeToComplete, [currentSlideIndex, reverseSlideIndex, false], this);

                    this.reverseTimeline.fromTo(reverseSlide.get(0), adjustedTiming.inDuration, reversedInFrom, reversedInProperties, adjustedTiming.inDelay);
                    this.reverseTimeline.fromTo(currentSlide.get(0), adjustedTiming.inDuration, reversedOutFrom, reversedOutProperties, adjustedTiming.inDelay);
                }
            }
        }


        this.sliderElement.on('mainAnimationComplete.n2-simple-fade', $.proxy(function (e, animation, currentSlideIndex, nextSlideIndex) {
            this.sliderElement.off('mainAnimationComplete.n2-simple-fade');
            this.slider.slides.eq(nextSlideIndex)
                .css('zIndex', '')
                .css(property, '');
            this.slider.slides.eq(currentSlideIndex)
                .css('zIndex', '')
                .css(parallaxProperty, originalPropertyValue);
        }, this));
    };

    NextendSmartSliderMainAnimationSimple.prototype.getExtraDelay = function () {
        return 0;
    };

    NextendSmartSliderMainAnimationSimple.prototype.adjustMainAnimation = function () {
        var duration = this.parameters.duration,
            delay = this.parameters.delay,
            backgroundAnimationDuration = this.timeline.totalDuration(),
            extraDelay = this.getExtraDelay();
        if (backgroundAnimationDuration > 0) {
            var totalMainAnimationDuration = duration + delay;
            if (totalMainAnimationDuration > backgroundAnimationDuration) {
                duration = duration * backgroundAnimationDuration / totalMainAnimationDuration;
                delay = delay * backgroundAnimationDuration / totalMainAnimationDuration;
                if (delay < extraDelay) {
                    duration -= (extraDelay - delay);
                    delay = extraDelay;
                }
            } else {
                return {
                    inDuration: duration,
                    outDuration: duration,
                    inDelay: backgroundAnimationDuration - duration,
                    outDelay: extraDelay,
                    extraDelay: extraDelay
                }
            }
        } else {
            delay += extraDelay;
        }
        return {
            inDuration: duration,
            outDuration: duration,
            inDelay: delay,
            outDelay: delay,
            extraDelay: extraDelay
        }
    };

    NextendSmartSliderMainAnimationSimple.prototype.hasBackgroundAnimation = function () {
        return false;
    };

    scope.NextendSmartSliderMainAnimationSimple = NextendSmartSliderMainAnimationSimple;

})(n2, window);