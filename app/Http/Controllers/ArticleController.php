<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::where('is_published', true);

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('content', 'like', "%{$request->search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(9);
        $categories = Article::distinct('category')->pluck('category')->filter();

        // Get categories with count for sidebar
        $categoriesWithCount = Article::where('is_published', true)
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        // Get featured article
        $featuredArticle = Article::where('is_published', true)->latest()->first();

        // Get popular articles (most viewed or latest)
        $popularArticles = Article::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('articles.index', compact('articles', 'categories', 'categoriesWithCount', 'featuredArticle', 'popularArticles'));
    }

    public function show($slug)
    {
        $article = Article::where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related articles
        $relatedArticles = Article::where('is_published', true)
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->limit(3)
            ->get();

        // Get popular articles (most viewed or latest)
        $popularArticles = Article::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles', 'popularArticles'));
    }

    public function category($category)
    {
        $articles = Article::where('is_published', true)
            ->where('category', $category)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $categories = Article::distinct('category')->pluck('category')->filter();

        // Get featured article
        $featuredArticle = Article::where('is_published', true)->latest()->first();

        // Get popular articles (most viewed or latest)
        $popularArticles = Article::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('articles.category', compact('articles', 'categories', 'category', 'featuredArticle', 'popularArticles'));
    }
}
