<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UserTable extends LivewireTableComponent
{
    public $showButtonOnHeader = true;

    public $showFilterOnHeader = true;

    public $buttonComponent = 'users.component.add_button';

    protected $model = User::class;

    public string $tableName = 'users';

    public $statusFilter;

    public $FilterComponent = ['users.component.filter', 1];

    protected $listeners = ['resetPageTable', 'refresh' => '$refresh', 'changeFilter', 'userEmailVerify'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setThAttributes(function (Column $column) {
            if ($column->getField() == 'email_verified_at') {
                return [
                    'class' => 'text-center',
                ];
            }

            return [];
        });
    }

    public function placeholder()
    {
        return view('livewire.user-skeleton');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.user.full_name'), 'first_name')
                ->view('users.component.full_name')->sortable()->searchable(function (Builder $query, $direction) {
                    $query->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                }),
            Column::make(__('messages.user.full_name'), 'last_name')->hideIf(true),
            Column::make(__('messages.user.email'), 'email')->hideIf(true),
            Column::make(__('messages.user.personal_experience'), 'personalExperience.name')
                ->view('users.component.personal_expe')->sortable()->searchable(),
            Column::make(__('messages.user.personal_experience'), 'personal_experience_id')->hideIf(true),
            Column::make(__('messages.user.email_verified'),
                'email_verified_at')->view('users.component.email_verified')->sortable(),
            Column::make(__('messages.user.impersonate'), 'id')->view('users.component.impersonate'),
            Column::make(__('messages.common.action'), 'id')->view('users.component.action'),
        ];
    }

    public function builder(): Builder
    {
        $query = User::query()->role('user')->with(['media', 'personalExperience']);

        $query->when($this->statusFilter != '', function (Builder $q) {
            $q->where('personal_experience_id', $this->statusFilter);
        });

        return $query->select('users.*');
    }

    public function changeFilter($value)
    {
        $this->statusFilter = $value;
        $this->setBuilder($this->builder());
        $this->resetPagination();
    }

    public function userEmailVerify($id)
    {
        $user = User::find($id);
        $user->update(['email_verified_at' => Carbon::now()]);
        $this->setBuilder($this->builder());
        $this->dispatch('email-verify-success');
    }

    public function resetPageTable()
    {
        $this->customResetPage('usersPage');
    }

    public function resetPagination()
    {
        $this->resetPage('usersPage');
    }
}
