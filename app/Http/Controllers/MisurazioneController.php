<?php

namespace App\Http\Controllers;

use App\Models\Misurazione;
use Illuminate\Http\Request;

class MisurazioneController extends Controller
{
    public function index(Request $request)
    {
        $misurazioni = $request->user()
            ->misurazioni()
            ->with('strumento')
            ->orderBy('data', 'desc')
            ->orderBy('ora', 'desc')
            ->get();

        return response()->json($misurazioni);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'peso' => 'required|numeric|min:1|max:999.99',
            'data' => 'required|date',
            'ora' => 'required|date_format:H:i:s',
            'strumento_id' => 'nullable|exists:strumenti,id',
            'stomaco_vuoto' => 'required|boolean',
        ]);

        $misurazione = $request->user()->misurazioni()->create($validated);
        $misurazione->load('strumento');

        return response()->json([
            'message' => 'Misurazione creata con successo',
            'data' => $misurazione
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $misurazione = $request->user()
            ->misurazioni()
            ->with('strumento')
            ->findOrFail($id);

        return response()->json($misurazione);
    }

    public function update(Request $request, $id)
    {
        $misurazione = $request->user()->misurazioni()->findOrFail($id);

        $validated = $request->validate([
            'peso' => 'sometimes|required|numeric|min:1|max:999.99',
            'data' => 'sometimes|required|date',
            'ora' => 'sometimes|required|date_format:H:i:s',
            'strumento_id' => 'nullable|exists:strumenti,id',
            'stomaco_vuoto' => 'sometimes|required|boolean',
        ]);

        $misurazione->update($validated);
        $misurazione->load('strumento');

        return response()->json([
            'message' => 'Misurazione aggiornata con successo',
            'data' => $misurazione
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $misurazione = $request->user()->misurazioni()->findOrFail($id);
        $misurazione->delete();

        return response()->json([
            'message' => 'Misurazione eliminata con successo'
        ]);
    }
}