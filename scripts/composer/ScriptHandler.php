<?php

namespace Copious\Composer;

use Composer\IO\IOInterface;
use Composer\Script\Event;
use Composer\Util\Filesystem;

class ScriptHandler
{
    /**
     * Re-maps Craft plugin files to new location (to handle plugins with
     * incompatible directory structure)
     *
     * @param Event $event Composer script event
     * @return void
     */
    public static function remapCraftPlugins(Event $event)
    {
        $io = $event->getIO();
        $fs = new Filesystem();
        $extra = self::getExtraConfig($event);
        $pluginsPath = self::getPluginsPath($extra);
        $pluginsMap = self::getPluginsMap($extra);

        foreach ($pluginsMap as $src => $dest) {
            $srcParts = explode('/', $src);
            $srcLvl1 = $srcParts[0];
            $srcLvl2 = $srcParts[1];

            $srcRoot = $fs->normalizePath($pluginsPath.$srcLvl1);
            $srcDir = $fs->normalizePath($pluginsPath.$src);
            $destDir = $fs->normalizePath($pluginsPath.$dest);

            if (is_dir($srcDir)) {
                $io->write("Moving $srcDir to $destDir");
                $fs->rename($srcDir, $destDir);

                if ($srcLvl1 !== $srcLvl2) {
                    $fs->removeDirectory($srcRoot);
                }
            }
        }
    }

    protected static function getProjectRoot()
    {
        return dirname(dirname(__DIR__)).'/';
    }

    protected static function getProjectPath(string $path)
    {
        return realpath(self::getProjectRoot().'/'.$path);
    }

    protected static function getExtraConfig(Event $event)
    {
        return $event->getComposer()->getPackage()->getExtra();
    }

    protected static function getPluginsPath(array $extra)
    {
        $pluginsPath = $extra['craft-plugins-path'];

        if (!isset($pluginsPath)) {
            throw new Exception("'extra.craft-plugins-path' composer option must be set.");
        }

        return self::getProjectPath($pluginsPath).'/';
    }

    /**
     * Gets Craft plugin path mappings from Composer config
     *
     * @param array $extra Composer 'extra' config object
     * @return array Map of plugin paths
     */
    protected static function getPluginsMap(array $extra)
    {
        $pluginsMap = $extra['craft-plugins-map'];

        if (!$pluginsMap) {
            return [];
        }

        return $pluginsMap;
    }
}
