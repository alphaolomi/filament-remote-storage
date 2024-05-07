<?php

use function Pest\Livewire\livewire;
use App\Filament\Resources\ExperienceResource;
use App\Filament\Resources\ExperienceResource\Pages;
use App\Models\Experience;

it('can render experience page', function () {
    $url = ExperienceResource::getUrl('index');

    $this->get($url)->assertSuccessful();
});

it('can list posts', function () {
    $experiences = Experience::factory()
        ->count(10)->create();

    $page = livewire(Pages\ListExperiences::class);

    $page->assertSuccessful()
        ->assertSee($experiences->first()->title)       
        ->assertCanSeeTableRecords($experiences);
});



// --------------------------------------------------------
 
it('sends a notification', function () {
    livewire(CreatePost::class)
        ->assertNotified();
});
