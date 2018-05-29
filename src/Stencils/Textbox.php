<?php
namespace PaiCthulhu\FeuerImageEditor\Stencils;

use PaiCthulhu\FeuerImageEditor\Stencils\Traits\Shape;
use PaiCthulhu\FeuerImageEditor\Stencils\Traits\Text;

/**
 * Class Textbox
 * @package PaiCthulhu\FeuerImageEditor\Stencils
 */
class Textbox extends Stencil {

    use Shape;
    use Text;


    function drawFunction()
    {
        return 'drawTextBox';
    }

}
