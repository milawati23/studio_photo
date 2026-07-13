<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Customer;

new class extends Component
{
    use WithPagination;
    
    #[Computed]
    public function customers()
    {
        // Mengambil data pelanggan terbaru dengan paginasi 10 data per halaman
        return Customer::latest('customer_id')->paginate(10);
    }

    public function edit($id){
        // Menembakkan event ke komponen modal edit khusus customer
        $this->dispatch('edit-customer', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Customers</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage your studio photo customer data</flux:subheading>
    <flux:separator variant="subtle" />
    
    {{-- Trigger Modal Create --}}
    <flux:modal.trigger name="create-customer">
        <flux:button variant="primary" icon="plus" color="primary">Add Customer</flux:button>
    </flux:modal.trigger>

    {{-- Komponen Modal Create & Edit Khusus Customer --}}
    <livewire:customer.create />
    <livewire:customer.edit />
    
    {{-- Tabel Customer --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->customers">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Customer Name</flux:table.column>
                <flux:table.column>Phone Number</flux:table.column>
                <flux:table.column>Address</flux:table.column>
                <flux:table.column>Registered At</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->customers as $customer)
                    {{-- Key menggunakan customer_id sesuai struktur tabel Anda --}}
                    <flux:table.row :key="$customer->customer_id">

                        {{-- Nomor Urut --}}
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->customers->firstItem() - 1) }}
                        </flux:table.cell>

                        {{-- Nama Customer --}}
                        <flux:table.cell class="font-medium">
                            {{ $customer->customer_name }}
                        </flux:table.cell>

                        {{-- Nomor Telepon --}}
                        <flux:table.cell class="whitespace-nowrap text-zinc-700 dark:text-zinc-300">
                            {{ $customer->phone_number }}
                        </flux:table.cell>

                        {{-- Alamat --}}
                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ $customer->address }}
                        </flux:table.cell>

                        {{-- Waktu Terdaftar --}}
                        <flux:table.cell class="whitespace-nowrap">
                            {{ $customer->created_at?->diffForHumans() ?? '-' }}
                        </flux:table.cell>

                        {{-- Menu dropdown aksi --}}
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    {{-- Mengirim customer_id untuk di-edit --}}
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $customer->customer_id }})">Edit</flux:menu.item>

                                    <flux:menu.separator />

                                    {{-- Mengirim customer_id ke event konfirmasi hapus --}}
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $customer->customer_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>