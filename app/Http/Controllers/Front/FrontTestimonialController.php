<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateFrontTestimonialRequest;
use App\Http\Requests\UpdateFrontTestimonialRequest;
use App\Models\FrontTestimonial;
use App\Repositories\FrontTestimonialRepository;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class FrontTestimonialController extends AppBaseController
{
    /** @var FrontTestimonialRepository */
    private $frontTestimonialRepository;

    public function __construct(FrontTestimonialRepository $frontTestimonialRepo)
    {
        $this->frontTestimonialRepository = $frontTestimonialRepo;
    }

    /**
     * Display a listing of the FrontTestimonial.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('fronts.front_testimonials.index');
    }

    /**
     * Show the form for creating a new FrontTestimonial.
     *
     * @return Application|Factory|View
     */
    public function create(): \Illuminate\View\View
    {
        return view('fronts.front_testimonials.create');
    }

    /**
     * Store a newly created FrontTestimonial in storage.
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function store(CreateFrontTestimonialRequest $request): RedirectResponse
    {
        $input = $request->all();
        $frontTestimonial = $this->frontTestimonialRepository->store($input);

        Flash::success(__('messages.success_message.front_testimonial_created'));

        return redirect(route('front-testimonials.index'));
    }

    /**
     * Show the form for editing the specified FrontTestimonial.
     *
     * @return Application|Factory|View
     */
    public function edit(FrontTestimonial $frontTestimonial): \Illuminate\View\View
    {
        return view('fronts.front_testimonials.edit', compact('frontTestimonial'));
    }

    /**
     * Update the specified FrontTestimonial in storage.
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function update(UpdateFrontTestimonialRequest $request, FrontTestimonial $frontTestimonial): RedirectResponse
    {
        $frontTestimonial = $this->frontTestimonialRepository->update($request->all(),
            $frontTestimonial->id);

        Flash::success(__('messages.success_message.front_testimonial_updated'));

        return redirect(route('front-testimonials.index'));
    }

    /**
     * Remove the specified FrontTestimonial from storage.
     */
    public function destroy(FrontTestimonial $frontTestimonial): JsonResponse
    {
        if ($frontTestimonial->is_default == 1) {
            return $this->sendError(__('messages.success_message.default_testimonial_cant_delete'));
        }

        $frontTestimonial->delete();

        return $this->sendSuccess(__('messages.success_message.front_testimonial_deleted'));
    }
}
