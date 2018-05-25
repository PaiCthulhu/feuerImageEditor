<?php
namespace PaiCthulhu\FeuerImageEditor;

/**
 * Class imageEditor
 * @package FeuerImageEditor
 */
abstract class imageEditor {

    protected $path, $img;

    function path(){
        return $this->path;
    }

    function relPath(){
        return str_replace(ROOT, PATH, $this->path);
    }

}