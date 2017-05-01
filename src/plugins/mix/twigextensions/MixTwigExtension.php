<?php
namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;

class MixTwigExtension extends \Twig_Extension
{
    /**
    * Returns the extension name.
    *
    * @return string
    */
    public function getName()
    {
        return 'Mix';
    }

    /**
    * Returns the extensions filters.
    *
    * @return array
    */
    public function getFilters()
    {
        return [
            'mix' => new Twig_Filter_Method(
                $this, 'mix'
            ),
        ];
    }

    /**
    * Returns the extensions functions.
    *
    * @return string
    */
    public function getFunctions()
    {
        return [
            'mix' => new Twig_Function_Method(
                $this, 'mix'
            ),
        ];
    }

    /**
    * Returns versioned asset or the asset with tag.
    *
    * @param $file
    * @param bool $tag
    * @return mixed
    */
    public function mix($file, $tag = false)
    {
        if ($tag) {
            return craft()->mix->withTag($file);
        }
        return craft()->mix->version($file);
    }
}
