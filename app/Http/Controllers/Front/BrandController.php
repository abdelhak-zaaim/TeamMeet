<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class BrandController extends AppBaseController
{
    /** @var BrandRepository */
    private $brandRepository;

    public function __construct(BrandRepository $brandRepo)
    {
        $this->brandRepository = $brandRepo;
    }

    /**
     * Display a listing of the Brand.
     */
    public function index(): View|Factory|Application
    {
        return view('brands.index');
    }

    /**
     * Store a newly created Brand in storage.
     */
    public function store(CreateBrandRequest $request): JsonResponse
    {
        $input = $request->all();
        $brand = $this->brandRepository->store($input);

        return $this->sendSuccess(__('messages.success_message.front_brand_saved'));
    }

    /**
     * Show the form for editing the specified Brand.
     */
    public function edit(Brand $brand): JsonResponse
    {
        return $this->sendResponse($brand, __('messages.brand.brand_retrieved_successfully'));
    }

    /**
     * Update the specified Brand in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand): JsonResponse
    {
        $brand = $this->brandRepository->update($request->all(), $brand->id);

        return $this->sendSuccess(__('messages.success_message.front_brand_updated'));
    }

    /**
     * Remove the specified Brand from storage.
     */
    public function destroy(Brand $brand): JsonResponse
    {
        if ($brand->is_default == 1) {
            return $this->sendError(__('messages.success_message.default_front_brand_cant_deleted'));
        }

        $brand->delete();

        return $this->sendSuccess(__('messages.brand.brand_deleted_successfully'));
    }
}
