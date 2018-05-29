<?php
namespace PaiCthulhu\FeuerImageEditor;

abstract class gdImageEditor extends imageEditor{

    /**
     * @var int $x
     * @var int $y
     * @var int $angle
     * @var string $font
     * @var float $fontSize
     * @var array $colors
     * @var gdColor $currentColor
     */
    protected $x, $y, $angle, $font, $fontSize, $colors, $currentColor;

    /**
     * gdImageEditor constructor.
     */
    function __construct(){
        $this->x = $this->y = $this->angle = 0;
        $this->fontSize = 16;
    }

    /**
     * gdImageEditor destructor.
     */
    function __destruct() {
        if(isset($this->img))
            imagedestroy($this->img);
    }

    function setXY($x, $y = null){
        $y = isset($y)? $y:$x;
        $this->x = $x;
        $this->y = $y;
        return $this;
    }

    /**
     * @param string $path
     * @return static $this
     */
    function setFont($path){
        $this->font = $path;
        return $this;
    }

    /**
     * @param float $size
     * @return static $this
     */
    function setFontSize($size){
        $this->fontSize = $size;
        return $this;
    }

    function setColor($hex){
        if(!isset($this->colors[$hex]))
            $this->colors[$hex] = gdColor::new($this->img, $hex);
        $this->currentColor = $this->colors[$hex];
        return $this->colors[$hex];
    }

    function defaultColor(){
        if(!isset($this->colors['default']))
            $this->colors['default'] = gdColor::new($this->img, '#000000');
        return $this->colors['default'];
    }

    /**
     * @param string $text
     * @param int $w
     * @param int|null $h
     * @param array $params
     * @return array
     * @throws \Exception
     */
    function drawTextBox($text, $w, $h = null, $params = []){

        $align = $params['align'] ?? Align::LEFT;
        $valign = $params['valign'] ?? Align::TOP;
        $color = $params['color'] ?? null;

        $size = $this->textLength($text);
        switch ($align){
            case Align::CENTER:
                $ax = ceil(($w/2)-($size['width']/2)) + $this->x;
            break;
            case Align::RIGHT:
                $ax = ceil($w-$size['width']) + $this->x;
            break;
            default:
                $ax = $this->x;
            break;
        }

        switch ($valign){
            case Align::MIDDLE:
                $ay= ceil(($h/2)-($size['height']/2)) + $this->y + $size['height'];
                break;
            case Align::BOTTOM:
                $ay = ceil($h-$size['height']) + $this->y +$size['height'];
                break;
            default:
                $ay = $this->y+$size['height'];
                break;
        }

        return $this->stringField($ax, $ay, $text, $color);
    }

    /**
     * @param int $x
     * @param int $y
     * @param string $text
     * @param int|gdColor|null $color
     * @return array
     * @throws \Exception
     */
    protected function stringField($x, $y, $text, $color = null){
        if(!isset($this->font))
            throw new \Exception('Arquivo de fonte não setado!');
        if(!isset($color) || empty($color))
            $color = $this->currentColor->get();
        else if(is_a($color, 'gdColor'))
            $color = $color->get();
        //dump(['image'=>$this->img, 'size'=>$this->fontSize, 'angle'=>$this->angle, 'x'=>$x, 'y'=>$y, 'color'=>$color, 'font'=>$this->font, 'text'=>$text]);
        return imagettftext($this->img, $this->fontSize, $this->angle, $x, $y, $color, $this->font, $text);
    }

    /**
     * @param int $x
     * @param int $y
     * @param string $text
     * @param int $strokeSize
     * @param int|gdColor|null $color
     * @param int|gdColor|null $strokeCollor
     * @return array
     * @throws \Exception
     */
    protected function stringStrokeField($x, $y, $text, $strokeSize = 2, $color = null, $strokeCollor = null){
        if(!isset($this->font))
            throw new \Exception('Arquivo de fonte não setado!');
        if(!isset($color) || empty($color))
            $color = $this->currentColor->get();
        else if(is_a($color, 'gdColor'))
            $color = $color->get();
        if(!isset($strokeCollor) || empty($strokeCollor))
            $strokeCollor = $this->defaultColor()->get();
        else if(is_a($strokeCollor, 'gdColor'))
            $strokeCollor = $strokeCollor->get();
        return $this->imagettfstroketext($this->img, $this->fontSize, $this->angle , $x, $y, $color, $strokeCollor, $this->font, $text, $strokeSize);
    }

    /**
     * @param string $path
     * @return static
     */
    abstract function fileLoad($path);

    /**
     * @param string $path
     * @return static
     */
    abstract function fileSave($path);

    /**
     * @param $path
     * @return gdImageEditor
     */
    static function load($path){
        $img = new static();
        $img->fileLoad($path);
        $img->currentColor = $img->defaultColor();
        return $img;
    }

    function textLength($text){
        $rect = imagettfbbox($this->fontSize, $this->angle, $this->font, $text);
        return ['width'=>($rect[2]-$rect[0]), 'height'=>$rect[1]-$rect[5]];
    }

    private function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
        for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
            for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
                $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
       return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
    }
}

