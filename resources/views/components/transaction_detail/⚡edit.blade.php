<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\Service;
use App\Livewire\Forms\TransactionDetailForm;

new class extends Component
{
    public TransactionDetailForm $form;

    #[Computed]
    public function transactions()
    {
        return Transaction::all();
    }

    #[Computed]
    public function services()
    {
        return Service::all();
    }

    #[On('edit-transaction_detail')]
    public function editTransactionDetail($id)
    {
        $detail = TransactionDetail::where('transactiondetail_id', $id)->first();
        if ($detail) {
            $this->form->setTransactionDetail($detail);
            Flux::modal('edit-transaction_detail')->show();
        }
    }

    public function updateTransactionDetail() 
    {
        $this->form->update();
        Flux::modal('edit-transaction_detail')->close();
        session()->flash('success', 'Transaction detail updated successfully');
        $this->redirectRoute('transaction_detail.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $detail = TransactionDetail::where('transactiondetail_id', $id)->first();
        if ($detail) {
            $this->form->setTransactionDetail($detail);
            Flux::modal('delete-transaction_detail')->show();
        }
    }

    public function deleteTransactionDetail() 
    {
        $this->form->transactionDetail->delete();
        Flux::modal('delete-transaction_detail')->close();
        session()->flash('success', 'Transaction detail deleted successfully');
        $this->redirectRoute('transaction_detail.index', navigate: true);
    }
};
?>

<div>
    {{-- ==================== EDIT MODAL ==================== --}}
    <flux:modal name="edit-transaction_detail" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="updateTransactionDetail">
            <div class="space-y-2">
                <flux:heading size="lg">Edit Transaction Detail</flux:heading>
                <flux:text class="text-zinc-500">Edit transaction detail items below</flux:text>
            </div>

            <div class="space-y-6">
                {{-- Dropdown Transaction ID --}}
                <flux:select label="Transaction" wire:model="form.transaction_id">
                    @foreach($this->transactions as $transaction)
                        <flux:select.option value="{{ $transaction->transaction_id }}">
                            ID: #{{ $transaction->transaction_id }} - {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                {{-- Dropdown Service --}}
                <flux:select label="Service" wire:model="form.service_id">
                    @foreach($this->services as $service)
                        <flux:select.option value="{{ $service->id }}">{{ $service->service_name }}</flux:select.option>
                    @endforeach
                </flux:select>

                {{-- Input Quantity --}}
                <flux:input type="number" label="Quantity" min="1" wire:model="form.quantity" wire:dirty.class.text-red-500 />
                
                {{-- Input Subtotal --}}
                <flux:input type="number" label="Subtotal" icon-before="currency-dollar" wire:model="form.subtotal" wire:dirty.class.text-red-500 />
            </div>

            <div wire:show="$dirty" class="text-red-500 font-medium text-sm">You have unsaved changes</div>
    
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close><flux:button variant="outline" color="neutral">Cancel</flux:button></flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- ==================== DELETE MODAL ==================== --}}
    <flux:modal name="delete-transaction-detail" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="deleteTransactionDetail">
            <div class="space-y-2">
                <flux:heading size="lg">Delete Transaction Detail</flux:heading>
                <flux:text class="text-zinc-500">Are you sure you want to delete this transaction detail item? This action cannot be undone.</flux:text>
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close><flux:button variant="outline" color="neutral">Cancel</flux:button></flux:modal.close>
                <flux:button variant="primary" color="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>
</div>