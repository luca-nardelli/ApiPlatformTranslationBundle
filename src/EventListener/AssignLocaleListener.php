<?php

declare(strict_types=1);

namespace Locastic\Bundle\ApiPlatformTranslationBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Locastic\Bundle\ApiPlatformTranslationBundle\Model\TranslatableInterface;
use Locastic\Bundle\ApiPlatformTranslationBundle\Translation\Translator;

/**
 * Class AssignLocaleListener
 *
 * @package Locastic\Bundle\ApiPlatformTranslationBundle\EventListener
 */
class AssignLocaleListener
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * AssignLocaleListener constructor.
     *
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args): void
    {
        $this->assignLocale($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->assignLocale($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    private function assignLocale(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();

        if (!$object instanceof TranslatableInterface) {
            return;
        }

        $localeCode = $this->translator->loadCurrentLocale();

        $object->setCurrentLocale($localeCode);
        $object->setFallbackLocale($localeCode);
    }
}
