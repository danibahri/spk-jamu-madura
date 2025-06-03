<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jamu;
use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $featuredJamus = Jamu::inRandomOrder()->limit(6)->get();

        $categories = Jamu::distinct('kategori')->pluck('kategori')->filter()->values();

        $recentArticles = Article::latest()->limit(3)->get();
        
        // Get featured article (latest published article)
        $featuredArticle = Article::latest()->first();

        $stats = [
            'total_jamu' => Jamu::count(),
            'categories' => count($categories),
            'articles' => Article::count()
        ];

        return view('home', compact('featuredJamus', 'categories', 'recentArticles', 'featuredArticle', 'stats'));
    }
}
