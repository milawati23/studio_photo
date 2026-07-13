<?php

use Livewire\Component;
use App\Livewire\Forms\CustomerForm;

new class extends Component
{
    // Gunakan CustomerForm yang menampung customer_name, phone_number, dan address
    public CustomerForm $form;

    public function save()
    {
        $this->form->store();
        Flux::modal('create-customer')->close();

        // Flash Session khusus customer
        session()->flash('success', 'Customer created successfully');

        // Mengarahkan kembali ke index pelanggan dengan fitur wire:navigate
        $this->redirectRoute('customer.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    {{-- Nama modal disesuaikan menjadi create-customer --}}
    <flux:modal name="create-customer" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            {{-- Header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Create Customer
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Add a new customer profile to your photo studio system
                </flux:text>
            </div>

            {{-- Form Field --}}
            <div class="space-y-6">
                {{-- Field 1: Nama Customer --}}
                <flux:input
                    label="Customer Name"
                    placeholder="Enter customer's full name"
                    wire:model="form.customer_name"
                />

                {{-- Field 2: Nomor Telepon --}}
                <flux:input
                    type="tel"
                    label="Phone Number"
                    placeholder="Enter phone number (e.g., 08123456789)"
                    icon-before="phone"
                    wire:model="form.phone_number"
                />

                {{-- Field 3: Alamat --}}
                <flux:textarea
                    label="Address"
                    placeholder="Enter customer's complete address..."
                    wire:model="form.address"
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