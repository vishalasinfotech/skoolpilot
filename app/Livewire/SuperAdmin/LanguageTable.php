<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Language;
use Livewire\Component;
use Livewire\WithPagination;

class LanguageTable extends Component
{
    use WithPagination;

    public $search = '';

    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function toggleStatus($id): void
    {
        $language = Language::findOrFail($id);

        if ($language->is_default) {
            session()->flash('error', __('common.cannot_deactivate_default_language'));

            return;
        }

        $language->toggleStatus();
        session()->flash('success', __('common.language_status_updated'));
    }

    public function setAsDefault($id): void
    {
        $language = Language::findOrFail($id);

        if (! $language->is_active) {
            session()->flash('error', __('common.cannot_set_inactive_as_default'));

            return;
        }

        $language->setAsDefault();
        session()->flash('success', __('common.default_language_updated'));
    }

    public function delete(int $id): void
    {
        $language = Language::findOrFail($id);

        // Cannot delete default language
        if ($language->is_default) {
            session()->flash('error', __('common.cannot_delete_default_language'));

            return;
        }

        $language->delete();

        session()->flash('success', __('common.language_deleted_successfully'));
    }

    public function openDeleteModal(int $id, string $name, string $code): void
    {
        $this->dispatch('openDeleteModal', [
            'languageId' => $id,
            'languageName' => $name,
            'languageCode' => $code,
        ]);
    }

    public function render()
    {
        $languages = Language::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('code', 'like', '%'.$this->search.'%')
                        ->orWhere('native_name', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('is_default', 'desc')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.super-admin.language-table', [
            'languages' => $languages,
        ]);
    }
}
