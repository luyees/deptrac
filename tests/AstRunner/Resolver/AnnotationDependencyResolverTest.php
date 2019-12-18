<?php

declare(strict_types=1);

namespace Tests\SensioLabs\Deptrac\AstRunner\Resolver;

use PHPUnit\Framework\TestCase;
use SensioLabs\Deptrac\AstRunner\AstParser\AstFileReferenceInMemoryCache;
use SensioLabs\Deptrac\AstRunner\AstParser\NikicPhpParser\FileParser;
use SensioLabs\Deptrac\AstRunner\AstParser\NikicPhpParser\NikicPhpParser;
use SensioLabs\Deptrac\AstRunner\AstParser\NikicPhpParser\ParserFactory;
use SensioLabs\Deptrac\AstRunner\Resolver\AnnotationDependencyResolver;
use SplFileInfo;

class AnnotationDependencyResolverTest extends TestCase
{
    public function testPropertyDependencyResolving(): void
    {
        $parser = new NikicPhpParser(
            new FileParser(ParserFactory::createParser()),
            new AstFileReferenceInMemoryCache(),
            [new AnnotationDependencyResolver()]
        );

        $filePath = __DIR__.'/fixtures/AnnotationDependency.php';
        $astFileReference = $parser->parse(new SplFileInfo($filePath));

        $astClassReferences = $astFileReference->getAstClassReferences();
        $annotationDependency = $astClassReferences[0]->getDependencies();

        static::assertCount(2, $astClassReferences);
        static::assertCount(7, $annotationDependency);
        static::assertCount(0, $astClassReferences[1]->getDependencies());

        static::assertSame(
            'Tests\SensioLabs\Deptrac\Integration\fixtures\AnnotationDependencyChild',
            $annotationDependency[0]->getClass()
        );
        static::assertSame($filePath, $annotationDependency[0]->getFileAppearance()->getFilenpath());
        static::assertSame(9, $annotationDependency[0]->getFileAppearance()->getLine());
        static::assertSame('variable', $annotationDependency[0]->getType());

        static::assertSame(
            'Tests\SensioLabs\Deptrac\Integration\fixtures\AnnotationDependencyChild',
            $annotationDependency[1]->getClass()
        );
        static::assertSame($filePath, $annotationDependency[1]->getFileAppearance()->getFilenpath());
        static::assertSame(23, $annotationDependency[1]->getFileAppearance()->getLine());
        static::assertSame('variable', $annotationDependency[1]->getType());

        static::assertSame(
            'Tests\SensioLabs\Deptrac\Integration\fixtures\AnnotationDependencyChild',
            $annotationDependency[2]->getClass()
        );
        static::assertSame($filePath, $annotationDependency[2]->getFileAppearance()->getFilenpath());
        static::assertSame(26, $annotationDependency[2]->getFileAppearance()->getLine());
        static::assertSame('variable', $annotationDependency[2]->getType());

        static::assertSame(
            'Symfony\Component\Console\Exception\RuntimeException',
            $annotationDependency[3]->getClass()
        );
        static::assertSame($filePath, $annotationDependency[3]->getFileAppearance()->getFilenpath());
        static::assertSame(29, $annotationDependency[3]->getFileAppearance()->getLine());
        static::assertSame('variable', $annotationDependency[3]->getType());

        static::assertSame(
            'Symfony\Component\Finder\SplFileInfo',
            $annotationDependency[4]->getClass()
        );
        static::assertSame($filePath, $annotationDependency[4]->getFileAppearance()->getFilenpath());
        static::assertSame(14, $annotationDependency[4]->getFileAppearance()->getLine());
        static::assertSame('parameter', $annotationDependency[4]->getType());

        static::assertSame(
            'Tests\SensioLabs\Deptrac\Integration\fixtures\AnnotationDependencyChild',
            $annotationDependency[5]->getClass()
        );
        static::assertSame($filePath, $annotationDependency[5]->getFileAppearance()->getFilenpath());
        static::assertSame(14, $annotationDependency[5]->getFileAppearance()->getLine());
        static::assertSame('returntype', $annotationDependency[5]->getType());
    }
}
