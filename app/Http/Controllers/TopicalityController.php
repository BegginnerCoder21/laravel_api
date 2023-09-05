<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicalityRequest;
use App\Models\Topicality;
use Illuminate\Http\Request;

class TopicalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topicalities = Topicality::latest()->get();

        return $topicalities;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TopicalityRequest $request)
    {
        Topicality::create([
            'title' => $request->title,
            'content' => $request->content
        ]);
        

        return response()->json([
            'success' => 'votre actualité a bien été crée avec succés'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $topicalities = Topicality::findOrFail($id);
        
        return $topicalities;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TopicalityRequest $request, string $id)
    {
        $topicalities = Topicality::findOrFail($id);

        $topicalities->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response()->json([
            'success' => 'votre actualité a bien été modifiée avec succés'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $topicalities = Topicality::findOrFail($id);

        $topicalities->delete();

        return response()->json([
            'success' => 'votre actualité a bien été supprimé avec succés'
        ]);
    }
}
