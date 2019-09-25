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
     * @param int $dpi
     * @return static
     */
    abstract public function loadFile($path, $dpi = 72);

    protected function __fileLoad($path)
    {
        $this->empty = false;
        $this->path = $path;
    }
}
