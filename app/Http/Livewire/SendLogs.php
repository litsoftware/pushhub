<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\SendLog;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SendLogs extends Component
{
    use WithPerPagePagination, WithSorting, WithCachedRows;

    public $showEditModal = false;
    public $showFilters = false;
    public $filters = [];

    protected $queryString = ['sorts'];
    protected $listeners = ['refreshChannels' => '$refresh'];

    public function mount() {}
    public function updatedFilters() { $this->resetPage(); }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters() { $this->reset('filters'); }

    public function getRowsQueryProperty()
    {
        $query = SendLog::query()->where('user_id', Auth::id());

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.send-logs', [
            'rows' => $this->rows
        ])->layout('layouts.app', ['header' => 'Send Log']);
    }
}
