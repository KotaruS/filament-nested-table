<?php

namespace Kotaru\FilamentNestedTable;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Kotaru\FilamentNestedTable\Services\TreeMover;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentNestedTableServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-nested-table';

    public static string $viewNamespace = 'filament-nested-table';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasViews(static::$viewNamespace)
            ->hasTranslations();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(TreeMover::class, fn () => new TreeMover);
    }

    public function packageBooted(): void
    {
        FilamentAsset::register(
            assets: $this->getAssets(),
            package: 'kotaru/filament-nested-table'
        );
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            AlpineComponent::make(
                'filament-nested-table',
                __DIR__.'/../resources/dist/filament-nested-table.js'
            ),
            Css::make(
                'filament-nested-table-styles',
                __DIR__.'/../resources/dist/filament-nested-table.css'
            ),
        ];
    }
}
