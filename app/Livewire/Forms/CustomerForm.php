<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Customer;

class CustomerForm extends Form
{
    // Properti sesuai dengan tabel customers di ERD Anda
    public string $customer_name = '';
    public string $phone_number = '';
    public string $address = '';
    
    // Menyimpan instance model Customer saat mode Edit
    public ?Customer $customer = null;

    public function rules(): array
    {
        return [
            'customer_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'phone_number' => [
                'required',
                'string',
                'min:8',
                'max:20', // Memastikan panjang nomor telepon wajar
            ],
            'address' => [
                'required',
                'string',
                'max:500',
            ],
        ];
    }

    // Fungsi untuk Simpan (Create)
    public function store()
    {
        $this->validate();
        
        Customer::create($this->only(['customer_name', 'phone_number', 'address']));
        
        $this->reset(); // Kosongkan form setelah berhasil menyimpan
    }

    // Fungsi untuk Mengisi Data ke Form saat Edit
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
        $this->customer_name = $customer->customer_name;
        $this->phone_number = $customer->phone_number;
        $this->address = $customer->address;
    }

    // Fungsi untuk Perbarui Data (Update)
    public function update()
    {
        $this->validate();
        
        // Di latar belakang, Laravel akan mencari berdasarkan `customer_id` karena sudah diatur di Model Customer
        $this->customer->update($this->only(['customer_name', 'phone_number', 'address']));
    }
}