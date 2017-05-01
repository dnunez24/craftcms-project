<?php

namespace Craft;

class MixPlugin extends BasePlugin
{
    /**
     * Define the plugins name
     *
     * @return string
     */
    public function getName()
    {
        return 'Mix';
    }

    /**
     * Define the plugins description
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Helper plugin for Laravel Mix in Craft templates';
    }

    /**
     * Define the plugins version
     *
     * @return string
     */
    public function getVersion()
    {
        return '0.1.0';
    }

    /**
     * Define the schema version
     *
     * @return string
     */
    public function getSchemaVersion()
    {
        return '0.1.0';
    }

    /**
     * URL to releases.json
     *
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/dnunez24/craft-laravel-mix/master/releases.json';
    }

    /**
     * Documentation URL
     *
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/dnunez24/craft-laravel-mix/blob/master/README.md';
    }

    /**
     * Get the Developer
     *
     * @return string
     */
    public function getDeveloper()
    {
        return 'dnunez24';
    }

    /**
     * Define the developers website.
     *
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'https://davidanunez.com';
    }

    /**
     * Define the plugins settings.
     *
     * @return array
     */
    public function defineSettings()
    {
        return [
            'buildPath' => [
                'type' => AttributeType::String,
                'default' => 'craft',
                'required' => true
            ],
            'publicPath' => [
                'type' => AttributeType::String,
                'default' => 'public',
                'required' => true
            ],
        ];
    }

    /**
     * Get the settings template.
     *
     * @return string
     */
    public function getSettingsHtml()
    {
        return craft()->templates->render(
            'mix/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }

    /**
    * Register Twig extension for use.
    */
    public function addTwigExtension()
    {
        Craft::import('plugins.mix.twigextensions.MixTwigExtension');

        return new MixTwigExtension();
    }
}
