<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Payment;

new class extends Component
{
    use WithPagination;
    
    #[Computed]
    public function payments()
    {
        // Mengambil data payment dengan relasi ke transaction
        return Payment::with(['transaction'])
            ->latest('payment_id')
            ->paginate(10);
    }

    public function edit($id)
    {
        $this->dispatch('edit-payment', id: $id);
    }

};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Payments</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage transaction payment records</flux:subheading>
    <flux:separator variant="subtle" />
    
    {{-- Trigger Modal Create --}}
    <flux:modal.trigger name="create-payment">
        <flux:button variant="primary" icon="plus" color="primary">Add Payment</flux:button>
    </flux:modal.trigger>

    {{-- Komponen Modal Terpisah --}}
    <livewire:payment.create />
    <livewire:payment.edit />
    
    {{-- Tabel Pembayaran --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->payments">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Payment Date</flux:table.column>
                <flux:table.column>Transaction ID</flux:table.column>
                <flux:table.column>Method</flux:table.column>
                <flux:table.column>Amount</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->payments as $payment)
                    <flux:table.row :key="$payment->payment_id">
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->payments->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                        </flux:table.cell>

                        <flux:table.cell class="font-medium">
                            #{{ $payment->transaction_id }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $payment->payment_method }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $payment->payment_id }})">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash" 
                                        wire:click="$dispatch('confirm-delete', {id: {{ $payment->payment_id }}})"
                                        wire:confirm="Are you sure you want to delete this payment?">
                                        Delete
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>