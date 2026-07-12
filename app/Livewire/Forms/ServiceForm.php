<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Service;
use Illuminate\Validation\Rule;

class ServiceForm extends Form
{
    // Sesuaikan properti dengan tabel services di ERD Anda
    public string $service_name = '';
    public ?int $category_id = null;
    public string $price = '';
    public string $description = '';
    
    // Menyimpan instance model Service saat mode Edit
    public ?Service $service = null;

    public function rules(): array
    {
        return [
            'service_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'category_id' => [
                'required',
                'exists:categories,id', // Memastikan kategori yang dipilih ada di DB
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    // Fungsi untuk Simpan (Create)
    public function store()
    {
        $this->validate();
        
        Service::create($this->only(['service_name', 'category_id', 'price', 'description']));
        
        $this->reset(); // Kosongkan form setelah berhasil menyimpan
    }

    // Fungsi untuk Mengisi Data ke Form saat Edit
    public function setService(Service $service): void
    {
        $this->service = $service;
        $this->service_name = $service->service_name;
        $this->category_id = $service->category_id;
        $this->price = $service->price;
        $this->description = $service->description ?? '';
    }

    // Fungsi untuk Perbarui Data (Update)
    public function update()
    {
        $this->validate();
        
        $this->service->update($this->only(['service_name', 'category_id', 'price', 'description']));
    }
}