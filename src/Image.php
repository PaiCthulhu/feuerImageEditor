<?php
namespace PaiCthulhu\FeuerImageEditor;

use PaiCthulhu\FeuerImageEditor\Traits\Layered;

class Image extends ImageBase
{

    use Layered;

    public function __construct()
    {
        parent::__construct();
    }


    public function save($path)
    {
        $this->renderLayers();
        parent::save($path);
    }

    public function thumb($path, $size = 512, $quality = 75)
    {
        $thumb = clone $this;
        $thumb->renderLayers()->resize($size)->jpegCompress($quality)->save($path);
        return $this;
    }

}
