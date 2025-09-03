<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // The form uses dot notation, so data is already in correct format
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // The form uses dot notation, so data is already in correct format
        return $data;
    }
} 