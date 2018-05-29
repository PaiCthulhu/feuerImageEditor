<?php

namespace PaiCthulhu\FeuerImageEditor\Stencils\Traits;

trait Shape {

    /**
     * @var string $backgroundColor
     * @var int $borderWidth
     * @var string $borderColor
     */
    protected
        $backgroundColor,
        $borderWidth,
        $borderColor;

    /**
     * @param string|null $hex Hexadecimal of the color
     * @return static $this Return itself to allow chaining
     */
    function setBGColor($hex){
        $this->backgroundColor = $hex;
        return $this;
    }

    function getBGColor(){
        return $this->backgroundColor;
    }

    function unsetBGColor(){
        $this->strokeWidth = null;
    }

    function setBorder($width, $color = null){
        $this->setBorderWidth($width);
        if(!empty($color))
            $this->setBorderColor($color);
        return $this;
    }

    function setBorderWidth($w){
        $this->borderWidth = $w;
        return $this;
    }

    function getBorderWidth(){
        return $this->borderWidth;
    }

    function setBorderColor($hex){
        $this->borderColor = $hex;
        return $this;
    }

    function getBorderColor(){
        return $this->borderColor;
    }

}
