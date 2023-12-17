<?php
namespace App\Providers;
use App\Http\Controllers\Ejournal\Edit\EditPart1DirectionTask;
use App\Http\Controllers\Ejournal\Edit\EditPart2Preparation;
use App\Http\Controllers\Ejournal\Edit\EditPart4Meashures;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
class LivewireServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Livewire::component('edit-part1-direction-task', EditPart1DirectionTask::class);
        Livewire::component('edit-part2-preparation', EditPart2Preparation::class);
        Livewire::component('edit-part4-meashures', EditPart4Meashures::class);
    }
}
