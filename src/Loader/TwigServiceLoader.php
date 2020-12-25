<?php

/**
 * MIT License
 *
 * Copyright (c) 2020 Wolf Utz<wpu@hotmail.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace OmegaCode\JwtSecuredApiTwig\Loader;

use OmegaCode\JwtSecuredApiTwig\Event\Twig\CollectTemplatesEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigServiceLoader
{
    protected const CACHE_DIRECTORY = APP_ROOT_PATH . '/var/cache/twig';

    protected const DEFAULT_TEMPLATE_DIRECTORY = APP_ROOT_PATH . '/res/templates';

    public function load(ContainerInterface $container, EventDispatcher $eventDispatcher): void
    {
        $templateDirectories = [self::DEFAULT_TEMPLATE_DIRECTORY];

        $event = new CollectTemplatesEvent($templateDirectories);
        $eventDispatcher->dispatch($event, CollectTemplatesEvent::NAME);

        $twig = new Environment(new FilesystemLoader($event->getTemplatePaths()), [
            'cache' => ($_ENV['APP_ENV'] === 'prod' ? self::CACHE_DIRECTORY : false),
        ]);
        $container->set(Environment::class, $twig);
    }
}
