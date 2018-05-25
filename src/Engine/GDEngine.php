<?php
namespace PaiCthulhu\FeuerImageEditor\Engine;

class GDEngine extends Engine {

    protected $handle;

    function __construct()
    {
        if(!extension_loaded('gd'))
            throw new \Exception('GD is not available');
    }

    function loadFile()
    {
        // TODO: Implement loadFile() method.
    }
}
