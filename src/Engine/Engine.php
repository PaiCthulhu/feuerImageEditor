<?php
namespace PaiCthulhu\FeuerImageEditor\Engine;

abstract class Engine {

    /**
     * @param string $path
     * @return static
     */
    abstract function loadFile($path);
}

