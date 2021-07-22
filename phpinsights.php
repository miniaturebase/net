<?php

declare(strict_types = 1);

return [
    'preset' => 'default',
    'add' => [],
    'remove' => [
        # NunoMaduro\PhpInsights\Domain\Metrics\Style\Style::class,
        SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff::class,
        SlevomatCodingStandard\Sniffs\ControlStructures\DisallowEmptySniff::class,
        SlevomatCodingStandard\Sniffs\ControlStructures\DisallowYodaComparisonSniff::class,
        SlevomatCodingStandard\Sniffs\PHP\UselessParenthesesSniff::class,
        SlevomatCodingStandard\Sniffs\Commenting\UselessInheritDocCommentSniff::class,
        SlevomatCodingStandard\Sniffs\TypeHints\UselessConstantTypeHintSniff::class,
        PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer::class,
        PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterNotSniff::class,
        SlevomatCodingStandard\Sniffs\Commenting\DocCommentSpacingSniff::class,
        PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff::class,
        PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer::class,
    ],
    'exclude' => [
        'bin/',
        'examples/',
    ],
    'config' => [],
];
