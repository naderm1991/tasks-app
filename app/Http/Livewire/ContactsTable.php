<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ContactsTable extends Component
{
    use WithPagination;

    public int $perPage = 10;
    public string $sortField = 'name';
    public bool $sortAsc = true;

    public string $search = '';

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortField = $field;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.contacts-table', [
            'contacts' => Contact::search($this->search)
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }
}
