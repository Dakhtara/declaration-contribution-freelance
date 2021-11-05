<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'vendor']);

return (new PhpCsFixer\Config())
    ->setIndent("    ")
    ->setLineEnding("\n")
    ->setRules([
        '@DoctrineAnnotation' => true,
        '@Symfony' => true,
    ])
    ->setFinder($finder);
