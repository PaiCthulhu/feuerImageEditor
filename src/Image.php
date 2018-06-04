<?php
namespace PaiCthulhu\FeuerImageEditor;

use PaiCthulhu\FeuerImageEditor\Traits\Layered;

class Image extends ImageBase {

    use Layered;

    function  __construct()
    {
        parent::__construct();
    }


    function save($path){
        $this->renderLayers();
        parent::save($path);
    }

    function thumb($path, $size = 512, $quality = 75){
        $thumb = clone $this;
        $thumb->renderLayers()->resize($size)->jpegCompress($quality)->save($path);
        return $this;
    }

}
