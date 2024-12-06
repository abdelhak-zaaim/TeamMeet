<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Models\Faq;
use App\Repositories\FaqRepository;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class FaqController extends AppBaseController
{
    /** @var FaqRepository */
    private $faqRepository;

    public function __construct(FaqRepository $faqRepo)
    {
        $this->faqRepository = $faqRepo;
    }

    /**
     * Display a listing of the Faq.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('fronts.faqs.index');
    }

    /**
     * Show the form for creating a new Faq.
     *
     * @return Application|Factory|View
     */
    public function create(): \Illuminate\View\View
    {
        return view('fronts.faqs.create');
    }

    /**
     * Store a newly created Faq in storage.
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function store(CreateFaqRequest $request): RedirectResponse
    {
        $input = $request->all();

        $faq = $this->faqRepository->create($input);

        Flash::success(__('messages.success_message.faq_saved'));

        return redirect(route('faqs.index'));
    }

    /**
     * Show the form for editing the specified Faq.
     *
     * @return Application|Factory|View
     */
    public function edit(Faq $faq): \Illuminate\View\View
    {
        return view('fronts.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified Faq in storage.
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function update(UpdateFaqRequest $request, Faq $faq): RedirectResponse
    {
        $faq = $this->faqRepository->update($request->all(), $faq->id);

        Flash::success(__('messages.success_message.faq_updated'));

        return redirect(route('faqs.index'));
    }

    /**
     * Remove the specified Faq from storage.
     */
    public function destroy(Faq $faq): JsonResponse
    {
        if ($faq->is_default) {
            return $this->sendError(__('messages.success_message.faq_used_somewhere'));
        }

        $faq->delete();

        return $this->sendSuccess(__('messages.faq_deleted'));
    }
}
