<?php

declare(strict_types=1);

namespace Locastic\Bundle\ApiPlatformTranslationBundle\Tests\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Locastic\Bundle\ApiPlatformTranslationBundle\EventListener\AssignLocaleListener;
use Locastic\Bundle\ApiPlatformTranslationBundle\Translation\Translator;
use Locastic\Bundle\ApiPlatformTranslationBundle\Tests\Fixtures\DummyNotTranslatable;
use Locastic\Bundle\ApiPlatformTranslationBundle\Tests\Fixtures\DummyTranslatable;
use Locastic\Bundle\ApiPlatformTranslationBundle\Tests\Fixtures\DummyTranslation;
use PHPUnit\Framework\TestCase;

/**
 * Class AssignLocaleListenerTest
 *
 * @package Locastic\Bundle\ApiPlatformTranslationBundle\Tests\EventListener
 */
class AssignLocaleListenerTest extends TestCase
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @test postLoad
     * @dataProvider provideTranslatableObjects
     */
    public function testPostLoad($object)
    {
        $args = $this->createMock(LifecycleEventArgs::class);
        $this->getObjectInfo($args, $object);
        $this->loadCurrentLocale();

        $assignLocaleSubscriber = new AssignLocaleListener($this->translator);
        $assignLocaleSubscriber->postLoad($args);
    }

    /**
     * @param $args
     * @param $object
     */
    private function getObjectInfo($args, $object)
    {
        $args
            ->expects($this->once())
            ->method('getObject')
            ->willReturn($object);
    }

    private function loadCurrentLocale()
    {
        $this->translator
            ->expects($this->once())
            ->method('loadCurrentLocale')
            ->willReturn($this->defaultLocale);
    }

    /**
     * @test postLoad
     * @dataProvider provideNonTranslatableObjects
     */
    public function testPostLoadNonTranslatableObjects($object)
    {
        $args = $this->createMock(LifecycleEventArgs::class);
        $this->getObjectInfo($args, $object);

        $assignLocaleSubscriber = new AssignLocaleListener($this->translator);
        $assignLocaleSubscriber->postLoad($args);
    }

    /**
     * @test postLoad
     * @dataProvider provideTranslatableObjects
     */
    public function testPrePersist($object)
    {
        $args = $this->createMock(LifecycleEventArgs::class);
        $this->getObjectInfo($args, $object);
        $this->loadCurrentLocale();

        $assignLocaleSubscriber = new AssignLocaleListener($this->translator);
        $assignLocaleSubscriber->prePersist($args);
    }

    /**
     * @test postLoad
     * @dataProvider provideNonTranslatableObjects
     */
    public function testPrePersistNonTranslatableObjects($object)
    {
        $args = $this->createMock(LifecycleEventArgs::class);
        $this->getObjectInfo($args, $object);

        $assignLocaleSubscriber = new AssignLocaleListener($this->translator);
        $assignLocaleSubscriber->postLoad($args);
    }

    /**
     * @return \Generator
     */
    public function provideTranslatableObjects()
    {
        yield[new DummyTranslatable()];
    }

    /**
     * @return \Generator
     */
    public function provideNonTranslatableObjects()
    {
        yield[new DummyNotTranslatable()];
        yield[new DummyTranslation()];
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->translator    = $this->createMock(Translator::class);
        $this->defaultLocale = 'en';
    }
}
