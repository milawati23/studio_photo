<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Customer;
use App\Livewire\Forms\CustomerForm;

new class extends Component
{
    public CustomerForm $form;

    #[On('edit-customer')]
    public function editCustomer($id){
        // Mencari data customer berdasarkan custom primary key 'customer_id' Anda
        $customer = Customer::where('customer_id', $id)->first();
        
        if ($customer) {
            $this->form->setCustomer($customer);
            Flux::modal('edit-customer')->show();
        }
    }

    public function updateCustomer() {
        $this->form->update();
        Flux::modal('edit-customer')->close();
        
        session()->flash('success', 'Customer updated successfully');
        $this->redirectRoute('customer.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $customer = Customer::where('customer_id', $id)->first();
        
        if ($customer) {
            $this->form->setCustomer($customer);
            Flux::modal('delete-customer')->show();
        }
    }

    public function deleteCustomer() {
        // Melakukan delete melalui instance model customer yang tersimpan di form object
        $this->form->customer->delete();
        Flux::modal('delete-customer')->close();
        
        session()->flash('success', 'Customer deleted successfully');
        $this->redirectRoute('customer.index', navigate: true);
    }
};
?>

<div>
    {{-- ==================== EDIT MODAL ==================== --}}
    <flux:modal 
        name="edit-customer" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="updateCustomer">
            {{-- Header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Edit Customer
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Edit your customer details below
                </flux:text>
            </div>

            {{-- Form Field --}}
            <div class="space-y-6">
                {{-- Nama Customer --}}
                <flux:input
                    label="Customer Name"
                    placeholder="Enter customer name"
                    wire:model="form.customer_name"
                    wire:dirty.class.text-red-500
                />

                {{-- Nomor Telepon --}}
                <flux:input
                    type="text"
                    label="Phone Number"
                    placeholder="Enter phone number"
                    icon-before="phone"
                    wire:model="form.phone_number"
                    wire:dirty.class.text-red-500
                />

                {{-- Alamat --}}
                <flux:textarea
                    label="Address"
                    placeholder="Enter customer address"
                    wire:model="form.address"
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
        name="delete-customer" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="deleteCustomer">
            {{-- Header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Delete Customer
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Are you sure you want to delete this customer? This action cannot be undone.
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