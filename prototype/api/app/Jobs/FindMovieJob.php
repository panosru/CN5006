<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\MovieModel;
use Illuminate\Support\Facades\Http;

class FindMovieJob extends Job
{
    private string $expression;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $expression)
    {
        $this->expression = $expression;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): array
    {
        $movies = Http::get("https://imdb-api.com/en/API/SearchMovie/k_p55d9x5l/{$this->expression}");

        return $movies['results'] ?? [];
    }
}
