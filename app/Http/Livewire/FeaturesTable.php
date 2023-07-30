<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use App\Models\Feature;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class FeaturesTable extends Component
{
    use WithPagination;

    public int $perPage = 10;
    public string $sortField = 'name';
    public string $direction = 'asc';
    protected string $paginationTheme = 'bootstrap';

    public string $search = '';

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            if ($this->direction === 'desc'){
                $this->direction = 'asc';
            }else{
                $this->direction = 'desc';
            }
        } else {
            $this->direction = 'asc';
        }
        $this->sortField = $field;
    }

    public function render(): Factory|View|Application
    {
        $features = Feature::query()
            ->withCount('comments','votes')
            ->latest()
            ->paginate($this->perPage)
        ;
        return view('livewire.features-table', ['features' => $features]);
    }
}
