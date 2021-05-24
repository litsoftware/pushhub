<?php


namespace App\Http\Controllers\Dashboard;


use Livewire\Component;

class Log extends Component
{
    public function render()
    {
        return view('dashboard.log')->layout('layouts.app');
    }
}
