<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

// rules:  https://getrector.com/find-rule

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withSets([
        SetList::PHP_80,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
    ])
    ->withRules([
        \Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector::class,
    ])
    ->withSkip([
        __DIR__ . '/tests/fixtures',
        \Rector\DeadCode\Rector\Property\RemoveUselessVarTagRector::class,
        \Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector::class,
        \Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector::class,
        \Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector::class,
        \Rector\CodeQuality\Rector\Concat\JoinStringConcatRector::class,
        \Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector::class,
    ]);
