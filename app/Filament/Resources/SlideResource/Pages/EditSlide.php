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
        // Load translations into separate fields for editing
        $data['title_en'] = $data['title']['en'] ?? '';
        $data['title_ka'] = $data['title']['ka'] ?? '';
        $data['description_en'] = $data['description']['en'] ?? '';
        $data['description_ka'] = $data['description']['ka'] ?? '';
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Combine separate fields back into translatable format
        $data['title'] = [
            'en' => $data['title_en'] ?? '',
            'ka' => $data['title_ka'] ?? '',
        ];
        $data['description'] = [
            'en' => $data['description_en'] ?? '',
            'ka' => $data['description_ka'] ?? '',
        ];
        
        // Remove the separate fields
        unset($data['title_en'], $data['title_ka'], $data['description_en'], $data['description_ka']);
        
        return $data;
    }
}
