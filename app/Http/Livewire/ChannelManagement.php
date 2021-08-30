<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Channel;
use App\Notifier\Channel\ChannelTypes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChannelManagement extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $filters = [];
    public $editMode = 1;
    public Channel $editing;

    protected $queryString = ['sorts'];
    protected $listeners = ['refreshChannels' => '$refresh'];

    public function rules() { return [
        'editing.title' => 'required|min:3',
        'editing.name' => 'required',
        'editing.conf' => 'required',
        'editing.version' => '',
        'editing.type' => 'required|in:'.implode(',', ChannelTypes::allTypes()),
    ]; }

    public function mount() { $this->editing = $this->makeBlankChannel(); }
    public function updatedFilters() { $this->resetPage(); }

    public function exportSelected()
    {
        return response()->streamDownload(function () {
            echo $this->selectedRowsQuery->toCsv();
        }, 'Channels.csv');
    }

    public function deleteSelected()
    {
        $deleteCount = $this->selectedRowsQuery->count();

        $this->selectedRowsQuery->delete();

        $this->showDeleteModal = false;

        $this->notify('You\'ve deleted '.$deleteCount.' Channels');
    }

    public function makeBlankChannel()
    {
        return Channel::make(['date' => now(), 'status' => 'success']);
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function create()
    {
        $this->useCachedRows();

        if ($this->editing->getKey()) $this->editing = $this->makeBlankChannel();

        $this->showEditModal = true;
    }

    public function edit(Channel $Channel)
    {
        $this->useCachedRows();

        if ($this->editing->isNot($Channel)) $this->editing = $Channel;

        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editing->id > 0) {
            if ($this->editing->user_id != Auth::id()) {
                abort(401);
            }

            $this->editing->version += 1;
        } else {
            $this->editing->version = 1;
            $this->editing->user_id = Auth::id();
        }

        $this->editing->save();
        $this->showEditModal = false;
    }

    public function resetFilters() { $this->reset('filters'); }

    public function getRowsQueryProperty()
    {
        $query = Channel::query()->where('user_id', Auth::id());;

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
        return view('livewire.channel-management', [
            'channels' => $this->rows,
        ])->layout('layouts.app', ['header' => 'Channels']);
    }
}
