<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePersonalExperienceRequest;
use App\Http\Requests\UpdatePersonalExperienceRequest;
use App\Models\PersonalExperience;
use App\Models\User;
use App\Repositories\PersonalExperienceRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class PersonalExperienceController extends AppBaseController
{
    /** @var PersonalExperienceRepository */
    private $personalExperienceRepository;

    public function __construct(PersonalExperienceRepository $personalExperienceRepo)
    {
        $this->personalExperienceRepository = $personalExperienceRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('personal_experiences.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePersonalExperienceRequest $request): JsonResponse
    {
        $input = $request->all();
        $personalExperience = $this->personalExperienceRepository->create($input);

        return $this->sendSuccess(__('messages.success_message.personal_exp_created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalExperience $personalExperience): JsonResponse
    {
        return $this->sendResponse($personalExperience, __('messages.success_message.personal_exp_retrieved'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonalExperienceRequest $request, PersonalExperience $personalExperience): JsonResponse
    {
        $input = $request->all();
        $personalExperience = $this->personalExperienceRepository->update($input, $personalExperience->id);

        return $this->sendSuccess(__('messages.success_message.personal_exp_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalExperience $personalExperience): JsonResponse
    {
        if ($personalExperience->is_default) {
            return $this->sendError(__('messages.success_message.personal_exp_cant_delete'));
        }

        $exits = User::wherePersonalExperienceId($personalExperience->id)->exists();
        if ($exits) {
            return $this->sendError(__('messages.success_message.used_somewhere'));
        }

        $personalExperience->delete();

        return $this->sendSuccess(__('messages.success_message.personal_exp_deleted'));
    }
}
