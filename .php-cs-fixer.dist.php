<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$paths = require __DIR__ . '/tools/php-cs-fixer/finder.php';
$rules = require __DIR__ . '/tools/php-cs-fixer/rules.php';

$finder = Finder::create()
    ->in($paths['in'])
    ->name('*.php')
    ->exclude($paths['exclude']);

return (new Config())
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setRules($rules);
