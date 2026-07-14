<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\TransactionDetail;

class TransactionDetailForm extends Form
{
    // DIUBAH: Menggunakan string kosong '' (bukan null) supaya singkron dengan Flux UI
    public string $transaction_id = '';
    public string $service_id = '';
    public int $quantity = 1;
    public string $subtotal = '0';
    
    public ?TransactionDetail $transactionDetail = null;

    public function rules(): array
    {
        return [
            'transaction_id' => ['required', 'exists:transactions,transaction_id'],
            'service_id'     => ['required', 'exists:services,service_id'], 
            'quantity'       => ['required', 'integer', 'min:1'],
            'subtotal'       => ['required', 'numeric', 'min:0'],
        ];
    }

    public function store()
    {
        $this->validate();
        
        TransactionDetail::create([
            'transaction_id' => $this->transaction_id,
            'service_id'     => $this->service_id, 
            'quantity'       => $this->quantity,
            'subtotal'       => $this->subtotal,
        ]);
        
        // Reset kembali ke string kosong
        $this->transaction_id = '';
        $this->service_id = '';
        $this->quantity = 1;
        $this->subtotal = '0';
    }

    public function setTransactionDetail(TransactionDetail $transactionDetail): void
    {
        $this->transactionDetail = $transactionDetail;
        $this->transaction_id    = (string) $transactionDetail->transaction_id;
        $this->service_id        = (string) $transactionDetail->service_id;
        $this->quantity          = $transactionDetail->quantity;
        $this->subtotal          = $transactionDetail->subtotal;
    }

    public function update()
    {
        $this->validate();
        
        $this->transactionDetail->update([
            'transaction_id' => $this->transaction_id,
            'service_id'     => $this->service_id,
            'quantity'       => $this->quantity,
            'subtotal'       => $this->subtotal,
        ]);
    }
}