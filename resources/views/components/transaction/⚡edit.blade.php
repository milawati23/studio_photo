<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Models\Transaction;
use App\Models\Customer;
use App\Livewire\Forms\TransactionForm;

new class extends Component
{
    public TransactionForm $form;

    #[Computed]
    public function customers()
    {
        return Customer::all();
    }

    #[On('edit-transaction')]
    public function editTransaction($id){
        $transaction = Transaction::where('transaction_id', $id)->first();
        if ($transaction) {
            $this->form->setTransaction($transaction);
            Flux::modal('edit-transaction')->show();
        }
    }

    public function updateTransaction() {
        $this->form->update();
        Flux::modal('edit-transaction')->close();
        session()->flash('success', 'Transaction updated successfully');
        $this->redirectRoute('transaction.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $transaction = Transaction::where('transaction_id', $id)->first();
        if ($transaction) {
            $this->form->setTransaction($transaction);
            Flux::modal('delete-transaction')->show();
        }
    }

    public function deleteTransaction() {
        $this->form->transaction->delete();
        Flux::modal('delete-transaction')->close();
        session()->flash('success', 'Transaction deleted successfully');
        $this->redirectRoute('transaction.index', navigate: true);
    }
};
?>

<div>
    {{-- ==================== EDIT MODAL ==================== --}}
    <flux:modal name="edit-transaction" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="updateTransaction">
            <div class="space-y-2">
                <flux:heading size="lg">Edit Transaction</flux:heading>
                <flux:text class="text-zinc-500">Edit transaction details below</flux:text>
            </div>

            <div class="space-y-6">
                <flux:select label="Customer" wire:model="form.customer_id">
                    @foreach($this->customers as $customer)
                        <flux:select.option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input type="date" label="Transaction Date" wire:model="form.transaction_date" wire:dirty.class.text-red-500 />
                <flux:input type="number" label="Total Amount" icon-before="currency-dollar" wire:model="form.total_amount" wire:dirty.class.text-red-500 />
                <flux:input type="number" label="Payment Amount" icon-before="currency-dollar" wire:model="form.payment_amount" wire:dirty.class.text-red-500 />
                <flux:input type="number" label="Change Amount" icon-before="currency-dollar" wire:model="form.change_amount" wire:dirty.class.text-red-500 />
                
                <flux:select label="Status" wire:model="form.status">
                    <flux:select.option value="Pending">Pending</flux:select.option>
                    <flux:select.option value="Paid">Paid</flux:select.option>
                </flux:select>
            </div>

            <div wire:show="$dirty" class="text-red-500 font-medium text-sm">You have unsaved changes</div>
    
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close><flux:button variant="outline" color="neutral">Cancel</flux:button></flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- ==================== DELETE MODAL ==================== --}}
    <flux:modal name="delete-transaction" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="deleteTransaction">
            <div class="space-y-2">
                <flux:heading size="lg">Delete Transaction</flux:heading>
                <flux:text class="text-zinc-500">Are you sure you want to delete this transaction record? This action cannot be undone.</flux:text>
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close><flux:button variant="outline" color="neutral">Cancel</flux:button></flux:modal.close>
                <flux:button variant="primary" color="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>
</div>