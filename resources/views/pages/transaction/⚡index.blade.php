<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Transaction;

new class extends Component
{
    use WithPagination;
    
    #[Computed]
    public function transactions()
    {
        return Transaction::with(['customer', 'user'])->latest('transaction_id')->paginate(10);
    }

    public function edit($id){
        $this->dispatch('edit-transaction', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Transactions</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage photo studio transactions data</flux:subheading>
    <flux:separator variant="subtle" />
    
    {{-- Trigger Modal Create --}}
    <flux:modal.trigger name="create-transaction">
        <flux:button variant="primary" icon="plus" color="primary">Add Transaction</flux:button>
    </flux:modal.trigger>

    {{-- Komponen Modal Terpisah --}}
    <livewire:transaction.create />
    <livewire:transaction.edit />
    
    {{-- Tabel Transaksi --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->transactions">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Transaction Date</flux:table.column>
                <flux:table.column>Customer Name</flux:table.column>
                <flux:table.column>Total Amount</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->transactions as $transaction)
                    <flux:table.row :key="$transaction->transaction_id">
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->transactions->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}
                        </flux:table.cell>

                        <flux:table.cell class="font-medium">
                            {{ $transaction->customer->customer_name }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge size="sm" :color="$transaction->status === 'Paid' ? 'green' : 'amber'" inset="top bottom">
                                {{ $transaction->status }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $transaction->transaction_id }})">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $transaction->transaction_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>