<?php

namespace App\Services\Frontend;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAssistanceService
{

    public function chat($messages, $products): string
    {
        $productList = $products->map(fn($p) =>
        "{$p->name} - {$p->price}: {$p->description}"
        )->implode("\n");

        $systemPrompt = "You are a helpful customer assistant for our online store "
            . config('app.name')
            . ". Here are our available products:\n{$productList}\n\n"
            . "Rules you must follow:\n"
            . "- Answer questions about products, pricing, and availability only.\n"
            . "- Keep every response under 200 words.\n"
            . "- Use plain text only. No markdown, no asterisks, no bullet symbols.\n"
            . "- Separate paragraphs with a blank line.\n"
            . "- Be friendly, warm, and concise.";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.ai-assistance.groq.key'),
            'Content-Type'  => 'application/json',
        ])->post(config('services.ai-assistance.groq.endpoint'), [
            'model'    => config('services.ai-assistance.groq.model'),
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ...$messages,
            ],
        ]);

        Log::channel('daily')->info('AI Response: '
            . $response->json('choices.0.message.content'));

        return $response->json('choices.0.message.content')
            ?? 'Sorry, I could not process that.';
    }
}
