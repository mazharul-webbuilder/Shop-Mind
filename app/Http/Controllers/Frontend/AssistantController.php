<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Frontend\AiAssistanceService;
use Illuminate\Http\Request;

class AssistantController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'messages' => 'required|array',
            'messages.*.role' => 'required|in:user,assistant',
            'messages.*.content' => 'required|string|max:1000',
        ]);

        $products = Product::select('name', 'price', 'description')
            ->get();

        $response = (new AiAssistanceService())->chat($request->messages, $products);

        return response()->json(['reply' => $response]);
    }
}
