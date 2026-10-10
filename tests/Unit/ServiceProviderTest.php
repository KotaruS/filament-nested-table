<?php

declare(strict_types=1);

use Kotaru\FilamentNestedTable\Services\TreeMover;

it('registers TreeMover as singleton', function () {
    $instance1 = app(TreeMover::class);
    $instance2 = app(TreeMover::class);

    expect($instance1)->toBeInstanceOf(TreeMover::class)
        ->and($instance1)->toBe($instance2);
});

it('publishes config file', function () {
    expect(config('filament-nested-table'))->toBeArray()
        ->and(config('filament-nested-table.indent_size'))->toBe(24)
        ->and(config('filament-nested-table.drag_enabled'))->toBeTrue()
        ->and(config('filament-nested-table.max_depth'))->toBeNull()
        ->and(config('filament-nested-table.remember_expanded_state'))->toBeTrue()
        ->and(config('filament-nested-table.default_expanded'))->toBeFalse()
        ->and(config('filament-nested-table.undo_duration'))->toBe(10)
        ->and(config('filament-nested-table.broadcast_enabled'))->toBeFalse()
        ->and(config('filament-nested-table.touch_delay'))->toBe(150);
});

it('loads translations', function () {
    expect(__('filament-nested-table::messages.move_success'))
        ->toBe('Item moved successfully.');

    expect(__('filament-nested-table::messages.circular_reference'))
        ->toBe('Cannot move an item under its own descendant.');

    expect(__('filament-nested-table::actions.delete_confirm'))
        ->toBe('Are you sure you want to delete this item?');
});

it('loads views namespace', function () {
    $viewFinder = app('view');

    // The view namespace should be registered
    expect($viewFinder->exists('filament-nested-table::pages.order-page'))->toBeTrue();
    expect($viewFinder->exists('filament-nested-table::tables.columns.tree-column'))->toBeTrue();
});
