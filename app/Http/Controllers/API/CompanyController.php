<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Repositories\Interface\CompanyCategoryInterface;
use App\Repositories\Interface\CompanyInterface;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
class CompanyController extends Controller
{
     use FileUploadTrait;

    protected $companyRepository;

    public function __construct(CompanyInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('perPage', 10);
        $page = $request->query('page', 1);
        $keyword=$request->query('search')?? null;

        $companies = $this->companyRepository->all($perPage, $page,$keyword);

        return response()->json([
            'status' => 'success',
            'data' => CompanyResource::collection($companies),
            'message' => 'Companies fetched successfully',
            'pagination' => [
                'current_page' => $companies->currentPage(),
                'total_pages' => $companies->lastPage(),
                'per_page' => $companies->perPage(),
                'total_count' => $companies->total(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                $validatedData['image'] = $this->uploadFile($request->file('image'));
            }
            $validatedData['status'] = filter_var($validatedData['status'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

            $company = $this->companyRepository->create($validatedData);

            return response()->json([
                'status' => 'success',
                'data' => new CompanyResource($company),
                'message' => 'Company created successfully',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $company = $this->companyRepository->find($id);
            return response()->json([
                'status' => 'success',
                'data' => new CompanyResource($company),
                'message' => 'Company fetched successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Company not found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyRequest $request, int $id): JsonResponse
    {
        $validatedData = $request->validated();
        $company = $this->companyRepository->find($id);

        if ($request->hasFile('image')) {
            $this->deleteExistingFileIfExists($company->image);
            $validatedData['image'] = $this->uploadFile($request->file('image'));
        }

        try {
            $company = $this->companyRepository->update($id, $validatedData);
            return response()->json([
                'status' => 'success',
                'data' => new CompanyResource($company),
                'message' => 'Company updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Company not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->companyRepository->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Company deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Company not found',
            ], 404);
        }
    }
}
