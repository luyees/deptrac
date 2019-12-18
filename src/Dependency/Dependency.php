<?php

declare(strict_types=1);

namespace SensioLabs\Deptrac\Dependency;

use SensioLabs\Deptrac\AstRunner\AstMap\FileAppearance;

class Dependency implements DependencyInterface
{
    private $classB;
    private $classA;
    private $fileAppearance;

    public function __construct(string $classA, string $classB, FileAppearance $fileAppearance)
    {
        $this->classA = $classA;
        $this->classB = $classB;
        $this->fileAppearance = $fileAppearance;
    }

    public function getClassA(): string
    {
        return $this->classA;
    }

    public function getClassB(): string
    {
        return $this->classB;
    }

    public function getFileAppearance(): FileAppearance
    {
        return $this->fileAppearance;
    }
}
