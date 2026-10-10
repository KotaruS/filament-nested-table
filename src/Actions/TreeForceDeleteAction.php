<?php

namespace Kotaru\FilamentNestedTable\Actions;

use Filament\Actions\ForceDeleteAction;
use Illuminate\Database\Eloquent\Model;

class TreeForceDeleteAction extends ForceDeleteAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->modalDescription(function (Model $record): ?string {
            $descendantCount = $this->getDescendantCount($record);

            if ($descendantCount === 0) {
                return __('filament-nested-table::actions.force_delete_confirm');
            }

            return trans_choice(
                'filament-nested-table::actions.force_delete_confirm_with_children',
                $descendantCount,
                ['count' => $descendantCount]
            );
        });
    }

    protected function getDescendantCount(Model $record): int
    {
        if (! method_exists($record, 'descendants')) {
            return 0;
        }

        // For soft-deleted records, we need to include trashed descendants
        return $record->descendants()->withTrashed()->count();
    }
}
