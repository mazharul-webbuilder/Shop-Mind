<?php

namespace App\Services\Frontend;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAssistanceService
{

    public function chat(string $message, $products): string
    {
        $productList = $products->map(fn($p) =>
        "{$p->name} - {$p->price}: {$p->description}"
        )->implode("\n");

        $systemPrompt = "You are a helpful customer assistant for our online store. Here are our available products: {$productList} Answer customer questions about products, pricing,
        and availability. Be friendly and concise.";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.ai-assistance.groq.key'),
            'Content-Type'   => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model'    => 'llama-3.1-8b-instant',
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user',   'content' => $message],
            ],
        ]);

//        Log::channel('daily')->info('AI assistance response: ' . $response->json('choices.0.message.content'));

        return $response->json('choices.0.message.content');

    }
}
