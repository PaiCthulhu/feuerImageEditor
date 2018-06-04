<?php
namespace PaiCthulhu\FeuerImageEditor\Stencils;

use PaiCthulhu\FeuerImageEditor\Traits\Shape;
use PaiCthulhu\FeuerImageEditor\Traits\Text;

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
