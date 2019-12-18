<?php

declare(strict_types=1);

namespace Tests\SensioLabs\Deptrac\Dependency;

use PHPUnit\Framework\TestCase;
use SensioLabs\Deptrac\AstRunner\AstMap\AstFileReference;
use SensioLabs\Deptrac\AstRunner\AstMap\FileAppearance;
use SensioLabs\Deptrac\Dependency\Dependency;

class DependencyTest extends TestCase
{
    public function testGetSet(): void
    {
        $dependency = new Dependency('a', 'b', new FileAppearance(new AstFileReference('/foo.php'), 23));
        static::assertEquals('a', $dependency->getClassA());
        static::assertEquals('/foo.php', $dependency->getFileAppearance()->getFilenpath());
        static::assertEquals(23, $dependency->getFileAppearance()->getLine());
        static::assertEquals('b', $dependency->getClassB());
    }
}
