<?php

namespace App\Services;

use App\Models\Slide;
use App\Repositories\SlideRepository;
use Illuminate\Http\UploadedFile;

class SlideService
{
    public function __construct(
        protected SlideRepository $slideRepository
    ) {}

    public function createSlide(array $data): Slide
    {
        // Set sort order if not provided
        if (!isset($data['sort'])) {
            $data['sort'] = $this->slideRepository->getNextSortOrder();
        }

        $slide = $this->slideRepository->create($data);

        // Handle image upload if provided
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $slide->addMediaFromRequest('image')
                ->toMediaCollection('slides');
        }

        return $slide;
    }

    public function updateSlide(Slide $slide, array $data): Slide
    {
        $this->slideRepository->update($slide, $data);

        // Handle image upload if provided
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $slide->clearMediaCollection('slides');
            $slide->addMediaFromRequest('image')
                ->toMediaCollection('slides');
        }

        return $slide->fresh();
    }

    public function deleteSlide(Slide $slide): bool
    {
        return $this->slideRepository->delete($slide);
    }

    public function getActiveSlides()
    {
        return $this->slideRepository->active();
    }

    public function getAllSlides()
    {
        return $this->slideRepository->all();
    }

    public function reorderSlides(array $sortedIds): void
    {
        $this->slideRepository->reorder($sortedIds);
    }
} 