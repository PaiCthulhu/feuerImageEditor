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

    function __clone()
    {
        $this->handle = clone $this->handle;
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

    function getBlob(){
        return $this->handle->getImageBlob();
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

    function scale($width = 0, $height = 0){
        if($width == 0 && $width == $height)
            return $this;
        $this->handle->resizeImage();
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

    /**
     * @param Textbox $tb
     * @return bool
     */
    function drawTextBox(Textbox $tb){
        $draw = new \ImagickDraw();
        $draw->setFillColor(new \ImagickPixel($tb->getColor()));
        $draw->setFontSize($tb->getFontSize());
        $draw->setTextAlignment($this->alignment($tb->horAlign()));
        if(!empty($tb->getStrokeWidth()) && $tb->getStrokeWidth() > 0){
            $color = $tb->getStrokeColor() ?? $tb->getColor();
            $opac  = $tb->getStrokeOpacity() ?? 1;
            $draw->setStrokeWidth($tb->getStrokeWidth());
            $draw->setStrokeColor(new \ImagickPixel($color));
            $draw->setStrokeOpacity($opac);
        }
        $draw->annotation($tb->getX(), $tb->getY(), $tb->getText());
        return $this->handle->drawImage($draw);
    }
}
