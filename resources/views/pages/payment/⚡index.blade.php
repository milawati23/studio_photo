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
        return Payment::with(['transaction'])
            ->latest('id')
            ->paginate(10);
    }

    public function edit($id)
    {
        $this->dispatch('edit-payment', id: $id);
    }

    #[On('confirm-delete')]
    public function delete($id)
    {
        $payment = Payment::find($id);
        
        if ($payment) {
            $payment->delete();
            session()->flash('success', 'Payment record deleted successfully');
            
            $this->redirectRoute('payment.index', navigate: true);
        }
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Payments</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage payment transactions and histories</flux:subheading>
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
                <flux:table.column>Transaction ID</flux:table.column>
                <flux:table.column>Payment Method</flux:table.column>
                <flux:table.column>Amount Paid</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->payments as $payment)
                    <flux:table.row :key="$payment->id">
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->payments->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="font-medium">
                            #{{ $payment->transaction_id }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ ucfirst($payment->payment_method) }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $payment->payment_status === 'success' || $payment->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ strtoupper($payment->payment_status) }}
                            </span>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $payment->id }})">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', { id: {{ $payment->id }} })" wire:confirm="Are you sure you want to delete this payment record?">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>