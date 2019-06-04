<?php
namespace PaiCthulhu\FeuerImageEditor\Engine;

abstract class Engine
{
    protected $empty;

    public function __construct()
    {
        $this->empty = true;
    }

    /**
     * @param string $path
     * @return static
     */
    abstract public function loadFile($path);
}
