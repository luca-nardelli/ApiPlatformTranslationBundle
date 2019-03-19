<?php

declare(strict_types=1);

namespace Locastic\Bundle\ApiPlatformTranslationBundle\Tests\Fixtures;

use Locastic\Bundle\ApiPlatformTranslationBundle\Model\AbstractTranslatable;
use Locastic\Bundle\ApiPlatformTranslationBundle\Model\TranslationInterface;

/**
 * Class DummyTranslatable
 *
 * @package Locastic\Bundle\ApiPlatformTranslationBundle\Tests\Fixtures
 */
class DummyTranslatable extends AbstractTranslatable
{
    /**
     * {@inheritdoc}
     */
    protected function createTranslation(): TranslationInterface
    {
        return new DummyTranslation();
    }
}
