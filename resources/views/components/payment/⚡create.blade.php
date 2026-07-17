<?php

use Livewire\Component;
use App\Livewire\Forms\PaymentForm;
use App\Models\Transaction;

new class extends Component
{
    public PaymentForm $form;

    // Mengambil daftar transaksi untuk pilihan dropdown di form
    public function getTransactionsProperty()
    {
        return Transaction::select('transaction_id', 'transaction_date', 'total_amount')->get();
    }

    public function save()
    {
        $this->form->store();

        session()->flash('success', 'Payment recorded successfully.');

        // PERBAIKAN: Gunakan backslash "\" di depan Flux agar tidak perlu menulis "use Flux" di atas
        \Flux::modal('create-payment')->close();

        // Refresh halaman secara halus agar data terupdate di tabel index
        $this->redirectRoute('payment.index', navigate: true);
    }
};
?>

<div>
    <flux:modal name="create-payment" class="md:w-[26rem]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">Add Payment Record</flux:heading>
                <flux:subheading>Record a new payment for a transaction.</flux:subheading>
            </div>

            <flux:separator />

            <!-- Pilihan Transaksi -->
            <flux:select wire:model="form.transaction_id" label="Transaction" placeholder="Choose a transaction...">
                <option value="">-- Select Transaction --</option>
                @foreach($this->transactions as $tx)
                    <option value="{{ $tx->transaction_id }}">
                        #{{ $tx->transaction_id }} - {{ $tx->transaction_date->format('d/m/Y') }} (Rp {{ number_format($tx->total_amount, 0, ',', '.') }})
                    </option>
                @endforeach
            </flux:select>

            <!-- Metode Pembayaran -->
            <flux:select wire:model="form.payment_method" label="Payment Method" placeholder="Select method...">
                <option value="">-- Select Method --</option>
                <option value="cash">Cash</option>
                <option value="transfer">Bank Transfer</option>
                <option value="qris">QRIS</option>
            </flux:select>

            <!-- Jumlah Pembayaran -->
            <flux:input 
                wire:model="form.amount_paid" 
                type="number" 
                label="Amount Paid" 
                placeholder="0" 
                min="0"
                icon="banknotes"
            />

            <!-- Status Pembayaran -->
            <flux:select wire:model="form.payment_status" label="Status">
                <option value="pending">PENDING</option>
                <option value="success">SUCCESS</option>
                <option value="failed">FAILED</option>
            </flux:select>

            <div class="flex space-x-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">Save Payment</flux:button>
            </div>
        </form>
    </flux:modal>
</div>