<?php

declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use Arkitect\Expression\ForClasses\NotHaveDependencyOutsideNamespace;
use Arkitect\Expression\ForClasses\NotResideInTheseNamespaces;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    $mvcClassSet = ClassSet::fromDir(__DIR__.'/src');

    $rules = [];

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('Domain'))
        ->should(new NotHaveDependencyOutsideNamespace('Domain', ['Exception', 'Throwable',]))
        ->because('we want the domain independent from the outside');

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('Application'))
        ->should(new NotHaveDependencyOutsideNamespace('Application', ['Domain', 'LogicException',]))
        ->because('we want the application layer dependent on domain only');

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Controller\Component'))
        ->should(new HaveNameMatching('*Component'))
        ->because('we want uniform naming for components');

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Controller'))
        ->andThat(new NotResideInTheseNamespaces('App\Controller\Component'))
        ->should(new HaveNameMatching('*Controller'))
        ->because('we want uniform naming for controllers');

    $config
        ->add($mvcClassSet, ...$rules);
};
