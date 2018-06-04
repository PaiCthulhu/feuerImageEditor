<?php

namespace PaiCthulhu\FeuerImageEditor;

use PaiCthulhu\FeuerImageEditor\Engine\ImagickEngine;

abstract class  ImageBase {

    /**
     * @var Engine $engine
     */
    protected $engine, $width, $height;


    function __construct()
    {
        $this->engine = new ImagickEngine();
    }

    function __clone()
    {
        $this->engine = clone $this->engine;
    }

    function getHandle(){
        return $this->engine->getHandle();
    }

    function base64(){
        return base64_encode($this->engine->getBlob());
    }

    function save($path){
        $this->engine->saveFile($path);
        return $this;
    }

    /**
     * Factory from file
     * @param string $path path to file
     * @return static
     */
    static function open($path){
        $i = new static();
        $i->engine->loadFile($path);
        $i->reloadSize();
        return $i;
    }

    function reloadSize(){
        list($this->width, $this->height) = $this->engine->getSize();
        return $this;
    }

    function resize($width, $height = null){
        $height = $height ?? $width;
        $this->engine->resize($width, $height);
        $this->reloadSize();
        return $this;
    }

    function scale($width = 0, $height = 0){
        if($width == 0 && $width == $height)
            return $this;
        $this->engine->scale($width, $height);
        $this->reloadSize();
        return $this;
    }

    function jpegCompress($quality){
        $this->engine->jpegCompress($quality);
        return $this;
    }

    function thumb($path, $size = 512, $quality = 75){
        $thumb = clone $this;
        $thumb->resize($size)->jpegCompress($quality)->save($path);
        return $this;
    }

}
