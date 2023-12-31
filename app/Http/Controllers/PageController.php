<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{

    public function validateTest()
    {
        return view('validate');
    }

    public function validateCheck(Request $request)
    {
        $request->validate([
            "title" => "required",
            "gender" => "required|in:male,female,other",
            "township" => ["required", Rule::in(['banhab', 'tamwe', 'insein', 'hletan'])],
            "skills" => "required|array|max:3",
            "skillls.*" => "exists:skills,title",
            // "photo" => "required|file|max:1024|mimes:jpeg,png",
            "certificates" => "required|array|max:3",
            "certificates.*" => "file|max:1024|mimes:jpg,png"

        ]);

        if ($request->hasFile('certificates')) {
            $file = $request->file('certificates');

            // Get the file size
            // $fileSize = $file->getSize();

            // Do something with the file size
            // For example, you can store it in a database or display it to the user
            // echo "File size: " . $fileSize . " bytes";
        }

        return gettype($file);
    }


    public function index()
    {
        $articles = Article::when(request()->has("keyword"), function ($query) {
            $query->where(function (Builder $builder) {
                $keyword = request()->keyword;
                $builder->where("title", "like", "%" . $keyword . "%");
                $builder->orWhere("description", "like", "%" . $keyword . "%");
            });
        })
            ->when(request()->has('category'), function ($query) {
                $query->where("category_id", request()->category);
            })
            ->when(request()->has('title'), function ($query) {
                $sortType = request()->title ?? 'asc';
                $query->orderBy("title", $sortType);
            })
            // ->dd()
            ->latest("id")
            ->paginate(10)->withQueryString();

        return view("welcome", compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where("slug", $slug)->firstOrFail();
        return view('detail', compact('article'));
    }

    public function categorized($slug)
    {
        $category = Category::where("slug", $slug)->firstOrFail();
        return view('categorized', [
            "category" => $category,
            "articles" => $category->articles()->when(request()->has("keyword"), function ($query) {
                $query->where(function (Builder $builder) {
                    $keyword = request()->keyword;
                    $builder->where("title", "like", "%" . $keyword . "%");
                    $builder->orWhere("description", "like", "%" . $keyword . "%");
                });
            })->paginate(10)->withQueryString()
        ]);
    }
}
