<?php

namespace App\Livewire\Pages\Payment;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        // Menggunakan 'id' sebagai pengurut agar tidak error
        $payments = Payment::orderBy('payment_id', 'desc')->paginate(10);
        
        return view('livewire.pages.payment.index', [
            'payments' => $payments
        ]);
    }
}

<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Pembayaran</h1>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">ID</th>
                <th class="border p-2">Total</th>
                <th class="border p-2">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td class="border p-2">{{ $payment->payment_id }}</td>
                    <td class="border p-2">{{ $payment->amount }}</td>
                    <td class="border p-2">{{ $payment->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $payments->links() }}
    </div>
</div>