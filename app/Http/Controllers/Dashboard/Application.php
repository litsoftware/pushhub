<?php


namespace App\Http\Controllers\Dashboard;


use Livewire\Component;

class Application extends Component
{
    public function render()
    {
        return view('dashboard.application')->layout('layouts.app');
    }
}
