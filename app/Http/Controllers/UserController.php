<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\PersonalExperience;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;

class UserController extends AppBaseController
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Application|Factory|View
     */
    public function create(): \Illuminate\View\View
    {
        $personalExperience = PersonalExperience::toBase()->pluck('name', 'id')->toArray();
        $plan = SubscriptionPlan::with('subscriptions')->get()->pluck('name', 'id');
        return view('users.create', compact('personalExperience','plan'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @return Application|Redirector|RedirectResponse
     */
    public function store(CreateUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $this->userRepository->store($input);

        Flash::success(__('messages.success_message.user_created'));

        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function show(User $user)
    {
        $user->load('roles');

        if ($user->hasRole('admin')) {
            return redirect()->back();
        }

        return view('users.show', compact('user'));
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(User $user)
    {
        $user->load(['media', 'roles']);

        if ($user->hasRole('admin')) {
            return redirect()->back();
        }

        $personalExperience = PersonalExperience::toBase()->pluck('name', 'id')->toArray();
        $currentPlan = Subscription::where('user_id', $user->id)->where('status', true)->value('subscription_plan_id');
        $plan = SubscriptionPlan::with('subscriptions')->get()->pluck('name', 'id')->toArray();
        return view('users.edit', compact('user', 'personalExperience','plan','currentPlan'));
    }

    /**
     * Update the specified User in storage.
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->userRepository->update($request->all(), $user->id);

        Flash::success(__('messages.success_message.user_updated'));

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        if ($user->hasRole('admin')) {
            return $this->sendError(__('messages.admin.this_user_can_not_be_deleted'));
        }

        $user->delete();

        return $this->sendSuccess(__('messages.success_message.user_deleted'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function impersonate(User $user): RedirectResponse
    {
        getLogInUser()->impersonate($user);

        return redirect(route('dashboard'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function impersonateLeave(): RedirectResponse
    {
        getLogInUser()->leaveImpersonation();

        return redirect(route('admin.dashboard'));
    }

    public function updateLanguage(Request $request): JsonResponse
    {
        $language = $request->get('language');
        $user = getLogInUser();
        $user->update(['language' => $language]);

        return $this->sendSuccess(__('messages.success_message.language_updated'));
    }
}
