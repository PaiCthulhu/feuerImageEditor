<?php
namespace PaiCthulhu\FeuerImageEditor;

/**
 * Class Textbox
 * @package FeuerImageEditor
 */
class Textbox {

    /**
     * @var int $x
     * @var int $y
     * @var int $width
     * @var int $height
     * @var string $text
     * @var float $angle
     * @var string $font
     * @var int $fontSize
     * @var int $fontSize
     * @var string $color
     */
    protected $x, $y, $width, $height, $text, $angle, $font, $fontSize, $color;

    /**
     * Textbox constructor.
     */
    function __construct(){
        $this->x = $this->y = $this->width = $this->height = $this->angle = $this->fontSize = 0;
        $this->text = '';
        $this->color = '#000000';
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
     * @param int $w Width of the box
     * @param int|null $h Height of the box, if not provided, $w value is used
     * @return static $this Return itself to allow chaining
     */
    function setSize($w, $h = null){
        $h = $h ?? $w;
        $this->width = $w;
        $this->height = $h;
        return $this;
    }

    /**
     * @param string $text Text of this Textbox
     * @return static $this Return itself to allow chaining
     */
    function setText($text){
        $this->text = $text;
        return $this;
    }

    /**
     * @param float $ang Angle in degrees of the text
     * @return static $this Return itself to allow chaining
     */
    function setAngle($ang){
        $this->angle = $ang;
        return $this;
    }

    /**
     * @param string $path Absolute path to the font file
     * @return static $this Return itself to allow chaining
     */
    function setFont($path){
        $this->font = $path;
        return $this;
    }

    /**
     * @param float $size Font size in ???? //TODO findout if is pixels or points
     * @return static $this Return itself to allow chaining
     */
    function setFontSize($size){
        $this->fontSize = $size;
        return $this;
    }

    /**
     * @param string $hex Hexadecimal of the color
     * @return static $this Return itself to allow chaining
     */
    function setColor($hex){
        $this->color = $hex;
        return $this;
    }
}