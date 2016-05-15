<?php

class N2SmartSliderFeatureOptimize {

    private $slider;

    private $optimize = false, $thumbnailWidth = 100, $thumbnailHeight = 60;

    public function __construct($slider) {

        $this->slider = $slider;

        $this->optimize        = $slider->params->get('optimize', 0);
        $this->thumbnailWidth  = $slider->params->get('optimizeThumbnailWidth', 100);
        $this->thumbnailHeight = $slider->params->get('optimizeThumbnailHeight', 60);
    }

    public function optimizeBackground($image) {
        if ($this->optimize) {
            try {
                $sizes = $this->slider->assets->sizes;
                return N2Image::resizeImage('resized', N2ImageHelper::fixed($image, true), $sizes['canvasWidth'], $sizes['canvasHeight'], 'normal', 'ffffff', true, true);
            } catch (Exception $e) {
                return $image;
            }
        }
        return $image;
    }

    public function optimizeThumbnail($image) {
        if ($this->optimize) {
            try {
                return N2Image::resizeImage('resized', N2ImageHelper::fixed($image, true), $this->thumbnailWidth, $this->thumbnailHeight, 'normal', 'ffffff', true, true);
            } catch (Exception $e) {
                return $image;
            }
        }
        return $image;
    }
}