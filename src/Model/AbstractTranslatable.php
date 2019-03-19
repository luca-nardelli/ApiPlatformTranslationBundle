<?php

declare(strict_types=1);

namespace Locastic\Bundle\ApiPlatformTranslationBundle\Model;

/**
 * Class AbstractTranslatable
 *
 * @package Locastic\ApiPlatformTranslationBundle\Model
 */
abstract class AbstractTranslatable implements TranslatableInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    /**
     * AbstractTranslatable constructor.
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->initializeTranslationsCollection();
    }
}
