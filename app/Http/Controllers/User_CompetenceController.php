<?php

namespace App\Http\Controllers;

use App\Models\User_Competence;
use Illuminate\Http\Request;

class User_CompetenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = User_Competence::with('utilisateur')->get();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve user competences',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code_user' => 'required|exists:utilisateurs,code_user',
            'code_comp' => 'required|exists:competences,code_comp',
        ]);

        try {
            $data = User_Competence::create([
                'code_user' => $request->code_user,
                'code_comp' => $request->code_comp,
            ]);

            return response()->json($data, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create user competence',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($code_user)
    {
        try {
            $data = User_Competence::where('code_user', $code_user)
                ->with('utilisateur')
                ->get();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve user competence',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $code_user)
    {
        $request->validate([
            'code_comp' => 'required|exists:competences,code_comp',
        ]);

        try {
            $data = User_Competence::where('code_user', $code_user)->firstOrFail();

            $data->update([
                'code_comp' => $request->code_comp
            ]);

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update user competence',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($code_user, $code_comp)
    {
        try {
            $deleted = User_Competence::where([
                'code_user' => $code_user,
                'code_comp' => $code_comp
            ])->delete();

            if (!$deleted) {
                return response()->json(['error' => 'Not found'], 404);
            }

            return response()->json([
                'message' => 'User competence deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete user competence',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
