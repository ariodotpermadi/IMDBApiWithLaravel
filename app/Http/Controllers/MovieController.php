<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MovieController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('IMDB_API_KEY');
    }

    private function callIMDBApi($params = [])
    {
        $url = "http://www.omdbapi.com/?" . http_build_query(array_merge(['apikey' => $this->apiKey], $params));
        $cacheKey = md5($url);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        Cache::put($cacheKey, $data, now()->addMinutes(10));

        return $data;
    }

    public function getPopularMovies(Request $request)
    {
        $year = $request->input('year', 2024); // Default year is 2024 if not provided
        $params = [
            's' => '', // No specific title search
            'type' => 'movie',
            'y' => $year,
            'r' => 'json'
        ];

        $movies = $this->callIMDBApi($params);

        if (isset($movies['Search'])) {
            $transformedMovies = array_map(function ($movie) {
                return [
                    'title' => $movie['Title'],
                    'year' => $movie['Year'],
                    'poster' => $movie['Poster']
                ];
            }, $movies['Search']);
        } else {
            $transformedMovies = [];
        }

        return response()->json($transformedMovies);
    }

    public function getMovieDetail(Request $request)
    {
        $id = $request->input('id');
        $params = [
            'i' => $id,
            'r' => 'json'
        ];

        $movie = $this->callIMDBApi($params);

        if ($movie && isset($movie['Title'])) {
            $transformedMovie = [
                'title' => $movie['Title'],
                'year' => $movie['Year'],
                'poster' => $movie['Poster'],
                'plot' => $movie['Plot'],
                'director' => $movie['Director'],
                'actors' => $movie['Actors']
            ];
        } else {
            $transformedMovie = [];
        }

        return response()->json($transformedMovie);
    }

    public function searchMovies(Request $request)
    {
        $query = $request->input('query');
        $params = [
            's' => $query,
            'r' => 'json'
        ];

        $movies = $this->callIMDBApi($params);

        if (isset($movies['Search'])) {
            $transformedMovies = array_map(function ($movie) {
                return [
                    'title' => $movie['Title'],
                    'year' => $movie['Year'],
                    'poster' => $movie['Poster']
                ];
            }, $movies['Search']);
        } else {
            $transformedMovies = [];
        }

        return response()->json($transformedMovies);
    }
}
