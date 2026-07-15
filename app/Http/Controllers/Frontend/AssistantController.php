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
            'message' => ['required', 'string', 'max:255'],
        ]);

        $products = Product::select('name', 'price', 'description')
            ->get();

        $response = (new AiAssistanceService())->chat($request->message, $products);

        return response()->json(['reply' => $response]);
    }
}
