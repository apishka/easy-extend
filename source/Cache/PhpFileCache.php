<?php namespace Apishka\EasyExtend\Cache;

use Doctrine\Common\Cache\PhpFileCache as DoctrinePhpFileCache;

/**
 * Php file cache
 *
 * @uses DoctrinePhpFileCache
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class PhpFileCache extends DoctrinePhpFileCache
{
    /**
     * Disallowed character patterns
     *
     * @var string[] regular expressions for replacing disallowed characters in file name
     */

    private $disallowedCharacterPatterns = array(
        '/\-/', // replaced to disambiguate original `-` and `-` derived from replacements
        '/[^a-zA-Z0-9\-_\[\]]/', // also excludes non-ascii chars (not supported, depending on FS)
    );

    /**
     * Replacement characters
     *
     * @var string[] replacements for disallowed file characters
     */

    private $replacementCharacters = array('__', '-');

    /**
     * Get filename
     *
     * @param string $id
     */

    protected function getFilename($id)
    {
        return $this->directory
            . DIRECTORY_SEPARATOR
            . preg_replace($this->disallowedCharacterPatterns, $this->replacementCharacters, $id)
            . $this->getExtension();
    }
}
