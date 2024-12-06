<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use App\Repositories\AdminRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Laracasts\Flash\Flash;

class AdminController extends AppBaseController
{
    /** @var AdminRepository */
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): \Illuminate\View\View
    {
        return view('admins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): \Illuminate\View\View
    {
        return view('admins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAdminRequest $request): RedirectResponse
    {
        $input = $request->all();
        $this->adminRepository->store($input);

        Flash::success(__('messages.admin.admin_created_successfully'));

        return redirect(route('admins.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function show(User $admin)
    {
        $admin->load('roles');

        if ($admin->hasRole('user') || ($admin->hasRole('admin')) && $admin->is_super_admin) {
            return redirect()->back();
        }

        return view('admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(User $admin)
    {
        $admin->load(['media', 'roles']);

        if ($admin->hasRole('user') || ($admin->hasRole('admin')) && $admin->is_super_admin) {
            return redirect()->back();
        }

        return view('admins.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, User $admin): RedirectResponse
    {
        $input = $request->all();
        $this->adminRepository->update($input, $admin->id);

        Flash::success(__('messages.admin.admin_updated_successfully'));

        return redirect(route('admins.index'));
    }

    /**
     * @return mixed
     */
    public function destroy(User $admin)
    {
        if ($admin->hasRole('user')) {
            return $this->sendError(__('messages.user.this_admin_can_not_be_deleted'));
        }

        $admin->delete();

        return $this->sendSuccess(__('messages.admin.admin_deleted_successfully'));
    }
}
