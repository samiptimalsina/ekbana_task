<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

use App\Http\Resources\CategoryResource;
use App\Http\Requests\CompanyCategoryRequest;
use App\Repositories\Interface\CompanyCategoryInterface;

class CompanyCategoryController extends Controller
{


    protected $companyCategoryRepository;

    public function __construct(CompanyCategoryInterface $companyCategoryRepository)
    {
        $this->companyCategoryRepository = $companyCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('perPage', 10);
        $page = $request->query('page', 1);
        $search = $request->query('search', 1);

        $categories = $this->companyCategoryRepository->all($perPage, $page,$search);

        return response()->json([
            'status' => 'success',
            'data' => CategoryResource::collection($categories),
            'message' => 'Categories fetched successfully',
            'pagination' => [
                'current_page' => $categories->currentPage(),
                'total_pages' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total_count' => $categories->total(),
            ],
        ],200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCategoryRequest $request): JsonResponse
    {
        $category = $this->companyCategoryRepository->create($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => new CategoryResource($category),
            'message' => 'Category created successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $category = $this->companyCategoryRepository->find($id);
            return response()->json([
                'status' => 'success',
                'data' => new CategoryResource($category),
                'message' => 'Category fetched successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyCategoryRequest $request, int $id): JsonResponse
    {
        try {
            $category = $this->companyCategoryRepository->update($id, $request->validated());
            return response()->json([
                'status' => 'success',
                'data' => new CategoryResource($category),
                'message' => 'Category updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->companyCategoryRepository->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }
    }

    public function search(Request $request): JsonResponse
    {
        $search = $request->query('keyword', '');

        // dd($search);
        $categories = $this->companyCategoryRepository->search($search);

        return response()->json([
            'status' => 'success',
            'data' => CategoryResource::collection($categories),
            'message' => 'Categories fetched successfully',
        ], 200);
    }

}
