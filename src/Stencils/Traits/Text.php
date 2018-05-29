<?php
namespace PaiCthulhu\FeuerImageEditor\Stencils\Traits;

use PaiCthulhu\FeuerImageEditor\Align;

trait Text {
    /**
     * @var string $fontFile
     * @var int $fontSize
     * @var string $color
     * @var float $angle
     * @var string $text
     * @var string $hAlign
     * @var string $vAlign
     * @var string $strokeColor
     * @var int $strokeWidth
     * @var float $strokeOpacity
     */
    protected
        $fontFile,
        $fontSize,
        $color,
        $angle,
        $text,
        $hAlign,
        $vAlign,
        $strokeColor,
        $strokeWidth,
        $strokeOpacity;

    /**
     * Text constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->fontSize = $this->angle = $this->strokeWidth = 0;
        $this->strokeOpacity = 1;
        $this->color = '#000000';
        $this->hAlign = Align::LEFT;
        $this->vAlign = Align::TOP;
    }

    /**
     * @param string $path Absolute path to the font file
     * @param float|null $size Font size in pixels
     * @return static $this Return itself to allow chaining
     * @throws \Exception
     */
    function setFont($path, $size = null){
        if(!file_exists($path))
            throw new \Exception("File \"{$path}\" not found!");
        $this->fontFile = $path;
        if(isset($size) && !empty($size))
            $this->setFontSize($size);
        return $this;
    }

    function getFont(){
        return $this->fontFile;
    }

    /**
     * @param float $size Font size in pixels
     * @return static $this Return itself to allow chaining
     * @throws \Exception
     */
    function setFontSize($size){
        if(!($size > 0))
            throw new \Exception("{$size} is not a valid font size");
        $this->fontSize = $size;
        return $this;
    }

    function getFontSize(){
        return $this->fontSize;
    }

    /**
     * @param string $hex Hexadecimal of the color
     * @return static $this Return itself to allow chaining
     */
    function setColor($hex){
        $this->color = $hex;
        return $this;
    }

    function getColor(){
        return $this->color;
    }

    function setStrokeColor($hex){
        $this->strokeColor = $hex;
        return $this;
    }

    function getStrokeColor(){
        return $this->strokeColor;
    }

    /**
     * @param int $w Width, in pixels of the text stroke
     * @return static $this Return itself to allow chaining
     */
    function setStrokeWidth($w){
        $this->strokeWidth = $w;
        return $this;
    }

    /**
     * @return int
     */
    function getStrokeWidth(){
        return $this->strokeWidth;
    }

    /**
     * @param float $opac A number from 0 to 1, being 0 fully transparent and 1 fully opaque
     * @return static $this Return itself to allow chaining
     */
    function setStrokeOpacity($opac){
        $opac = ($opac >= 0 && $opac <= 1)? $opac:1;
        $this->strokeOpacity = $opac;
        return $this;
    }

    /**
     * @return float
     */
    function getStrokeOpacity(){
        return $this->strokeOpacity;
    }

    function setStroke($width, $color = null, $opacity = null){
        $color = $color ?? $this->getColor();
        $opacity = $opacity ?? 1;
        $this->setStrokeWidth($width)->setStrokeColor($color);
        return $this;
    }

    function getStroke(){
        return [
            'width'=>$this->getStrokeWidth(),
            'color'=>$this->getStrokeColor(),
            'opacity'=>$this->getStrokeOpacity()
        ];
    }

    function unsetStroke(){
        $this->strokeWidth = null;
        $this->strokeColor = $this->color;
        $this->strokeOpacity = 1;
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

    function getAngle(){
        return $this->angle;
    }

    /**
     * @param string $text Text of this static
     * @return static $this Return itself to allow chaining
     */
    function setText($text){
        $this->text = $text;
        return $this;
    }

    function getText(){
        return $this->text;
    }

    /**
     * @param string $align
     * @return static $this Return itself to allow chaining
     * @throws \Exception
     */
    function setHorizontalAlign($align){
        if($align !== Align::LEFT && $align !== Align::CENTER && $align !== Align::RIGHT)
            throw new \Exception("Invalid \"{$align}\" for horizontal alignment");
        $this->hAlign = $align;
        return $this;
    }

    function horAlign(){
        return $this->hAlign;
    }

    /**
     * @param string $align
     * @return static $this Return itself to allow chaining
     * @throws \Exception
     */
    function setVerticalAlign($align){
        if($align !== Align::TOP && $align !== Align::MIDDLE && $align !== Align::BOTTOM)
            throw new \Exception("Invalid \"{$align}\" for vertical alignment");
        $this->vAlign = $align;
        return $this;
    }

    function verAlign(){
        return $this->vAlign;
    }

    /**
     * @param string $horizontal
     * @param string $vertical
     * @return static $this
     * @throws \Exception
     */
    function setAlignment($horizontal, $vertical){
        $this->setHorizontalAlign($horizontal)->setVerticalAlign($vertical);
        return $this;
    }

    function getAlignment(){
        return [$this->hAlign, $this->vAlign];
    }
}
