<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests');

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PhpCsFixer' => true,
    'array_syntax' => ['syntax' => 'short'],
])->setFinder($finder);
