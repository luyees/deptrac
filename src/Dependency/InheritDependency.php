<?php

declare(strict_types=1);

namespace SensioLabs\Deptrac\Dependency;

use SensioLabs\Deptrac\AstRunner\AstMap\AstInherit;

class InheritDependency implements DependencyInterface
{
    private $classA;
    private $classB;
    private $path;
    private $originalDependency;

    public function __construct(string $classA, string $classB, DependencyInterface $originalDependency, AstInherit $path)
    {
        $this->classA = $classA;
        $this->classB = $classB;
        $this->originalDependency = $originalDependency;
        $this->path = $path;
    }

    public function getClassA(): string
    {
        return $this->classA;
    }

    public function getClassALine(): int
    {
        return 0;
    }

    public function getClassB(): string
    {
        return $this->classB;
    }

    public function getPath(): AstInherit
    {
        return $this->path;
    }

    public function getOriginalDependency(): DependencyInterface
    {
        return $this->originalDependency;
    }
}
