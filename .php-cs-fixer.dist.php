<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php');

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,                // follow PSR-12 coding standard
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'single_quote' => true,
        'blank_line_before_statement' => ['statements' => ['return']],
        'phpdoc_align' => ['align' => 'vertical'],
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_summary' => false,
        'phpdoc_order' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'declare_strict_types' => false,
    ])
    ->setFinder($finder);
