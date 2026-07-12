<?php

use Livewire\Component;
use App\Livewire\Forms\ServiceForm;
use App\Models\Category;

new class extends Component
{
    // Gunakan ServiceForm yang sudah dibuat sebelumnya
    public ServiceForm $form;
    
    // Fungsi untuk mengambil semua data kategori untuk isi select option
    public function getCategoriesProperty()
    {
        return Category::all();
    }

    public function save()
    {
        $this->form->store();
        Flux::modal('create-service')->close();

        // Flash Session khusus service
        session()->flash('success', 'Service created successfully');

        // Mengarahkan kembali ke index layanan dengan fitur wire:navigate
        $this->redirectRoute('service.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    {{-- Nama modal disesuaikan menjadi create-service --}}
    <flux:modal name="create-service" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            {{-- Header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Create Service
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Add a new photo studio service and pricing to your system
                </flux:text>
            </div>

            {{-- Form Field --}}
            <div class="space-y-6">
                {{-- Field 1: Nama Service --}}
                <flux:input
                    label="Service Name"
                    placeholder="Enter service name (e.g., Paket Wisuda Premium)"
                    wire:model="form.service_name"
                />

                {{-- Field 2: Dropdown Pilihan Kategori --}}
                <flux:select label="Category" placeholder="Select category..." wire:model="form.category_id">
                    @foreach($this->categories as $category)
                        <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                {{-- Field 3: Harga (Price) --}}
                <flux:input
                    type="number"
                    label="Price"
                    placeholder="Enter price amount"
                    icon-before="currency-dollar"
                    wire:model="form.price"
                />

                {{-- Field 4: Deskripsi --}}
                <flux:textarea
                    label="Description"
                    placeholder="Enter service details, packages or facilities included..."
                    wire:model="form.description"
                />
            </div>
    
            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Create</flux:button>
            </div>
        </form>
    </flux:modal>
</div>