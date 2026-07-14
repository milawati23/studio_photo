<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Livewire\Forms\PaymentForm;
use App\Models\Transaction;

new class extends Component
{
    public PaymentForm $form;
    
    #[Computed]
    public function transactions()
    {
        // Mengambil transaksi yang statusnya belum 'Paid' atau semua transaksi
        return Transaction::all();
    }

    public function save()
    {
        $this->form->store();
        
        Flux::modal('create-payment')->close();
        
        session()->flash('success', 'Payment created successfully');
        
        // Redirect atau refresh halaman index payment
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
    <flux:modal name="create-payment" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">Create Payment</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">Add a new payment record for a transaction</flux:text>
            </div>

            <div class="space-y-6">
                {{-- Pilih Transaksi --}}
                <flux:select label="Transaction" placeholder="Select transaction..." wire:model="form.transaction_id">
                    @foreach($this->transactions as $transaction)
                        <flux:select.option value="{{ $transaction->transaction_id }}">
                            #{{ $transaction->transaction_id }} - {{ $transaction->customer->customer_name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                {{-- Tanggal Pembayaran --}}
                <flux:input type="date" label="Payment Date" wire:model="form.payment_date" />
                
                {{-- Metode Pembayaran --}}
                <flux:select label="Payment Method" placeholder="Select method..." wire:model="form.payment_method">
                    <flux:select.option value="Cash">Cash</flux:select.option>
                    <flux:select.option value="Transfer">Transfer</flux:select.option>
                    <flux:select.option value="QRIS">QRIS</flux:select.option>
                </flux:select>

                {{-- Jumlah --}}
                <flux:input type="number" label="Amount" placeholder="Enter payment amount" icon-before="currency-dollar" wire:model="form.amount" />
            </div>
    
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Save Payment</flux:button>
            </div>
        </form>
    </flux:modal>
</div>