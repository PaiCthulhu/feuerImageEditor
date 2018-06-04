<?php
namespace PaiCthulhu\FeuerImageEditor\Stencils;

use PaiCthulhu\FeuerImageEditor\ImageBase;

class ImageLayer extends ImageBase{

    protected $x, $y;


    function __construct()
    {
        parent::__construct();
        $this->x = $this->y = 0;
        $this->layers = null;
    }

    /**
     * @param int $x
     * @param int $y
     * @return static $this Return itself to allow chaining
     */
    function setXY($x, $y){
        $this->x = $x;
        $this->y = $y;
        return $this;
    }

    /**
     * @param int $x
     * @param int|null $y
     * @return ImageLayer $this Return itself to allow chaining
     */
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

}
