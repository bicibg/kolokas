<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Recipe;
use App\Models\RecipeImage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'images', 'deleteimage']);
        $this->middleware('admin.check')->only('images', 'deleteimage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('recipe.create');
    }

    public function index()
    {
        $recipes = Recipe::wherePublished(true);
        $recipes = $this->addFilterToRecipes($recipes);

        $recipesCount = $recipes->count();
        $recipes = $recipes->paginate(16);
        return view('recipe.index', compact('recipes', 'recipesCount'));
    }

    private function addFilterToRecipes($recipes)
    {
        if (!empty(request()->get('s'))) {
            $searchTerm = Str::lower(request()->get('s'));
            $recipes = $recipes->where(function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }
        if (request()->get('c')) {
            $request = request();
            $recipes->whereHas('categories', function ($q) use ($request) {
                return $q->whereCategoryId($request->get('c'));
            });
        }
        if (request()->get('a')) {
            $author = Profile::where('slug', request()->get('a'))->first();
            if ($author) {
                $recipes->author($author);
            }
        }

        if (request()->get('mp')) {
            $recipes->where(function ($query) {
                $query->where('prep_time', '<=', intval(request()->get('mp')))
                    ->orWhereNull('prep_time')
                    ->orderBy('prep_time', 'DESC');
            });
        }
        if (request()->get('mc')) {
            $recipes->where(function ($query) {
                $query->where('cook_time', '<=', intval(request()->get('mc')))
                    ->orWhereNull('cook_time')
                    ->orderBy('cook_time', 'DESC');
            });
        }

        return $recipes->latest();
    }

    public function favourites(Request $request)
    {
        $recipes = auth()->user()->favourites();
        $recipes = $this->addFilterToRecipes($recipes);

        $recipesCount = $recipes->count();
        $recipes = $recipes->paginate(16);
        return view('recipe.fav-index', compact('recipes', 'recipesCount'));
    }

    /**
     * Display the specified resource.
     *
     * @param Recipe $recipe
     * @return RedirectResponse|Application|Factory|View
     */
    public function show(Recipe $recipe)
    {
        if (!$recipe->published) {
            return redirect()->back()->with('flash-error', __('trx.recipe_cannot_be_displayed'));
        }
        $youMayAlsoLike = Recipe::with('categories')->where('id', '!=',  $recipe->id)->whereHas('categories', function ($query) use ($recipe) {
            $query->whereIn('category_recipe.category_id',
                $recipe->categories()->pluck('category_recipe.category_id')); // use whereIn
        })->limit(4)->get();
        return view('recipe.show', compact('recipe', 'youMayAlsoLike'));
    }

    public function myRecipes()
    {
        $published = auth()->user()->recipes()->wherePublished(true)->get();
        $pending = auth()->user()->recipes()->where('published', false)->get();
        return view('recipe.my-index', compact('published', 'pending'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Recipe $recipe
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(Recipe $recipe)
    {
        if (!$recipe->author->is(auth()->user())) {
            return redirect()->back()->with(['flash-error' => __('trx.recipe_edit_not_authorized')]);
        }
        return view('recipe.edit', compact('recipe'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Recipe $recipe
     * @return Response
     */
    public function destroy(Recipe $recipe)
    {
        //
    }

    public function images(Recipe $recipe) {
        $photos = request()->file('images', []);
        try {
            foreach ($photos as $file) {
                $filename = uniqid() . '_' . $file->getClientOriginalName();
                $filename = Str::slug($filename);
                $file->storeAs('public/images/recipes/', $filename);
                if ($file->storeAs('public/images/recipes/', $filename)) {
                    $recipe->images()->create([
                        'url' => 'images/recipes/' . $filename,
                    ]);
                }
            }
        } catch (\Throwable $exception) {
            report($exception);
            return false;
        }

        return response(['images' => $recipe->images()->pluck('url')], 200);
    }

    public function deleteimage(RecipeImage $image) {
        try {
            if(Storage::delete('public/' . $image->getAttributes()['url'])) {
                $image->delete();
            }
        } catch (\Throwable $e) {
            report ($e);
            return false;
        }
        return response(['success' => true], 200);
    }
}
