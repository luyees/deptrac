<?php

declare(strict_types=1);

namespace SensioLabs\Deptrac\AstRunner\AstMap;

class AstDependency
{
    private $class;
    private $fileAppearance;
    private $type;

    public function __construct(string $class, FileAppearance $fileAppearance, string $type)
    {
        $this->class = $class;
        $this->fileAppearance = $fileAppearance;
        $this->type = $type;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getFileAppearance(): FileAppearance
    {
        return $this->fileAppearance;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public static function useStmt(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'use');
    }

    public static function returnType(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'returntype');
    }

    public static function parameter(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'parameter');
    }

    public static function newStmt(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'new');
    }

    public static function staticProperty(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'static_property');
    }

    public static function staticMethod(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'static_method');
    }

    public static function instanceofExpr(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'instanceof');
    }

    public static function catchStmt(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'catch');
    }

    public static function variable(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'variable');
    }

    public static function throwStmt(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'throw');
    }

    public static function constFetch(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'const');
    }

    public static function anonymousClassExtends(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'anonymous_class_extends');
    }

    public static function anonymousClassImplements(string $class, FileAppearance $fileAppearance): self
    {
        return new self($class, $fileAppearance, 'anonymous_class_implements');
    }
}
