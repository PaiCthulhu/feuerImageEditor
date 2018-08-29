<?php

namespace PaiCthulhu\FeuerImageEditor\Traits;

trait Shape
{

    /**
     * @var string $backgroundColor
     * @var int $borderWidth
     * @var string $borderColor
     */
    protected $backgroundColor;
    protected $borderWidth;
    protected $borderColor;

    /**
     * @param string|null $hex Hexadecimal of the color
     * @return static $this Return itself to allow chaining
     */
    public function setBGColor($hex)
    {
        $this->backgroundColor = $hex;
        return $this;
    }

    public function getBGColor()
    {
        return $this->backgroundColor;
    }

    public function unsetBGColor()
    {
        $this->strokeWidth = null;
    }

    public function setBorder($width, $color = null)
    {
        $this->setBorderWidth($width);
        if (!empty($color)) {
            $this->setBorderColor($color);
        }
        return $this;
    }

    public function setBorderWidth($w)
    {
        $this->borderWidth = $w;
        return $this;
    }

    public function getBorderWidth()
    {
        return $this->borderWidth;
    }

    public function setBorderColor($hex)
    {
        $this->borderColor = $hex;
        return $this;
    }

    public function getBorderColor()
    {
        return $this->borderColor;
    }

}
