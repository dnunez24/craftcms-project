<?php

namespace Craft;

class MixVariable
{
    /**
     * Returns the assets version.
     */
    public function version(string $file)
    {
        return craft()->mix->version($file);
    }

    /**
     * Returns the assets version with the appropriate tag.
     */
    public function withTag(string $file)
    {
        return craft()->mix->withTag($file);
    }
}
