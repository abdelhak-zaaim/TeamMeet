<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AdminTable extends LivewireTableComponent
{
    public $showButtonOnHeader = true;

    public $showFilterOnHeader = false;

    public $buttonComponent = 'admins.component.add_button';

    public string $tableName = 'users';

    protected $model = User::class;

    protected $listeners = ['resetPageTable', 'refresh' => '$refresh', 'adminEmailVerify'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '4') {
                return [
                    'style' => 'text-align:center,padding-left:0!important',
                    'width' => '8%',
                ];
            }

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
        return view('livewire.listing-skeleton');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.common.name'), 'first_name')
                ->view('admins.component.name')->sortable()->searchable(function (Builder $query, $direction) {
                    $query->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like '%{$direction}%'");
                }),
            Column::make(__('messages.common.name'), 'last_name')->hideIf(true),
            Column::make(__('messages.admin.email'), 'email')->hideIf(true),
            Column::make(__('messages.admin.contact_number'), 'phone_number')
                ->view('admins.component.phone_number')->sortable()->searchable(),
            Column::make(__('messages.user.email_verified'),
                'email_verified_at')->view('admins.component.email_verified')->sortable(),
            Column::make(__('messages.common.action'), 'id')->view('admins.component.action'),
        ];
    }

    public function builder(): Builder
    {
        $query = User::query()->role('admin')
            ->with('media')
            ->whereIsSuperAdmin(false)
            ->where('id', '!=', getLogInUserId());

        return $query->select('users.*');
    }

    public function adminEmailVerify($id)
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
}
