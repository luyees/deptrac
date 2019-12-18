<?php

declare(strict_types=1);

namespace Tests\SensioLabs\Deptrac\OutputFormatter;

use PHPUnit\Framework\TestCase;
use SensioLabs\Deptrac\AstRunner\AstMap\AstFileReference;
use SensioLabs\Deptrac\AstRunner\AstMap\AstInherit;
use SensioLabs\Deptrac\AstRunner\AstMap\FileAppearance;
use SensioLabs\Deptrac\Dependency\Dependency;
use SensioLabs\Deptrac\Dependency\InheritDependency;
use SensioLabs\Deptrac\OutputFormatter\JUnitOutputFormatter;
use SensioLabs\Deptrac\OutputFormatter\OutputFormatterInput;
use SensioLabs\Deptrac\RulesetEngine\Context;
use SensioLabs\Deptrac\RulesetEngine\SkippedViolation;
use SensioLabs\Deptrac\RulesetEngine\Violation;
use Symfony\Component\Console\Output\BufferedOutput;

class JUnitOutputFormatterTest extends TestCase
{
    private static $actual_junit_report_file = 'actual-junit-report.xml';

    public function tearDown(): void
    {
        if (file_exists(__DIR__.'/data/'.static::$actual_junit_report_file)) {
            unlink(__DIR__.'/data/'.static::$actual_junit_report_file);
        }
    }

    public function testGetName(): void
    {
        static::assertSame('junit', (new JUnitOutputFormatter())->getName());
    }

    public function basicDataProvider(): iterable
    {
        yield [
            [
                new Violation(
                    new InheritDependency(
                        'ClassA',
                        'ClassB',
                        new Dependency('OriginalA', 'OriginalB', new FileAppearance(new AstFileReference('foo.php'), 12)),
                        AstInherit::newExtends('ClassInheritA', new FileAppearance(new AstFileReference('foo.php'), 3))->withPath([
                            AstInherit::newExtends('ClassInheritB', new FileAppearance(new AstFileReference('foo.php'), 4)),
                            AstInherit::newExtends('ClassInheritC', new FileAppearance(new AstFileReference('foo.php'), 5)),
                            AstInherit::newExtends('ClassInheritD', new FileAppearance(new AstFileReference('foo.php'), 6)),
                        ])
                    ),
                    'LayerA',
                    'LayerB'
                ),
            ],
            'expected-junit-report_1.xml',
        ];

        yield [
            [
                new Violation(
                    new Dependency('OriginalA', 'OriginalB', new FileAppearance(new AstFileReference('foo.php'), 12)),
                    'LayerA',
                    'LayerB'
                ),
            ],
            'expected-junit-report_2.xml',
        ];

        yield [
            [],
            'expected-junit-report_3.xml',
        ];

        yield [
            [
                new SkippedViolation(
                    new InheritDependency(
                        'ClassA',
                        'ClassB',
                        new Dependency('OriginalA', 'OriginalB', new FileAppearance(new AstFileReference('foo.php'), 12)),
                        AstInherit::newExtends('ClassInheritA', new FileAppearance(new AstFileReference('foo.php'), 3))->withPath([
                            AstInherit::newExtends('ClassInheritB', new FileAppearance(new AstFileReference('foo.php'), 4)),
                            AstInherit::newExtends('ClassInheritC', new FileAppearance(new AstFileReference('foo.php'), 5)),
                            AstInherit::newExtends('ClassInheritD', new FileAppearance(new AstFileReference('foo.php'), 6)),
                        ])
                    ),
                    'LayerA',
                    'LayerB'
                ),
                new Violation(
                    new InheritDependency(
                        'ClassC',
                        'ClassD',
                        new Dependency('OriginalA', 'OriginalB', new FileAppearance(new AstFileReference('foo.php'), 12)),
                        AstInherit::newExtends('ClassInheritA', new FileAppearance(new AstFileReference('foo.php'), 3))->withPath([
                            AstInherit::newExtends('ClassInheritB', new FileAppearance(new AstFileReference('foo.php'), 4)),
                            AstInherit::newExtends('ClassInheritC', new FileAppearance(new AstFileReference('foo.php'), 5)),
                            AstInherit::newExtends('ClassInheritD', new FileAppearance(new AstFileReference('foo.php'), 6)),
                        ])
                    ),
                    'LayerA',
                    'LayerB'
                ),
            ],
            'expected-junit-report-with-skipped-violations.xml',
        ];
    }

    /**
     * @dataProvider basicDataProvider
     */
    public function testBasic(array $rules, string $expectedOutputFile): void
    {
        $output = new BufferedOutput();

        $formatter = new JUnitOutputFormatter();
        $formatter->finish(
            new Context($rules),
            $output,
            new OutputFormatterInput(['dump-xml' => __DIR__.'/data/'.static::$actual_junit_report_file])
        );

        static::assertXmlFileEqualsXmlFile(
            __DIR__.'/data/'.static::$actual_junit_report_file,
            __DIR__.'/data/'.$expectedOutputFile
        );
    }

    public function testGetOptions(): void
    {
        static::assertCount(1, (new JUnitOutputFormatter())->configureOptions());
    }
}
