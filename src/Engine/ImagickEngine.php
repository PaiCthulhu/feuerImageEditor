<?php
namespace PaiCthulhu\FeuerImageEditor\Engine;

use PaiCthulhu\FeuerImageEditor\Align;
use PaiCthulhu\FeuerImageEditor\Stencils\Textbox;

class ImagickEngine extends Engine
{

    protected $handle;

    /**
     * ImagickEngine constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        if (!extension_loaded('imagick')) {
            throw new \Exception('ImageMagick extension is not available');
        }
        if (!class_exists('\Imagick')) {
            throw new \Exception('ImageMagick class is not available');
        }
        $this->handle = new \Imagick();
    }

    public function __clone()
    {
        $this->handle = clone $this->handle;
    }

    public function getHandle()
    {
        return $this->handle;
    }

    public function isEmpty()
    {
        return $this->empty;
    }

    public function newFile($width, $height)
    {
        $this->handle->newImage($width, $height, "none");
        $this->empty = false;
    }

    public function loadFile($path, $dpi = 72)
    {
        try {
            $this->handle->setResolution($dpi, $dpi);
            $this->handle->readImage($path);
            $this->__fileLoad($path);
        } catch (\Exception $e) {
            throw new \Exception("Can't load file \"{$path}\": {$e->getMessage()}");
        }
        return $this;
    }

    public function saveFile($path = null)
    {
        if($this->empty)
            throw new \Exception("You must load a file do be able to save");
        if(empty($path))
            $path = $this->path;
        $this->handle->writeImage($path);
        return $this;
    }

    public function getAsText()
    {
        return (string) $this->getHandle();
    }

    public function getBlob()
    {
        return $this->handle->getImageBlob();
    }

    public function getSize()
    {
        $s = $this->handle->getImageGeometry();
        return [$s['width'], $s['height']];
    }

    public function resize($width, $height = null)
    {
        $height = $height ?? $width;
        $this->handle->thumbnailImage($width, $height, true);
        return $this;
    }

    public function scale($width = 0, $height = 0)
    {
        if ($width == 0 && $width == $height) {
            return $this;
        }
        $this->handle->resizeImage($width, $height, \Imagick::FILTER_CATROM, 1);
        return $this;
    }

    public function jpegCompress($quality = 92)
    {
        $this->handle->setImageCompression(\Imagick::COMPRESSION_JPEG);
        $this->handle->setImageCompressionQuality($quality);
        return $this;
    }

    public function setFormat($format)
    {
        $this->handle->setFormat($format);
        return $this;
    }

    public function setBGColor($color)
    {
        $this->handle->setImageBackgroundColor($color);
        $this->handle->setImageAlphaChannel(\Imagick::ALPHACHANNEL_REMOVE);
        try {
            $handle = $this->handle->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);
        } catch (\Exception $e) {
            throw new \Exception("Error to set background color: ".$e->getMessage());
        }
        $this->handle = $handle;
        return $this;
    }

    public function setCMYK()
    {
        $this->handle->transformImageColorspace(\Imagick::COLORSPACE_CMYK);
    }

    public function setRGB()
    {
        $this->handle->transformImageColorspace(\Imagick::COLORSPACE_RGB);
    }

    public function setColorProfile($path, $type = "icc")
    {
        $profile = file_get_contents($path);
        if (!$profile) {
            throw new \Exception("Can't load profile \"{$path}\"");
        }
        $this->handle->profileImage($type, $profile);
    }

    public function alignment($align)
    {
        switch ($align) {
            case Align::LEFT:
                return \Imagick::ALIGN_LEFT;
            break;
            case Align::CENTER:
                return \Imagick::ALIGN_CENTER;
            break;
            case Align::RIGHT:
                return \Imagick::ALIGN_RIGHT;
                break;
        }
        return false;
    }

    /**
     * @param \PaiCthulhu\FeuerImageEditor\Image $img
     * @return bool
     *
     */
    public function drawImage($img)
    {
        return $this->handle->compositeImage(
            $img->getHandle(),
            \Imagick::COMPOSITE_DEFAULT,
            $img->getX(),
            $img->getY()
        );
    }

