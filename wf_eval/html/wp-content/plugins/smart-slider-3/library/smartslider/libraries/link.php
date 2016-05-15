<?php
N2Loader::import('libraries.link.link');

class N2LinkNextSlide
{

    public static function parse($argument, &$attributes, $isEditor = false) {
        if (!$isEditor) {
            $attributes['onclick'] = "n2ss.applyAction(this, 'next'); return false";
        }
        return '#';
    }
}

class N2LinkPreviousSlide
{

    public static function parse($argument, &$attributes, $isEditor = false) {
        if (!$isEditor) {
            $attributes['onclick'] = "n2ss.applyAction(this, 'previous'); return false";
        }
        return '#';
    }
}

class N2LinkGoToSlide
{

    public static function parse($argument, &$attributes, $isEditor = false) {
        if (!$isEditor) {
            $attributes['onclick'] = "n2ss.applyAction(this, 'slide', " . intval($argument) . "); return false";
        }
        return '#';
    }
}

class N2LinkToSlide
{

    public static function parse($argument, &$attributes, $isEditor = false) {
        if (!$isEditor) {
            $attributes['onclick'] = "n2ss.applyAction(this, 'slide', " . (intval($argument) - 1) . "); return false";
        }
        return '#';
    }
}

class N2LinkSlideEvent
{

    public static function parse($argument, &$attributes, $isEditor = false) {
        if (!$isEditor) {
            $attributes['onclick'] = "n2ss.trigger(this, '" . $argument . "'); return false";
        }
        return '#';
    }
}