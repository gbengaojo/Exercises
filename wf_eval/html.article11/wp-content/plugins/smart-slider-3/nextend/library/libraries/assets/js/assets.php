<?php

/**
 * Class N2AssetsJs
 *
 */
class N2AssetsJs extends N2AssetsAbstract
{

    public function __construct() {
        $this->cache = new N2AssetsCacheJS();
    }

    public function getOutput() {

        $output = "";

        $globalInline = $this->getGlobalInlineScripts();
        if (!empty($globalInline)) {
            $output .= N2Html::script($globalInline . "\n");
        }

        foreach ($this->urls AS $url) {
            $output .= N2Html::script($url, true) . "\n";
        }

        if (!N2Platform::$isAdmin && N2Settings::get('async', '0')) {
            $jsCombined = new N2CacheCombine('js', N2Settings::get('minify-js', '0') ? 'N2MinifierJS::minify' : false);
            foreach ($this->getFiles() AS $file) {
                if (basename($file) == 'n2.js') {
                    $output .= N2Html::script(N2Uri::pathToUri($file) . '?' . filemtime($file), true) . "\n";
                } else {
                    $jsCombined->add($file);
                }
            }
            $combinedFile = $jsCombined->make();
            $scripts      = 'nextend.loadScript("' . N2Uri::pathToUri($combinedFile) . '?' . filemtime($combinedFile) . '");';
            $output .= N2Html::script($scripts . "\n");
        } else {
            if (!N2Platform::$isAdmin && N2Settings::get('combine-js', '0')) {
                $jsCombined = new N2CacheCombine('js', N2Settings::get('minify-js', '0') ? 'N2MinifierJS::minify' : false);
                foreach ($this->getFiles() AS $file) {
                    $jsCombined->add($file);
                }
                $combinedFile = $jsCombined->make();
                $output .= N2Html::script(N2Uri::pathToUri($combinedFile) . '?' . filemtime($combinedFile), true) . "\n";
            } else {
                foreach ($this->getFiles() AS $file) {
                    $output .= N2Html::script(N2Uri::pathToUri($file) . '?' . filemtime($file), true) . "\n";
                }
            }
        }

        $output .= N2Html::script(N2Localization::toJS() . "\n" . $this->getInlineScripts() . "\n");
        return $output;
    }

    public function get() {
        return array(
            'url'          => $this->urls,
            'files'        => $this->getFiles(),
            'inline'       => $this->getInlineScripts(),
            'globalInline' => $this->getGlobalInlineScripts()
        );
    }

    public function getAjaxOutput() {

        //$output = $this->getFilesRaw() . "\n";

        $output = $this->getInlineScripts();

        return $output;
    }

    private function getGlobalInlineScripts() {
        return implode('', $this->globalInline);
    }

    private function getInlineScripts() {
        $scripts = '';

        foreach ($this->firstCodes AS $script) {
            $scripts .= $script . "\n";
        }

        foreach ($this->inline AS $script) {
            $scripts .= $script . "\n";
        }

        return $this->serveJquery($scripts);
    }

    public static function serveJquery($script) {
        if (empty($script)) {
            return "";
        }
        $inline = "window.n2jQuery.ready((function($){\n";
        $inline .= "\twindow.nextend.ready(function() {\n";
        $inline .= $script;
        $inline .= "\t});\n";
        $inline .= "}));\n";

        return $inline;
    }
} 