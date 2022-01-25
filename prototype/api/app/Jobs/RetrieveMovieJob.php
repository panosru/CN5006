<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\MovieModel;
use Illuminate\Support\Facades\Http;

class RetrieveMovieJob extends Job
{
    private string $movieId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $movieId)
    {
        $this->movieId = $movieId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): array
    {
        $movieData = Http::get("https://imdb-api.com/en/API/Title/k_p55d9x5l/{$this->movieId}/Trailer,Ratings");

        if (null === $movieData['id'])
            return ['message' => 'Movie not found'];

        $directors = [];
        foreach ($movieData['directorList'] as $director)
            $directors[] = $director['name'];

        $stars = [];
        foreach ($movieData['starList'] as $index => $star)
            $stars[] = [
                'name' => $star['name'],
                'image' => $movieData['actorList'][$index]['image'],
            ];

        $genres = [];
        foreach ($movieData['genreList'] as $genre)
            $genres[] = $genre['value'];

        $movie = MovieModel::create([
            'id' => $movieData['id'],
            'title' => $movieData['title'],
            'year' => $movieData['year'],
            'image' => $movieData['image'],
            'duration' => $movieData['runtimeMins'],
            'plot' => $movieData['plot'],
            'directors' => $directors,
            'stars' => $stars,
            'genres' => $genres,
            'country' => $movieData['countryList'][0]['value'],
            'language' => $movieData['languageList'][0]['value'],
            'rating' => $movieData['imDbRating'],
            'trailer' => $movieData['trailer']['linkEmbed'],
        ]);

        return $movie->toArray();
    }
}
