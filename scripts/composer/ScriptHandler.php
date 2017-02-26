<?php

namespace Dnunez24\composer;

use Composer\IO\IOInterface;
use Composer\Script\Event;

class ScriptHandler
{
    const DEFAULT_PROJECT_NAME = 'craftcms';

    public static function createDotEnvFile(Event $event)
    {
        $io = $event->getIO();
        $filename = self::getDotEnvFilename();

        self::confirmOverwriteFile($io, $filename);

        $file = fopen($filename, 'w');
        $projectName = self::askProjectName($io);

        fwrite($file, "BASE_URL=http://dev.".$projectName.".com\n");
        fwrite($file, "COMPOSE_PROJECT_NAME=".$projectName."\n");
        fwrite($file, "CACHE_HOST=cache.".$projectName."_private\n");
        fwrite($file, "CACHE_PORT=6379\n");
        fwrite($file, "DB_DRIVER=mysql\n");
        fwrite($file, "DB_SERVER=db.".$projectName."_private\n");
        fwrite($file, "DB_DATABASE=".$projectName."\n");
        fwrite($file, "DB_USER=".$projectName."\n");
        fwrite($file, "DB_PASSWORD=".$projectName."\n");
        fwrite($file, "DB_PORT=3306\n");
        fwrite($file, "SESSION_LOCATION=tcp://session.".$projectName."_private:6379\n");
        fwrite($file, "TZ=UTC\n");
        fclose($file);

    }

    public static function getDotEnvFilename()
    {
        $projectRoot = dirname(dirname(__DIR__));
        $dotEnvBasename = '/.env';
        return $projectRoot.$dotEnvBasename;
    }

    protected static function confirmOverwriteFile(IOInterface $io, $filename)
    {
        $overwrite = true;

        if (file_exists($filename)) {
            $question = "A .env file already exists at the project root. Do you want to overwrite it? ";
            $overwrite = $io->askConfirmation($question);
        }

        $overwrite or exit;
    }

    protected static function askProjectName(IOInterface $io)
    {
        $default = self::DEFAULT_PROJECT_NAME;
        $question = "What is the project name? (default: {$default}) ";
        $attempts = 1;
        $validator = array(get_called_class(), 'validateProjectName');
        return $io->askAndValidate($question, $validator, $attempts, $default);
    }

    public static function validateProjectName($projectName)
    {
        $projectName = self::makeValidProjectName($projectName);

        if (preg_match('/[^\w]/', $projectName)) {
            throw new Exception("Project name must match character class [a-zA-Z0-9_]");
        }

        return $projectName;
    }

    protected static function makeValidProjectName($name)
    {
        return strtolower(preg_replace('/[^\w]/', '_', $name));
    }
}
