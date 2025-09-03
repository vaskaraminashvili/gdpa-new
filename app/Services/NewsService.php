<?php

namespace App\Services;

use App\Models\News;
use App\Repositories\NewsRepository;
use Illuminate\Database\Eloquent\Collection;

class NewsService
{
    public function __construct(
        protected NewsRepository $newsRepository
    ) {}

    public function getAllNews(): Collection
    {
        return $this->newsRepository->all();
    }

    public function getPublishedNews(): Collection
    {
        return $this->newsRepository->published();
    }

    public function getActiveNews(): Collection
    {
        return $this->newsRepository->active();
    }

    public function findNews(int $id): ?News
    {
        return $this->newsRepository->find($id);
    }

    public function findNewsBySlug(string $slug): ?News
    {
        return $this->newsRepository->findBySlug($slug);
    }

    public function createNews(array $data): News
    {
        return $this->newsRepository->create($data);
    }

    public function updateNews(News $news, array $data): bool
    {
        return $this->newsRepository->update($news, $data);
    }

    public function deleteNews(News $news): bool
    {
        return $this->newsRepository->delete($news);
    }
} 