<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Livewire\Forms\TransactionForm;
use App\Models\Customer;

new class extends Component
{
    public TransactionForm $form;
    
    #[Computed]
    public function customers()
    {
        return Customer::all();
    }

    public function save()
    {
        $this->form->store();
        Flux::modal('create-transaction')->close();
        session()->flash('success', 'Transaction created successfully');
        $this->redirectRoute('transaction.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-transaction" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">Create Transaction</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">Add a new photo studio transaction record</flux:text>
            </div>

            <div class="space-y-6">
                <flux:select label="Customer" placeholder="Select customer..." wire:model="form.customer_id">
                    @foreach($this->customers as $customer)
                        <flux:select.option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input type="date" label="Transaction Date" wire:model="form.transaction_date" />
                <flux:input type="number" label="Total Amount" placeholder="Enter total amount" icon-before="currency-dollar" wire:model="form.total_amount" />
                <flux:input type="number" label="Payment Amount" placeholder="Enter payment amount" icon-before="currency-dollar" wire:model="form.payment_amount" />
                <flux:input type="number" label="Change Amount" placeholder="Enter change amount" icon-before="currency-dollar" wire:model="form.change_amount" />

                <flux:select label="Status" placeholder="Select status..." wire:model="form.status">
                    <flux:select.option value="Pending">Pending</flux:select.option>
                    <flux:select.option value="Paid">Paid</flux:select.option>
                </flux:select>
            </div>
    
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close><flux:button variant="outline" color="neutral">Cancel</flux:button></flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Create</flux:button>
            </div>
        </form>
    </flux:modal>
</div>