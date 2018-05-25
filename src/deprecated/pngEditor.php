<?php
namespace PaiCthulhu\FeuerImageEditor;

class pngEditor extends gdImageEditor {

    /**
     * @param string $path
     * @return $this|gdImageEditor
     * @throws \Exception
     */
    function fileLoad($path){
        $img = @imagecreatefrompng($path);
        if($img === false)
            throw new \Exception("Erro ao carregar imagem \"{$path}\"");
        $this->path = $path;
        $this->img = $img;
        return $this;
    }

    /**
     * @param string $path
     * @return static $this
     * @throws \Exception
     */
    function fileSave($path){
        $r = imagepng($this->img, $path);
        if($r === false)
            throw new \Exception("Falha ao salvar arquivo em \"{$path}\"");

        return $this;
    }



}