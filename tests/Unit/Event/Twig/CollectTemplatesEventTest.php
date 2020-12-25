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

namespace OmegaCode\JwtSecuredApiTwig\Tests\Unit\Event\Twig;

use OmegaCode\JwtSecuredApiTwig\Event\Twig\CollectTemplatesEvent;
use PHPUnit\Framework\TestCase;

class CollectTemplatesEventTest extends TestCase
{
    protected CollectTemplatesEvent $subject;

    protected function setUp(): void
    {
        $this->subject = new CollectTemplatesEvent();
    }

    /**
     * @test
     * @dataProvider templatePathsProvider
     */
    public function canAddTemplatePaths(string $templatePath)
    {
        $this->subject->addTemplatePath($templatePath);
        $this->assertContains($templatePath, $this->subject->getTemplatePaths());
    }

    /**
     * @test
     */
    public function canRemoveTemplatePaths()
    {
        $templatePath = 'test/templates-1';
        $this->subject->addTemplatePath($templatePath);
        $this->assertContains($templatePath, $this->subject->getTemplatePaths());
        $this->subject->removeTemplatePath($templatePath);
        $this->assertNotContains($templatePath, $this->subject->getTemplatePaths());
    }

    public function templatePathsProvider(): array
    {
        return [
            ['test/templates-1'],
            ['test/templates-3'],
            ['test/templates-4'],
        ];
    }
}
