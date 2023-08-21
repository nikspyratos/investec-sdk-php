<?php

declare(strict_types=1);

/**
 * Basic architecture quality tests
 * https://github.com/JonPurvis/pest-snippets/blob/main/arch-testing.md
 */

use InvestecSdkPhp\Connectors\InvestecConnector;
use InvestecSdkPhp\Connectors\InvestecOAuthConnector;

uses()->group('architecture');

test('Application files use strict types')
    ->expect('InvestecSdkPhp')
    ->toUseStrictTypes();

test('The codebase does not reference env variables outside of config files')
    ->expect('env')
    ->not->toBeUsed();

test('The codebase does not contain any debugging code')
    ->expect(['dd', 'dump', 'ray', 'var_dump', 'print_r'])
    ->not->toBeUsed();

test('Connectors have the correct class and suffix')
    ->expect(InvestecConnector::class)
    ->and(InvestecOAuthConnector::class)
    ->toHaveSuffix('Connector')
    ->toExtend('Saloon\Http\Connector');

test('Requests have the correct class and suffix')
    ->expect('InvestecSdkPhp\Requests')
    ->toHaveSuffix('Request')
    ->toExtend('Saloon\Http\Request')
    ->toUse('Saloon\Enums\Method');

test('Resources have the correct class and suffix')
    ->expect('InvestecSdkPhp\Resources')
    ->toHaveSuffix('Resource')
    ->toExtend(InvestecSdkPhp\Resources\Resource::class);

test('Tests are using strict types and have the correct suffix')
    ->expect('Tests')
    ->toUseStrictTypes()
    ->and('Tests\Feature')->toHaveSuffix('Test')
    ->and('Tests\Unit')->toHaveSuffix('Test');
