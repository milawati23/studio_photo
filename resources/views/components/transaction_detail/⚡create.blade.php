<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Livewire\Forms\TransactionDetailForm;
use App\Models\Transaction;
use App\Models\Service;

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

    public function save()
    {
        $this->form->store();
        Flux::modal('create-transaction_detail')->close();
        session()->flash('success', 'Transaction detail created successfully');
        $this->redirectRoute('transaction_detail.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-transaction_detail" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">Create Transaction Detail</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">Add a new item detail to a transaction record</flux:text>
            </div>

            <div class="space-y-6">
                {{-- Select Transaction ID --}}
                {{-- PERBAIKAN FLUX: Pakai wire:model biasa & value standar tanpa titik dua --}}
                <flux:select label="Transaction" placeholder="Select transaction..." wire:model="form.transaction_id">
                    @foreach($this->transactions as $transaction)
                        <flux:select.option value="{{ $transaction->transaction_id }}">
                            ID: #{{ $transaction->transaction_id }} - {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                {{-- Select Service --}}
                {{-- PERBAIKAN FLUX: Pastikan mengarah ke service_id dan value tanpa titik dua --}}
                <flux:select label="Service" placeholder="Select service..." wire:model="form.service_id">
                    @foreach($this->services as $service)
                        <flux:select.option value="{{ $service->service_id }}">
                            {{ $service->service_name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                        </flux:select.option>
                    @endforeach
                </flux:select>

                {{-- Input Quantity --}}
                <flux:input type="number" label="Quantity" min="1" placeholder="Enter quantity" wire:model="form.quantity" />

                {{-- Input Subtotal --}}
                <flux:input type="number" label="Subtotal" placeholder="Enter subtotal amount" icon-before="currency-dollar" wire:model="form.subtotal" />
            </div>
    
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close><flux:button variant="outline" color="neutral">Cancel</flux:button></flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Create</flux:button>
            </div>
        </form>
    </flux:modal>
</div>