<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Produit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * @param Course $course
     * @return JsonResponse
     */
    public function index(Course $course): JsonResponse
    {
        return response()->json([
           'status' => 'OK',
            'produits' => $course->produits
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $produit = Produit::create([
           'name' => $request->name,
           'course_id' => $request->course_id
        ]);

        return response()->json([
           'status' => 'OK',
           'produit' => $produit
        ]);
    }

    /**
     * @param Request $request
     * @param Produit $produit
     * @return JsonResponse
     */
    public function update(Request $request, Produit $produit): JsonResponse
    {
        $produit->fill($request->input());

        return response()->json([
            'status' => 'OK',
        ]);
    }

    /**
     * @param int $produit
     * @return JsonResponse
     */
    public function delete(int $produit): JsonResponse
    {
        $produitExist = Produit::find($produit);

        if (!$produitExist) {
            return response()->json([
                'status' => 'NOT OK',
                'message' => 'Aucune liste ne correspond'
            ]);
        }

        $produitExist->delete();

        return response()->json([
            'status' => 'OK',
        ]);
    }
}
