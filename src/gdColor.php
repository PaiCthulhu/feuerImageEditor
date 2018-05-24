<?php
namespace PaiCthulhu\FeuerImageEditor;

/**
 * Class gdColor
 * @package FeuerImageEditor
 */
class gdColor {

    /**
     * @var resource $img
     * @var int $color
     * @var string $hex
     */
    private $img, $color, $hex;

    function __construct($img){
        $this->img = $img;
    }

    /**
     * @return int
     * @throws \Exception
     */
    function get(){
        if(!isset($this->color))
            throw new \Exception('Cor não setada!');
        return $this->color;
    }

    /**
     * @param string $hex Hex based RGB color. e.g.: #00FFCC
     * @throws \Exception
     */
    function setColor($hex){
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        $i = imagecolorallocate($this->img, $r, $g, $b);
        if($i === -1)
            throw new \Exception("Erro ao indexar cor \"{$hex}\"");
        $this->hex = $hex;
        $this->color = $i;
    }

    /**
     * @param resource $img
     * @param string $hex
     * @return gdColor
     */
    static function new($img, $hex){
        $c = new static($img);
        $c->setColor($hex);
        return $c;
    }

}