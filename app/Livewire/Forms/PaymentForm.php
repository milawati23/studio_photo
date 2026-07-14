<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Payment;

class PaymentForm extends Form
{
    public string $transaction_id = '';
    public string $payment_method = '';
    public string $amount_paid = '0';
    public string $payment_status = 'Pending'; // Default awal

    public ?Payment $payment = null;

    public function rules(): array
    {
        return [
            'transaction_id' => ['required', 'exists:transactions,transaction_id'], // sesuaikan 'id' jika di DB-mu pakai 'id' biasa
            'payment_method' => ['required', 'string'],
            'amount_paid'    => ['required', 'numeric', 'min:0'],
            'payment_status' => ['required', 'string'],
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

        $this->reset();
    }

    public function setPayment(Payment $payment): void
    {
        $this->payment        = $payment;
        $this->transaction_id = (string) $payment->transaction_id;
        $this->payment_method = $payment->payment_method;
        $this->amount_paid    = $payment->amount_paid;
        $this->payment_status = $payment->payment_status;
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
}