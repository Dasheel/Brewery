<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;
use App\Http\Clients\Contracts\OpenBreweryClient as OpenBreweryClientContract;

class OpenBreweryClient implements OpenBreweryClientContract
{
    protected string $metaUrl;
    protected string $baseUrl;

    public function __construct()
    {
        $this->metaUrl = config('services.openbrewery.meta_url');
        $this->baseUrl = config('services.openbrewery.url');
    }

    public function getMetaData(): int
    {
        $response = Http::get($this->metaUrl);

        if (!$response->successful()) {
            $response->throw();
        }

        $data = $response->json();

        return $data['total'] ?? 0;
    }

    public function getBreweries(int $page, int $perPage): array
    {
        $response = Http::get($this->baseUrl, [
            'page' => $page,
            'per_page' => $perPage,
        ]);

        if (!$response->successful()) {
            $response->throw();
        }

        return $response->json();
    }
}
