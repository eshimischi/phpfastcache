<?php

/**
 *
 * This file is part of Phpfastcache.
 *
 * @license MIT License (MIT)
 *
 * For full copyright and license information, please see the docs/CREDITS.txt and LICENCE files.
 *
 * @author Georges.L (Geolim4)  <contact@geolim4.com>
 * @author Contributors  https://github.com/PHPSocialNetwork/phpfastcache/graphs/contributors
 */
declare(strict_types=1);

namespace Phpfastcache\Core\Item;

use Phpfastcache\Exceptions\{PhpfastcacheInvalidArgumentException};

/**
 * Trait TaggableCacheItemTrait
 * @package Phpfastcache\Core\Item
 * @property array $tags The tags array
 * @property array $removedTags The removed tags array
 */
trait TaggableCacheItemTrait
{
    /**
     * @param string[] $tagNames
     * @return ExtendedCacheItemInterface
     */
    public function addTags(array $tagNames): ExtendedCacheItemInterface
    {
        foreach ($tagNames as $tagName) {
            $this->addTag($tagName);
        }

        return $this;
    }

    /**
     * @param string $tagName
     * @return ExtendedCacheItemInterface
     */
    public function addTag(string $tagName): ExtendedCacheItemInterface
    {
        $this->tags = \array_unique(\array_merge($this->tags, [$tagName]));

        return $this;
    }

    /**
     * @param string[] $tags
     * @return ExtendedCacheItemInterface
     * @throws PhpfastcacheInvalidArgumentException
     */
    public function setTags(array $tags): ExtendedCacheItemInterface
    {
        if (\count($tags)) {
            if (\array_filter($tags, 'is_string')) {
                $this->tags = $tags;
            } else {
                throw new PhpfastcacheInvalidArgumentException('$tagName must be an array of string');
            }
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param string $separator
     * @return string
     */
    public function getTagsAsString(string $separator = ', '): string
    {
        return \implode($separator, $this->tags);
    }

    /**
     * @param string[] $tagNames
     * @return ExtendedCacheItemInterface
     */
    public function removeTags(array $tagNames): ExtendedCacheItemInterface
    {
        foreach ($tagNames as $tagName) {
            $this->removeTag($tagName);
        }

        return $this;
    }

    /**
     * @param string $tagName
     * @return ExtendedCacheItemInterface
     */
    public function removeTag(string $tagName): ExtendedCacheItemInterface
    {
        if (($key = \array_search($tagName, $this->tags, true)) !== false) {
            unset($this->tags[$key]);
            $this->removedTags[] = $tagName;
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getRemovedTags(): array
    {
        return \array_diff($this->removedTags, $this->tags);
    }
}
