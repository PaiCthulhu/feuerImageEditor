<?php
namespace PaiCthulhu\FeuerImageEditor;

use PaiCthulhu\FeuerImageEditor\Engine\ImagickEngine;
use PaiCthulhu\FeuerImageEditor\Stencils\Stencil;

class Image {

    protected $engine, $width, $height, $layers;


    function __construct()
    {
        $this->layers = [];
        $this->engine = new ImagickEngine();
    }

    function save($path){
        $this->renderLayers();
        $this->engine->saveFile($path);
        return $this;
    }

    /**
     * Factory from file
     * @param string $path path to file
     * @return Image
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
        return $this;
    }


    function jpegCompress($quality){
        $this->engine->jpegCompress($quality);
        return $this;
    }

    function thumb($path, $size = 512, $quality = 75){
        $this->resize($size)->jpegCompress($quality)->save($path);
        return $this;
    }

    /**
     * @param Stencil $content
     */
    function addLayer($content = null){
        $this->layers[] = $content;
    }


    /**
     * @return int Returns $this->layers array size
     */
    function layerCount(){
        return count($this->layers);
    }

    protected function renderLayers(){
        if($this->layerCount() > 0)
        foreach ($this->layers as $layer){
            if($layer instanceof Stencil)
                $this->engine->{$layer->drawFunction()}($layer);
        }
    }

}
