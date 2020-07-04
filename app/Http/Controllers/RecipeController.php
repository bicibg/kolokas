<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeCreateRequest;
use App\Http\Requests\RecipeUpdateRequest;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /***
     * @param  User  $user
     * @return Application|Factory|View
     */
    public function myIndex(User $user)
    {
        $recipes = Recipe::whereUserId($user->id)->get();
        return view('recipe.my-index', compact('recipes'));
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

    public function index(Request $request)
    {
        $recipes = Recipe::wherePublished(true)
            ->latest();

        if (!empty($request->get('s'))) {
            $searchTerm = Str::lower($request->get('s'));
            $recipes->where('title', 'LIKE', "%{$searchTerm}%")
                ->orWhere('description', 'LIKE', "%{$searchTerm}%");
        }
        if ($request->get('c')) {
            $recipes->whereHas('categories', function ($q) use ($request) {
                return $q->whereCategoryId($request->get('c'));
            });
        }
        $count = $recipes->count();
        $recipes = $recipes->paginate(16);
        $categories = Category::all();
        return view('recipe.index', compact('recipes', 'count', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RecipeCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(RecipeCreateRequest $request)
    {
        if ($request->hasFile('main_image')) {
            DB::transaction(function () use ($request) {
                $recipe = Recipe::create([
                    'title' => $request->get('title'),
                    'description' => $request->get('description'),
                    'ingredients' => $request->get('ingredients'),
                    'instructions' => $request->get('instructions'),
                    'notes' => $request->get('notes'),
                    'prep_time' => $request->get('prep_time'),
                    'cook_time' => $request->get('cook_time'),
                    'servings' => $request->get('servings'),
                    'user_id' => auth()->id(),
                ]);

                foreach ($request->get('categories') as $category) {
                    $recipe->categories()->attach($category);
                }

                $allowedfileExtension = ['jpg', 'png'];
                $mainPhoto = $request->file('main_image');
                //main photo
                $filename = $recipe->id . '_' . $mainPhoto->getClientOriginalName() . '_' . uniqid();
                $extension = $mainPhoto->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $filename .= '.' . $extension;
                    if (Storage::putFileAs('public/images/recipes/', $mainPhoto, $filename)) {
                        $recipe->images()->create([
                            'url' => 'images/recipes/' . $filename,
                            'main' => 1
                        ]);
                    }
                }

                // other photos
                if ($request->hasFile('images')) {
                    $photos = $request->file('images');
                    foreach ($photos as $file) {
                        $filename = $recipe->id . '_' . $file->getClientOriginalName() . '_' . uniqid();
                        $extension = $file->getClientOriginalExtension();
                        $check = in_array($extension, $allowedfileExtension);
                        if ($check) {
                            $filename .= '.' . $extension;
                            if (Storage::putFileAs('public/images/recipes/', $file, $filename)) {
                                $recipe->images()->create([
                                    'url' => 'images/recipes/' . $filename,
                                    'main' => 0
                                ]);
                            }
                        }
                    }
                }
            });
        }

        return redirect()->to(route('recipe.index'))->with([
            'flash' => 'Your recipe was submitted successfully. It will be reviewed as soon as possible. We will let you know of the outcome'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Recipe  $recipe
     * @return Application|Factory|View
     */
    public function show(Recipe $recipe)
    {
        $youMayAlsoLike = Recipe::with('categories')->whereHas('categories', function ($query) use ($recipe) {
            $query->whereIn('category_recipe.category_id',
                $recipe->categories()->pluck('category_recipe.category_id')); // use whereIn
        })->limit(4)->get();
        return view('recipe.show', compact('recipe', 'youMayAlsoLike'));
    }

    public function myRecipes()
    {
        $recipes = auth()->user()->recipes();
        $published = $recipes->wherePublished(false)->get();

        $pending = $recipes->wherePublished(false)->get();
        return view('recipe.my-index', compact('published', 'pending'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Recipe  $recipe
     * @return void|Response
     */
    public function edit(Recipe $recipe)
    {
        if (!$recipe->author->is(auth()->user())) {
            abort(403, 'You are not allowed to edit someone else\'s recipe');
        }
        return view('recipe.edit', compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RecipeUpdateRequest  $request
     * @param  Recipe  $recipe
     * @return void
     */
    public function update(RecipeUpdateRequest $request, Recipe $recipe)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Recipe  $recipe
     * @return Response
     */
    public function destroy(Recipe $recipe)
    {
        //
    }
}
