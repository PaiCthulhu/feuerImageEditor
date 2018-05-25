<?php
namespace PaiCthulhu\FeuerImageEditor\Engine;

use PaiCthulhu\FeuerImageEditor\Align;
use PaiCthulhu\FeuerImageEditor\Stencils\Textbox;

class ImagickEngine extends Engine {

    protected $handle;

    function __construct()
    {
        if(!extension_loaded('imagick'))
            throw new \Exception('ImageMagick is not available');
        $this->handle = new \Imagick();

    }

    function loadFile($path)
    {
        $this->handle->readImage($path);
        return $this;
    }

    function saveFile($path){
        $this->handle->writeImage($path);
        return $this;
    }

    function getSize(){
        $s = $this->handle->getImageGeometry();
        return [$s['width'], $s['height']];
    }

    function resize($width, $height = null){
        $height = $height ?? $width;
        $this->handle->thumbnailImage($width, $height, true, true);
        return $this;
    }

    function jpegCompress($quality = 92){
        $this->handle->setImageCompression(\Imagick::COMPRESSION_JPEG);
        $this->handle->setImageCompressionQuality($quality);
        return $this;
    }

    function alignment($align){
        switch ($align){
            case Align::LEFT: return \Imagick::ALIGN_LEFT;break;
            case Align::CENTER: return \Imagick::ALIGN_CENTER;break;
            case Align::RIGHT: return \Imagick::ALIGN_RIGHT;break;
        }
        return false;
    }

    function drawTextBox(Textbox $tb){
        $draw = new \ImagickDraw();
        $draw->setFillColor(new \ImagickPixel($tb->getColor()));
        $draw->setFontSize($tb->getFontSize());
        $draw->setTextAlignment($this->alignment($tb->horAlign()));
        $draw->annotation($tb->getX(), $tb->getY(), $tb->getText());
        return $this->handle->drawImage($draw);
    }
}
