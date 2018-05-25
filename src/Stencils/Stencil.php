<?php
namespace PaiCthulhu\FeuerImageEditor\Stencils;

/**
 * Class Stencil
 * @package PaiCthulhu\FeuerImageEditor\Stencils
 */
abstract class Stencil {

    /**
     * @var int $x
     * @var int $y
     * @var int $width
     * @var int $height
     */
    protected $x, $y, $width, $height;

    /**
     * Stencil constructor.
     */
    function __construct()
    {
        $this->x = $this->y = $this->width = $this->height = 0;
    }

    /**
     * @param int $x Position on the Horizontal(X) axis
     * @param int|null $y Position on the Vertical(Y) axis, if not provided, $x value is used
     * @return static $this Return itself to allow chaining
     */
    function setXY($x, $y = null){
        $y = $y ?? $x;
        $this->x = $x;
        $this->y = $y;
        return $this;
    }

    /**
     * Alias for Stencil::setXY()
     * @see Stencil::setXY()
     */
    function setPos($x, $y = null){
        return $this->setXY($x, $y);
    }

    /**
     * @return int
     */
    function getX(){
        return $this->x;
    }

    /**
     * @return int
     */
    function getY(){
        return $this->y;
    }

    /**
     * @param int $width Width of the box
     * @param int|null $height Height of the box, if not provided, $width value is used
     * @return static $this Return itself to allow chaining
     */
    function setSize($width, $height = null){
        $height = $height ?? $width;
        $this->width = $width;
        $this->height = $height;
        return $this;
    }

    /**
     * Return the name of the Engine's draw function
     * @return string
     */
    abstract function drawFunction();
}
