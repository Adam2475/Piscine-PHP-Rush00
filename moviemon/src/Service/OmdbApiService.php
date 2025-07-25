<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Moviemon;


class OmdbApiService
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $_ENV['API_KEY'];
    }

    private function fetchMoviemonById(string $id): ?Moviemon
    {
        $url = 'https://www.omdbapi.com/?i=tt' . urlencode($id) . '&apikey=' . $this->apiKey;
        try
        {
            $response = $this->httpClient->request('GET', $url);
            $data = $response->toArray();
        }
        catch (\Throwable $e)
        {
            logger()->error('Error fetching data from OMDB API: ' . $e->getMessage());
            return null;
        }
        $moviemon = new Moviemon();
        $moviemon->setName($data['Title'] ?? 'Unknown');
        $imdbRating = is_numeric($data['imdbRating'] ?? null) ? (float)$data['imdbRating'] : 5.0;
        $metascore = is_numeric($data['Metascore'] ?? null) ? (int)$data['Metascore'] : 50;
        $moviemon->setHealth(round($imdbRating * 10) ?? 10);
        $moviemon->setStrength(round($metascore) ?? 10);
        $moviemon->setUrlPoster($data['Poster'] ?? '');
        return $moviemon;
    }

    public function getMoviemonById(int $id): ?Moviemon
    {
        if ($id < 1 || $id > 2404811)
            {
                logger()->error('Invalid ID format: ' . $id);
                return null;
            }
            $paddedId = str_pad($id, 7, '0', STR_PAD_LEFT);
        return $this->fetchMoviemonById($paddedId);
    }

    public function populateMoviemon(array $movie_ids): array
    {
        $moviemons = [];
        foreach ($movie_ids as $id)
        {
            $moviemon = $this->getMoviemonById($id);
            if ($moviemon !== null)
                $moviemons[] = $moviemon;
        }
        return $moviemons;
    }

    public function getCatchableMoviemon(): array
    {
        $movie_ids = [];
        $id = random_int(1, 2404811);
        for ($i = 0; $i < 10; $i++)
        {
            while (in_array($id, $movie_ids))
                $id = random_int(1, 2404811);
            $movie_ids[$i] = $id;
        }
        return $movie_ids;
    }
}
