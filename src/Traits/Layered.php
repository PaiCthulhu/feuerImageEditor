<?php

namespace PaiCthulhu\FeuerImageEditor\Traits;

use \PaiCthulhu\FeuerImageEditor\Stencils;

trait Layered {

    /**
     * @var array $layers
     */
    protected $layers;

    function __construct()
    {
        $this->layers = [];
    }

    /**
     * @param Stencils\Stencil|Stencils\ImageLayer $content
     * @return static $this Return itself to allow chaining
     */
    function addLayer($content = null){
        $this->layers[] = $content;
        return $this;
    }


    /**
     * @return int Returns $this->layers array size
     */
    function layerCount(){
        if(empty($this->layers))
            return 0;
        return count($this->layers);
    }

    /**
     * @return static $this Return itself to allow chaining
     * @throws \Exception
     */
    function renderLayers(){
        if($this->layerCount() > 0)
            foreach ($this->layers as $i=>$layer){
                if($layer instanceof Stencils\Stencil)
                    if($this->engine->{$layer->drawFunction()}($layer) == true)
                        unset($this->layers[$i]);
                    else
                        throw new \Exception('Error on drawing stencil layer '.$i);
                else if($layer instanceof Stencils\ImageLayer)
                    if($this->engine->drawImage($layer) == true)
                        unset($this->layers[$i]);
                    else
                        throw new \Exception('Error on drawing image layer '.$i);
                else
                    throw new \Exception('Layer ('.$i.') format not recognized! Layer data: '.print_r($layer, true));
            }
        return $this;
    }
}
