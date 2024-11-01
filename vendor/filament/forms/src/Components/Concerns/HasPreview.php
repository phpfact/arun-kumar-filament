<?php

namespace Filament\Forms\Components\Concerns;

use Closure;
use Illuminate\Contracts\View\View;

trait HasPreview
{
    protected string | Closure | null $preview = null;

    public function preview(string | Closure | null $preview): static
    {
        $this->preview = $preview;

        return $this;
    }

    public function hasPreview(): bool
    {
        return (bool) filled($this->evaluate($this->preview));
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function renderPreview(array $data): View
    {
        return view(
            $this->evaluate($this->preview),
            $data,
        );
    }
}
