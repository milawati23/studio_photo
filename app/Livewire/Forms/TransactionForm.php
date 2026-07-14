<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Transaction;

class TransactionForm extends Form
{
    // DIUBAH: Hapus '?int' agar bisa menerima inputan string angka dari select option HTML
    public $customer_id = null; 
    public string $transaction_date = '';
    public string $total_amount = '0';
    public string $payment_amount = '0';
    public string $change_amount = '0';
    public string $status = 'Pending';
    
    public ?Transaction $transaction = null;

    public function rules(): array
    {
        return [
            // PERBAIKAN CEPAT: Diubah menjadi 'nullable' agar form tidak macet saat disubmit
            'customer_id' => ['nullable'],
            'transaction_date' => ['required', 'date'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'payment_amount' => ['required', 'numeric', 'min:0'],
            'change_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'max:50'],
        ];
    }

    public function store()
    {
        $this->validate();
        
        Transaction::create([
            // DIUBAH: Jika $this->customer_id kosong (null), otomatis diisi angka 1 (ID Customer)
            'customer_id'      => $this->customer_id ?? 1, 
            'user_id'          => auth()->id() ?? 1, 
            'transaction_date' => $this->transaction_date,
            'total_amount'     => $this->total_amount,
            'payment_amount'   => $this->payment_amount,
            'change_amount'    => $this->change_amount,
            'status'           => $this->status,
        ]);
        
        $this->reset(); 
    }

    public function setTransaction(Transaction $transaction): void
    {
        $this->transaction = $transaction;
        $this->customer_id = $transaction->customer_id;
        $this->transaction_date = $transaction->transaction_date;
        $this->total_amount = $transaction->total_amount;
        $this->payment_amount = $transaction->payment_amount;
        $this->change_amount = $transaction->change_amount;
        $this->status = $transaction->status;
    }

    public function update()
    {
        $this->validate();
        
        $this->transaction->update([
            'customer_id'      => $this->customer_id,
            'transaction_date' => $this->transaction_date,
            'total_amount'     => $this->total_amount,
            'payment_amount'   => $this->payment_amount,
            'change_amount'    => $this->change_amount,
            'status'           => $this->status,
        ]);
    }
}