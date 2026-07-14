<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Models\Payment;
use App\Models\Transaction;
use App\Livewire\Forms\PaymentForm;

new class extends Component
{
    public PaymentForm $form;

    #[Computed]
    public function transactions()
    {
        return Transaction::all();
    }

    #[On('edit-payment')]
    public function editPayment($id)
    {
        $payment = Payment::where('payment_id', $id)->first();
        if ($payment) {
            $this->form->setPayment($payment);
            Flux::modal('edit-payment')->show();
        }
    }

    public function updatePayment()
    {
        $this->form->update();
        Flux::modal('edit-payment')->close();
        session()->flash('success', 'Payment updated successfully');
        $this->redirectRoute('payment.index', navigate: true);
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $payment = Payment::where('payment_id', $id)->first();
        if ($payment) {
            $this->form->setPayment($payment);
            Flux::modal('delete-payment')->show();
        }
    }

    public function deletePayment()
    {
        $this->form->payment->delete();
        Flux::modal('delete-payment')->close();
        session()->flash('success', 'Payment deleted successfully');
        $this->redirectRoute('payment.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    {{-- ==================== EDIT MODAL ==================== --}}
    <flux:modal name="edit-payment" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="updatePayment">
            <div class="space-y-2">
                <flux:heading size="lg">Edit Payment</flux:heading>
                <flux:text class="text-zinc-500">Edit payment details below</flux:text>
            </div>

            <div class="space-y-6">
                <flux:select label="Transaction" wire:model="form.transaction_id">
                    @foreach($this->transactions as $transaction)
                        <flux:select.option value="{{ $transaction->transaction_id }}">
                            #{{ $transaction->transaction_id }} - {{ $transaction->customer->customer_name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input type="date" label="Payment Date" wire:model="form.payment_date" wire:dirty.class.text-red-500 />
                
                <flux:select label="Payment Method" wire:model="form.payment_method">
                    <flux:select.option value="Cash">Cash</flux:select.option>
                    <flux:select.option value="Transfer">Transfer</flux:select.option>
                    <flux:select.option value="QRIS">QRIS</flux:select.option>
                </flux:select>

                <flux:input type="number" label="Amount" icon-before="currency-dollar" wire:model="form.amount" wire:dirty.class.text-red-500 />
            </div>

            <div wire:show="$dirty" class="text-red-500 font-medium text-sm">You have unsaved changes</div>
    
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close><flux:button variant="outline" color="neutral">Cancel</flux:button></flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- ==================== DELETE MODAL ==================== --}}
    <flux:modal name="delete-payment" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="deletePayment">
            <div class="space-y-2">
                <flux:heading size="lg">Delete Payment</flux:heading>
                <flux:text class="text-zinc-500">Are you sure you want to delete this payment record? This action cannot be undone.</flux:text>
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close><flux:button variant="outline" color="neutral">Cancel</flux:button></flux:modal.close>
                <flux:button variant="primary" color="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>
</div>