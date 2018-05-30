<?php
namespace PaiCthulhu\FeuerImageEditor;

use PaiCthulhu\FeuerImageEditor\Engine\ImagickEngine;
use PaiCthulhu\FeuerImageEditor\Stencils\Stencil;

class Image {

    protected $engine, $x, $y, $width, $height, $layers;


    function __construct()
    {
        $this->x = $this->y = 0;
        $this->layers = [];
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

    function setXY($x, $y){
        $this->x = $x;
        $this->y = $y;
        return $this;
    }

    function setPos($x, $y = null){
        $y = $y ?? $x;
        return $this->setXY($x, $y);
    }

    function getX(){
        return $this->x;
    }

    function getY(){
        return $this->y;
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
        $thumb->renderLayers()->resize($size)->jpegCompress($quality)->save($path);
        return $this;
    }

    /**
     * @param Stencil|Image $content
     * @return Image $this Return itself to allow chaining
     */
    function addLayer($content = null){
        $this->layers[] = $content;
        return $this;
    }


    /**
     * @return int Returns $this->layers array size
     */
    function layerCount(){
        return count($this->layers);
    }

    /**
     * @return Image $this Return itself to allow chaining
     * @throws \Exception
     */
    function renderLayers(){
        if($this->layerCount() > 0)
        foreach ($this->layers as $i=>$layer){
            if($layer instanceof Stencil)
                if($this->engine->{$layer->drawFunction()}($layer) == true)
                    unset($this->layers[$i]);
                else
                    throw new \Exception('Error on drawing stencil layer '.$i);
            else if($layer instanceof Image)
                if($this->engine->drawImage($layer) == true)
                    unset($this->layers[$i]);
                else
                    throw new \Exception('Error on drawing image layer '.$i);
            else
                throw new \Exception('Layer ('.$i.') format not recognized! Layer data: '.print_r($layer, true));
        }
        return $this;
    }

}
