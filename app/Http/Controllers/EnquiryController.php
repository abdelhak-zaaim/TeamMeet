<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEnquiryRequest;
use App\Models\Enquiry;
use App\Repositories\EnquiryRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class EnquiryController extends AppBaseController
{
    /** @var EnquiryRepository */
    private $enquiryRepository;

    public function __construct(EnquiryRepository $enquiryRepository)
    {
        $this->enquiryRepository = $enquiryRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('enquiries.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEnquiryRequest $request): JsonResponse
    {
        $input = $request->all();
        $enquiry = $this->enquiryRepository->store($input);

        return $this->sendSuccess(__('messages.success_message.message_send'));
    }

    /**
     * @return Application|Factory|View
     */
    public function show(Enquiry $enquiry): \Illuminate\View\View
    {
        $enquiry->update(['view' => isset($enquiry->view) ?? true]);

        return view('enquiries.show', compact('enquiry'));
    }

    public function destroy(Enquiry $enquiry): JsonResponse
    {
        $enquiry->delete();

        return $this->sendSuccess(__('messages.success_message.enquiry_deleted_successfully'));
    }
}
