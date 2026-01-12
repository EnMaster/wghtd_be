<?php

namespace App\Http\Controllers;

use App\Models\Strumento;
use Illuminate\Http\Request;

class StrumentoController extends Controller
{
    public function index()
    {
        $strumenti = Strumento::with('creatore:id,name')->get();
        return response()->json($strumenti);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'descrizione' => 'nullable|string',
        ]);

        $strumento = $request->user()->strumenti()->create($validated);
        $strumento->load('creatore:id,name');

        return response()->json([
            'message' => 'Strumento creato con successo',
            'data' => $strumento
        ], 201);
    }

    public function show($id)
    {
        $strumento = Strumento::with('creatore:id,name')->findOrFail($id);
        return response()->json($strumento);
    }

    public function update(Request $request, $id)
    {
        $strumento = Strumento::findOrFail($id);

        if ($strumento->created_by !== $request->user()->id) {
            return response()->json([
                'message' => 'Non sei autorizzato a modificare questo strumento'
            ], 403);
        }

        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'descrizione' => 'nullable|string',
        ]);

        $strumento->update($validated);
        $strumento->load('creatore:id,name');

        return response()->json([
            'message' => 'Strumento aggiornato con successo',
            'data' => $strumento
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $strumento = Strumento::findOrFail($id);

        if ($strumento->created_by !== $request->user()->id) {
            return response()->json([
                'message' => 'Non sei autorizzato a eliminare questo strumento'
            ], 403);
        }

        $strumento->delete();

        return response()->json([
            'message' => 'Strumento eliminato con successo'
        ]);
    }
}