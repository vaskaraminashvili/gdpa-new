<?php

namespace App\Filament\Resources\SlideResource\Pages;

use App\Filament\Resources\SlideResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlide extends EditRecord
{
    protected static string $resource = SlideResource::class;

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
