<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On; // TAMBAHKAN INI
use Livewire\WithPagination;
use App\Models\TransactionDetail;

new class extends Component
{
    use WithPagination;
    
    #[Computed]
    public function transactionDetails()
    {
        return TransactionDetail::with(['transaction', 'service'])
            ->latest('transactiondetail_id')
            ->paginate(10);
    }

    public function edit($id)
    {
        $this->dispatch('edit-transaction_detail', id: $id);
    }

    // TAMBAHKAN FUNGSI INI: Untuk menangkap kiriman klik tombol delete & menghapusnya secara aman
    #[On('confirm-delete')]
    public function delete($id)
    {
        $detail = TransactionDetail::find($id);
        
        if ($detail) {
            $detail->delete();
            session()->flash('success', 'Transaction detail deleted successfully');
            
            // Redirect ulang secara halus agar tabel langsung ter-refresh bersih
            $this->redirectRoute('transaction_detail.index', navigate: true);
        }
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Transaction Details</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage detail items for photo studio transactions</flux:subheading>
    <flux:separator variant="subtle" />
    
    {{-- Trigger Modal Create --}}
    <flux:modal.trigger name="create-transaction_detail">
        <flux:button variant="primary" icon="plus" color="primary">Add Detail</flux:button>
    </flux:modal.trigger>

    {{-- Komponen Modal Terpisah --}}
    <livewire:transaction_detail.create />
    <livewire:transaction_detail.edit />
    
    {{-- Tabel Detail Transaksi --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->transactionDetails">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Transaction ID</flux:table.column>
                <flux:table.column>Service Name</flux:table.column>
                <flux:table.column>Quantity</flux:table.column>
                <flux:table.column>Subtotal</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->transactionDetails as $detail)
                    <flux:table.row :key="$detail->transactiondetail_id">
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->transactionDetails->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="font-medium">
                            #{{ $detail->transaction_id }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $detail->service->service_name }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $detail->quantity }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $detail->transactiondetail_id }})">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    {{-- Ditambahkan wire:confirm biar makin mantap & aman sebelum beneran kehapus --}}
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $detail->transactiondetail_id }}})" wire:confirm="Are you sure you want to delete this item?">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>