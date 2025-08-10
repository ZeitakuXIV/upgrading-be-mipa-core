<?php

namespace App\Livewire;

use App\Models\Author;
use Livewire\Component;

class AuthorSearch extends Component
{
    public $search = '';
    public $selectedAuthor = null;

    public function mount()
    {
        // TODO: Initialize component state if needed
    }

    public function updatedSearch()
    {
        // TODO: Reset pagination when search changes if using pagination
        $this->selectedAuthor = null;
    }

    public function selectAuthor($authorId)
    {
        $this->selectedAuthor = Author::with(['books', 'films'])->find($authorId);
    }

    public function clearSelection()
    {
        $this->selectedAuthor = null;
    }

    public function render()
    {
        $authors = Author::query()
            ->when($this->search, function ($query) {
                return $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('bio', 'like', '%' . $this->search . '%');
            })
            ->with(['books', 'films'])
            ->get();

        return view('livewire.author-search', [
            'authors' => $authors
        ]);
    }
}
