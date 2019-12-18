<?php

declare(strict_types=1);

namespace Tests\SensioLabs\Deptrac\Dependency;

use PHPUnit\Framework\TestCase;
use SensioLabs\Deptrac\AstRunner\AstMap\AstFileReference;
use SensioLabs\Deptrac\AstRunner\AstMap\AstInherit;
use SensioLabs\Deptrac\AstRunner\AstMap\FileAppearance;
use SensioLabs\Deptrac\Dependency\Dependency;
use SensioLabs\Deptrac\Dependency\InheritDependency;

class InheritDependencyTest extends TestCase
{
    public function testGetSet(): void
    {
        $fileAppearance = new FileAppearance(new AstFileReference('a.php'), 1);
        $dependency = new InheritDependency(
            'a',
            'b',
            $dep = new Dependency('a', 'b', $fileAppearance),
            $astInherit = AstInherit::newExtends('b', $fileAppearance)
        );

        static::assertEquals('a', $dependency->getClassA());
        static::assertEquals('b', $dependency->getClassB());
        static::assertEquals(1, $dependency->getFileAppearance()->getLine());
        static::assertEquals($dep, $dependency->getOriginalDependency());
        static::assertSame($astInherit, $dependency->getInheritPath());
    }
}
