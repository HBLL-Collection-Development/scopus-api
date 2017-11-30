<?php
/**
 * Configuration.
 *
 * @author  Jared Howland <scopus@jaredhowland.com>
 *
 * @version 2017-11-29
 *
 * @since 2017-11-27
 */

namespace Scopus;

use Symfony\Component\Yaml\Yaml;

/**
 * Class to get application configuration data
 */
class Config
{
    public static function get($filename = 'config.yml')
    {
        return Yaml::parse(file_get_contents($filename));
    }
}
