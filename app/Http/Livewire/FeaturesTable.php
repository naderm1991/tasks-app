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

    public string|null $sortField = null;
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
            ->when($this->sortField, function ($query,$sortField) {
                switch ($sortField){
                    case 'title': return $query->orderBy('title',$this->direction);
                    case 'status': return $query->orderByStatus($this->direction);
                    case 'activity': return $query->orderByActivity($this->direction);
                }
            })
            ->latest()
            ->paginate()
        ;
        return view('livewire.features-table', ['features' => $features]);
    }
}
