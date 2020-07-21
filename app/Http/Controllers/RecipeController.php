<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeCreateRequest;
use App\Http\Requests\RecipeUpdateRequest;
use App\Models\Category;
use App\Models\Profile;
use App\Models\Recipe;
use App\Models\User;
use Exception;
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

    public function index()
    {
        $recipes = Recipe::wherePublished(true);
        $recipes = $this->addFilterToRecipes($recipes);

        $recipesCount = $recipes->count();
        $recipes = $recipes->paginate(16);
        return view('recipe.index', compact('recipes', 'recipesCount'));
    }

    public function favourites(Request $request)
    {
        $recipes = auth()->user()->favourites();
        $recipes = $this->addFilterToRecipes($recipes);

        $recipesCount = $recipes->count();
        $recipes = $recipes->paginate(16);
        return view('recipe.fav-index', compact('recipes', 'recipesCount'));
    }

    private function addFilterToRecipes($recipes) {
        if (!empty(request()->get('s'))) {
            $searchTerm = Str::lower(request()->get('s'));
            $recipes = $recipes->where(function($query) use ($searchTerm) {
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
            $recipes->where(function($query) {
                $query->where('prep_time', '<=', intval(request()->get('mp')))
                    ->orWhereNull('prep_time')
                    ->orderBy('prep_time', 'DESC');
            });
        }
        if (request()->get('mc')) {
            $recipes->where(function($query) {
                $query->where('cook_time', '<=', intval(request()->get('mc')))
                    ->orWhereNull('cook_time')
                    ->orderBy('cook_time', 'DESC');
            });
        }

        return $recipes->latest();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RecipeCreateRequest  $request
     * @return RedirectResponse
     */
    public function store(RecipeCreateRequest $request)
    {
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

        return redirect()->to(route('my.index'))->with([
            'flash' => __('messages.recipe.submitted')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Recipe  $recipe
     * @return RedirectResponse|Application|Factory|View
     */
    public function show(Recipe $recipe)
    {
        if (!$recipe->published){
            return redirect()->back()->with('flash-error', __('recipe.recipe_not_published'));
        }
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
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(Recipe $recipe)
    {
        if (!$recipe->author->is(auth()->user())) {
            return redirect()->back()->with(['flash-error' => __('messages.recipe.edit_not_authorized')]);
        }
        return view('recipe.edit', compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RecipeUpdateRequest  $request
     * @param  Recipe  $recipe
     * @return RedirectResponse
     */
    public function update(RecipeUpdateRequest $request, Recipe $recipe)
    {
        if (!$recipe->author->is(auth()->user())) {
            return redirect(route('home'))->with(['flash-error' => __('messages.recipe.edit_not_authorized')]);
        }
        DB::transaction(function () use ($request, $recipe) {
            $data = [
                'description' => $request->get('description'),
                'ingredients' => $request->get('ingredients'),
                'instructions' => $request->get('instructions'),
                'notes' => $request->get('instructions'),
                'prep_time' => $request->get('prep_time'),
                'cook_time' => $request->get('cook_time'),
                'servings' => $request->get('servings'),
            ];
            try {
                $recipe->update($data);

                $recipe->categories()->detach();
                foreach ($request->get('categories') as $category) {
                    $recipe->categories()->attach($category);
                }

                $allowedfileExtension = ['jpg', 'png'];

                if ($request->hasFile('main_image')) {
                    $mainPhoto = $request->file('main_image');
                    //main photo
                    $filename = $recipe->id . '_' . $mainPhoto->getClientOriginalName() . '_' . uniqid();
                    $extension = $mainPhoto->getClientOriginalExtension();
                    $check = in_array($extension, $allowedfileExtension);
                    if ($check) {
                        $filename .= '.' . $extension;
                        $oldImage = $recipe->images()->whereMain(true)->first();
                        if (Storage::putFileAs('public/images/recipes/', $mainPhoto, $filename)) {
                            if (file_exists($oldImage->getAttributes()['url'])) {
                                Storage::delete($oldImage->getAttributes()['url']);
                            }
                            $recipe->images()->whereMain(true)->update([
                                'url' => 'images/recipes/' . $filename,
                            ]);
                        }
                    }
                }

                $existing = $recipe->images()->whereMain(false)->pluck('id')->toArray();
                $toBeDeleted = $recipe->images()->find(array_diff($existing, $request->get('existing_images', [])));
                // other photos
                foreach ($toBeDeleted as $delete) {
                    Storage::delete($delete->url);
                    $delete->delete();
                }

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
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
            }
        });

        return redirect()->to(route('recipe.edit', $recipe->fresh()))->with([
            'flash' => __('messages.recipe.updated')
        ]);
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
