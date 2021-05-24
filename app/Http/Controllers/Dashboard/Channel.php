<?php


namespace App\Http\Controllers\Dashboard;


use Livewire\Component;

class Channel extends Component
{
    public function render()
    {
        return view('dashboard.channel')->layout('layouts.app');
    }
}
