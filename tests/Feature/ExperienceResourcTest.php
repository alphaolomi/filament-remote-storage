<?php

use function Pest\Livewire\livewire;
use App\Filament\Resources\ExperienceResource;
use App\Filament\Resources;
use App\Models\Experience;

it('can render experience page', function () {
    $this->get(ExperienceResource::getUrl('index'))->assertSuccessful();
});

it('can list posts', function () {
    $Experiences = Experience::factory()->count(10)->create();


    /** @var \Livewire\Testing\TestableLivewire $livewire */
    $livewire = livewire(Resources\ExperienceResource\Pages\ListExperiences::class);

<<<<<<< Updated upstream
    $livewire
        ->assertSee($Experiences->first()->title)
        ->assertSuccessful();
    // ->assertCanSeeTableRecords($Experiences);
=======
    $livewire->assertSee($Experiences->first()->title)
        ->assertSuccessful()
        ->assertCanSeeTableRecords($Experiences);
>>>>>>> Stashed changes
});
