<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->exclude('fixtures');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PER-CS' => true,

        'declare_strict_types' => true,
        'no_unused_imports' => true,

        // Базово только use, расширяем для всего
        'no_extra_blank_lines' => true,

        'single_class_element_per_statement' => [
            'elements' => ['property', 'const'],
        ],

        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
                'property' => 'one',
                'const' => 'one',
            ],
        ],
    ])
    ->setFinder($finder);