    /**
     * @param Textbox $tb
     * @return bool
     * @throws \Exception
     */
    public function drawTextBox(Textbox $tb)
    {
        $draw = new \ImagickDraw();
        if ($this->getDPI() != 72) {
            $dpiAdj = ($this->getDPI()/72)/2;
            $draw->setResolution(
                $tb->getWidth()/$dpiAdj + ($draw->getFontSize()*$dpiAdj*2.2),
                $tb->getHeight()
            );
        }

        //Shape
        if (!empty($tb->getBGColor()) || (!empty($tb->getBorderWidth()) && $tb->getBorderWidth() > 0)) {
            //Background
            if (!empty($tb->getBGColor())) {
                $bgColor = $tb->getBGColor();
            } else {
                $bgColor = '#00000000';
            }
            $draw->setFillColor(new \ImagickPixel($bgColor));
            //Border
            if (!empty($tb->getBorderWidth()) && $tb->getBorderWidth() > 0) {
                $color = $tb->getBorderColor() ?? $tb->getBGColor();
                $draw->setStrokeWidth($tb->getBorderWidth());
                $draw->setStrokeColor(new \ImagickPixel($color));
            } else {
                $draw->setStrokeWidth(0);
                $draw->setStrokeColor(new \ImagickPixel("#00000000"));
                $draw->setStrokeOpacity(0);
            }

            $x2 = $tb->getX()+$tb->getWidth();
            $y2 = $tb->getY()+$tb->getHeight();
            $draw->rectangle($tb->getX(), $tb->getY(), $x2, $y2);
        }

        //Font
        $draw->setFont($tb->getFont());
        $draw->setFillColor(new \ImagickPixel($tb->getColor()));
        if ($this->getDPI() != 72) {
            $draw->setFontSize(
                self::pixelToPoint($tb->getFontSize(), $this->getDPI())
            );
        } else {
            $draw->setFontSize($tb->getFontSize());
        }
        $draw->setFontWeight($tb->getFontWeight());

        //Stroke
        if (!empty($tb->getStrokeWidth()) && $tb->getStrokeWidth() > 0) {
            $color = $tb->getStrokeColor() ?? $tb->getColor();
            $opac  = $tb->getStrokeOpacity() ?? 1;
            $draw->setStrokeWidth($tb->getStrokeWidth());
            $draw->setStrokeColor(new \ImagickPixel($color));
            $draw->setStrokeOpacity($opac);
        } else {
            $draw->setStrokeWidth(0);
            $draw->setStrokeColor(new \ImagickPixel("#00000000"));
            $draw->setStrokeOpacity(0);
        }

        //Alignment
        $draw->setTextAlignment($this->alignment($tb->horAlign()));
        $x = $tb->getX()+1;
        if ($tb->horAlign() == Align::CENTER) {
            $x += $tb->getWidth() / 2;
        } elseif ($tb->horAlign() == Align::RIGHT) {
            $x += $tb->getWidth() - 1;
        }
        $y = $tb->getY();
        if ($this->getDPI() <= 72) {
            $y += $tb->getFontSize();
        }
        if ($tb->verAlign() == Align::MIDDLE) {
            $y += ($tb->getHeight() - $tb->getFontSize()) / 2;
        } elseif ($tb->verAlign() == Align::BOTTOM) {
            $y = $tb->getY() + $tb->getHeight();
        }


        //Finish
        $text = explode("\r\n", $tb->getText());
        $lines = [];
        foreach ($text as $paragraph){
            $l = $this->wordWrapAnnotation($paragraph, $draw, $tb->getWidth());
            $lines = array_merge($lines, $l[0]);
        }
        $this->handle->annotateImage($draw, $x, $y, 0, implode("\r\n", $lines));


        return $this->handle->drawImage($draw);
    }

    /**
     * @param string $text
     * @param \ImagickDraw $draw
     * @param int $maxWidth
     * @return array
     */
    public function wordWrapAnnotation($text, $draw, $maxWidth)
    {
        $text = trim($text);

        $words = preg_split('%\s%', $text, -1, PREG_SPLIT_NO_EMPTY);
        $lines = [];
        $i = 0;
        $lineHeight = 0;


        while (count($words) > 0) {
            $line = implode(' ', array_slice($words, 0, ++$i));
            $metrics = $this->handle->queryFontMetrics($draw, $line);
            $lineHeight = max($metrics['textHeight'], $lineHeight);

            // check if we have found the word that exceeds the line width
            if ($metrics['textWidth'] > $maxWidth or count($words) < $i) {
                // handle case where a single word is longer than the allowed line width
                // (just add this as a word on its own line?)
                if ($i == 1)
                    $i++;

                $lines[] = implode(' ', array_slice($words, 0, --$i));
                $words = array_slice($words, $i);
                $i = 0;
            }
        }

        return [$lines, $lineHeight];
    }

    public function getColorspace()
    {
        if ($this->empty) {
            throw new \Exception("No image loaded. You must open a file to get its information");
        }

        $info = $this->handle->identifyImage();
        return $info["colorSpace"];
    }

    public function getDPI()
    {
        if ($this->empty) {
            throw new \Exception("No image loaded. You must open a file to get its information");
        }
        $info = $this->handle->identifyImage();
        if (isset($info['units'], $info['resolution']) && $info['units'] == "PixelsPerInch"
            && is_array($info['resolution'])) {
            return $info["resolution"]["y"];
        } else {
            return self::forceGetDPI($this->path);
        }
    }

    public static function forceGetDPI($path)
    {
        $cmd = 'identify -quiet -format "%x" '.$path;
        @exec(escapeshellcmd($cmd), $data);
        if ($data && is_array($data)) {
            $data = explode(' ', $data[0]);

            if (!isset($data[1]) || $data[1] == 'Undefined') {
                return $data[0];
            } elseif ($data[1] == 'PixelsPerInch') {
                return $data[0];
            } elseif ($data[1] == 'PixelsPerCentimeter') {
                $x = ceil($data[0] * 2.54);
                return $x;
            }
        }
        return 72;
    }

    public static function pixelToPoint($size, $dpi)
    {
        return 72/$dpi * $size;
    }

}
