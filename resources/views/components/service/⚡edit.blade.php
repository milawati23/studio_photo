<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Service;
use App\Models\Category;
use App\Livewire\Forms\ServiceForm;

new class extends Component
{
    public ServiceForm $form;

    // Ambil list kategori untuk keperluan isi dropdown select
    public function getCategoriesProperty()
    {
        return Category::all();
    }

    #[On('edit-service')]
    public function editService($id){
        // Mencari data service berdasarkan custom primary key 'service_id' Anda
        $service = Service::where('service_id', $id)->first();
        
        if ($service) {
            $this->form->setService($service);
            Flux::modal('edit-service')->show();
        }
    }

    public function updateService() {
        $this->form->update();
        Flux::modal('edit-service')->close();
        
        session()->flash('success', 'Service updated successfully');
        $this->redirectRoute('service.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $service = Service::where('service_id', $id)->first();
        
        if ($service) {
            $this->form->setService($service);
            Flux::modal('delete-service')->show();
        }
    }

    public function deleteService() {
        $this->form->service->delete();
        Flux::modal('delete-service')->close();
        
        session()->flash('success', 'Service deleted successfully');
        $this->redirectRoute('service.index', navigate: true);
    }
};
?>

<div>
    {{-- ==================== EDIT MODAL ==================== --}}
    <flux:modal 
        name="edit-service" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="updateService">
            {{-- Header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Edit Service
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Edit your photo studio service and pricing details below
                </flux:text>
            </div>

            {{-- Form Field --}}
            <div class="space-y-6">
                {{-- Nama Service --}}
                <flux:input
                    label="Service Name"
                    placeholder="Enter service name"
                    wire:model="form.service_name"
                    wire:dirty.class.text-red-500
                />

                {{-- Dropdown Kategori --}}
                <flux:select label="Category" placeholder="Select category..." wire:model="form.category_id">
                    @foreach($this->categories as $category)
                        <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                {{-- Harga --}}
                <flux:input
                    type="number"
                    label="Price"
                    placeholder="Enter price amount"
                    icon-before="currency-dollar"
                    wire:model="form.price"
                    wire:dirty.class.text-red-500
                />

                {{-- Deskripsi --}}
                <flux:textarea
                    label="Description"
                    placeholder="Enter service description"
                    wire:model="form.description"
                    wire:dirty.class.text-red-500
                />
            </div>

            {{-- Warning Dirty --}}
            <div 
                wire:show="$dirty"
                class="text-red-500 dark:text-red-400 font-medium text-sm"
            >
                You have unsaved changes
            </div>
    
            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- ==================== DELETE MODAL ==================== --}}
    <flux:modal 
        name="delete-service" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="deleteService">
            {{-- Header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Delete Service
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Are you sure you want to delete this service? This action cannot be undone.
                </flux:text>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>
</div>