<?php

namespace App\Http\Controllers;

use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use function Laravel\Prompts\search;

class SearchController extends Controller
{
    // public function input(Request $request)
    // {
    //     $validated = $request->validate([
    //         'query' => 'required|string|max:255',
    //     ]);

    //     $query = $validated['query'];

    //     if ($user = $request->user()) {
    //         Search::create([
    //             'id_user' => $user->id_user,
    //             'query'   => $query,
    //         ]);
    //     }

    //     try {
    //         $aiServiceUrl = 'https://1e30-182-4-102-63.ngrok-free.app';

    //         // if (!$aiServiceUrl) {
    //         //     Log::error('AI search service URL is not configured.');
    //         //     return response()->json(['message' => 'Service is currently unavailable.'], 503);
    //         // }
            
    //         $response = Http::timeout(30)->post($aiServiceUrl, [
    //             'query' => $query,
    //         ]);

    //         if ($response->failed()) {
    //             Log::error('AI service request failed.', [
    //                 'status' => $response->status(), 
    //                 'body' => $response->body()
    //             ]);
    //             return response()->json(['message' => 'Error fetching search results.'], 502);
    //         }

    //         return response()->json($response->json());

    //     } catch (\Exception $e) {
    //         Log::error('Error connecting to AI search service: ' . $e->getMessage());
    //         return response()->json(['message' => 'An unexpected error occurred.'], 500);
    //     }
    // }

public function input(Request $request)
{
    $validated = $request->validate([
        'query' => 'required|string|max:255',
    ]);

    $query = $validated['query'];

    if ($user = $request->user()) {
        Search::create([
            'id_user' => $user->id_user,
            'query'   => $query,
        ]);
    }

    try {
        $aiServiceUrl = 'https://sdwx3bmv-5000.asse.devtunnels.ms/recommend';
        
        $response = Http::timeout(30)
            ->withHeaders([
                'ngrok-skip-browser-warning' => 'true',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive',
            ])
            ->post($aiServiceUrl, [
                'query' => $query,
            ]);

        Log::info('AI Response Debug', [
            'status' => $response->status(),
            'body' => $response->body(),
            'headers' => $response->headers()
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Error fetching search results.',
                'debug_info' => [
                    'status' => $response->status(),
                    'response_body' => $response->body()
                ]
            ], 502);
        }

        return response()->json($response->json());

    } catch (\Exception $e) {
        Log::error('Exception: ' . $e->getMessage());
        return response()->json([
            'message' => 'An unexpected error occurred.',
            'debug' => $e->getMessage()
        ], 500);
    }
}
public function userRecommendation(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|integer',
    ]);

    $userId = $validated['user_id'];

    try {
        $aiServiceUrl = 'https://1e30-182-4-102-63.ngrok-free.app/recommend/user';
        
        $response = Http::timeout(30)
            ->withHeaders([
                'ngrok-skip-browser-warning' => 'true',
            ])
            ->get($aiServiceUrl, [
                'user_id' => $userId,
            ]);

        if ($response->failed()) {
            Log::error('AI user recommendation failed.', [
                'status' => $response->status(), 
                'body' => $response->body()
            ]);
            return response()->json(['message' => 'Error fetching user recommendations.'], 502);
        }

        return response()->json($response->json());

    } catch (\Exception $e) {
        Log::error('Error connecting to AI user service: ' . $e->getMessage());
        return response()->json(['message' => 'An unexpected error occurred.'], 500);
    }
}
public function datahistory()
{
    $histories = Search::select('id_user', 'query', 'created_at')->get();

    return response()->json([
        'success' => true,
        'message' => 'Data history berhasil diambil',
        'data' => $histories
    ]);
}
}