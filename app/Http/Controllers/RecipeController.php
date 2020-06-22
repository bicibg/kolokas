<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeRequest;
use App\Recipe;
use App\User;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /***
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $recipes = Recipe::wherePublished(true)->latest()->get();
        return view('recipes.index', compact('recipes'));
    }

    /***
     * @param  User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myIndex(User $user)
    {
        $recipes = Recipe::whereUserId($user->id)->get();
        return view('recipes.my-index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RecipeRequest $request)
    {
        Recipe::create([
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
        return redirect()->to(route('recipes.index'))->with([
            'success' => 'Your recipe was submitted successfully. It will be reviewed as soon as possible. We will let you know of the outcome'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        //
    }
}
