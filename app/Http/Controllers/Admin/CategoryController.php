<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::withCount('events')
            ->orderBy('name')
            ->get();

        return view(
            'admin.categories.index',
            compact('categories')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse 
    {
        Category::create(
            $request->validated()
        );

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Categoria criada com sucesso'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view(
            'admin.caetgories.edit',
            compact('category')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update(
            $request->validated()
        );
        
        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Categoria atualizada com sucesso'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->events()->exixts()) {
            return back()->with(
                'error',
                'Não é possivel excluir uam categoria que possui eventos'
            );
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Categoria excluída com sucesso'
            );
    }
}
