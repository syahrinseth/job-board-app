<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class AiTextModal extends Component
{
    public bool $show = false;
    public string $title = 'Generate with AI';
    public string $maxWidth = 'sm:max-w-4xl';

    #[On('open-ai-modal')]
    public function openModal(): void
    {
        $this->show = true;
        $this->dispatch('ai-modal-opened');
    }

    #[On('close-ai-modal')]
    public function closeModal(): void
    {
        $this->show = false;
        $this->dispatch('ai-modal-closed');
    }

    public function mount(): void
    {
        $this->dispatch('ai-modal-ready');
    }

    public function render()
    {
        return view('livewire.ai-text-modal');
    }
}
