<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HotelsController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('https://api.npoint.io/dd85ed11b9d8646c5709');

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch hotels'], 500);
        }

        $hotels = $response->json()['hotels'];

        if ($request->has('name')) {
            $hotels = $this->filterByName($hotels, $request->name);
        }

        if ($request->has('city')) {
            $hotels = $this->filterByCity($hotels, $request->city);
        }

        if ($request->has('price_range')) {
            $priceRange = explode(':', $request->price_range);
            $hotels = $this->filterByPriceRange($hotels, $priceRange);
        }

        if ($request->has('date_range')) {
            $dateRange = explode(':', $request->date_range);
            $hotels = $this->filterByDateRange($hotels, $dateRange);
        }


        if ($request->has('sort_by')) {
            $sortBy = $request->sort_by;
            $hotels = $this->sortBy($hotels, $sortBy);
        }

        return response()->json($hotels);
    }

    private function filterByName($hotels, $name)
    {
        return array_filter($hotels, function ($hotel) use ($name) {
            return stripos($hotel['name'], $name) !== false;
        });
    }

    private function filterByCity($hotels, $city)
    {
        return array_filter($hotels, function ($hotel) use ($city) {
            return strtolower($hotel['city']) === strtolower($city);
        });
    }

    private function filterByPriceRange($hotels, $priceRange)
    {
        return array_filter($hotels, function ($hotel) use ($priceRange) {
            return $hotel['price'] >= $priceRange[0] && $hotel['price'] <= $priceRange[1];
        });
    }

    private function filterByDateRange($hotels, $dateRange)
    {
        return array_filter($hotels, function ($hotel) use ($dateRange) {
            foreach ($hotel['availability'] as $availability) {
                $from = strtotime($availability['from']);
                $to = strtotime($availability['to']);
                $startDate = strtotime($dateRange[0]);
                $endDate = strtotime($dateRange[1]);

                if ($from <= $startDate && $to >= $endDate) {
                    return true;
                }
            }
            return false;
        });
    }

    private function sortBy($hotels, $sortBy)
    {
        usort($hotels, function ($a, $b) use ($sortBy) {
            return $a[$sortBy] <=> $b[$sortBy];
        });
        return $hotels;
    }
}
