<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Payment;

class PaymentForm extends Form
{
    // Menggunakan string kosong '' supaya sinkron dengan Flux UI
    public string $transaction_id = '';
    public string $payment_method = '';
    public string $amount_paid = '0';
    public string $payment_status = 'pending';
    
    public ?Payment $payment = null;

    public function rules(): array
    {
        return [
            'transaction_id' => ['required', 'exists:transactions,transaction_id'],
            'payment_method' => ['required', 'string', 'max:255'], 
            'amount_paid'    => ['required', 'numeric', 'min:0'],
            'payment_status' => ['required', 'string', 'in:pending,success,failed,paid'], // Sesuai opsi status kamu
        ];
    }

    public function store()
    {
        $this->validate();
        
        Payment::create([
            'transaction_id' => $this->transaction_id,
            'payment_method' => $this->payment_method, 
            'amount_paid'    => $this->amount_paid,
            'payment_status' => $this->payment_status,
        ]);
        
        // Reset kembali ke kondisi awal setelah data tersimpan
        $this->resetValues();
    }

    public function setPayment(Payment $payment): void
    {
        $this->payment        = $payment;
        $this->transaction_id = (string) $payment->transaction_id;
        $this->payment_method = (string) $payment->payment_method;
        $this->amount_paid    = (string) $payment->amount_paid;
        $this->payment_status = (string) $payment->payment_status;
    }

    public function update()
    {
        $this->validate();
        
        $this->payment->update([
            'transaction_id' => $this->transaction_id,
            'payment_method' => $this->payment_method,
            'amount_paid'    => $this->amount_paid,
            'payment_status' => $this->payment_status,
        ]);
    }

    /**
     * Helper untuk mereset properti form kembali bersih
     */
    public function resetValues(): void
    {
        $this->transaction_id = '';
        $this->payment_method = '';
        $this->amount_paid    = '0';
        $this->payment_status = 'pending';
    }
}