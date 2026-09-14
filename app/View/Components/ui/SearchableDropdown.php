<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class SearchableDropdown extends Component
{
    public function __construct(
        public string $id,
        public string $name,
        public string $placeholder = 'Select an option',
        public string $searchPlaceholder = 'Search...',
        public ?string $selectedValue = null,
        public ?string $selectedLabel = null,
        public bool $required = false,
    ) {}

    public function render()
    {
        return view('components.ui.searchable-dropdown');
    }
}