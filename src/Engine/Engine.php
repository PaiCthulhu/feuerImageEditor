<?php
namespace PaiCthulhu\FeuerImageEditor\Engine;

abstract class Engine
{
    protected $empty, $path;

    public function __construct()
    {
        $this->empty = true;
    }

    /**
     * @param string $path
     * @return static
     */
    abstract public function loadFile($path);

    protected function __fileLoad($path)
    {
        $this->empty = false;
        $this->path = $path;
    }
}
