<?php

namespace App\Filament\Resources\SlideResource\Pages;

use App\Filament\Resources\SlideResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSlide extends CreateRecord
{
    protected static string $resource = SlideResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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
