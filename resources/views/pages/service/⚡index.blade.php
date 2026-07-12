<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Service;

new class extends Component
{
    use WithPagination;
    
    #[Computed]
    public function services()
    {
        // Menggunakan dengan eager loading 'category' agar aplikasi kasir lebih cepat/ringan
        return Service::with('category')->latest()->paginate(10);
    }

    public function edit($id){
        // Menembakkan event ke komponen modal edit dengan nama khusus untuk service
        $this->dispatch('edit-service', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Services</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage your studio photo services & pricing</flux:subheading>
    <flux:separator variant="subtle" />
    
    {{-- Trigger Modal Create --}}
    <flux:modal.trigger name="create-service">
        <flux:button variant="primary" icon="plus" color="primary">Add Service</flux:button>
    </flux:modal.trigger>

    {{-- Komponen Modal Create & Edit Khusus Service --}}
    <livewire:service.create />
    <livewire:service.edit />
    

    {{-- Tabel Layanan / Service --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->services">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Service Name</flux:table.column>
                <flux:table.column>Category</flux:table.column>
                <flux:table.column>Price</flux:table.column>
                <flux:table.column>Description</flux:table.column>
                <flux:table.column>Created At</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->services as $service)
                    {{-- Ingat! Key menggunakan service_id sesuai perubahan Anda --}}
                    <flux:table.row :key="$service->service_id">

                        {{-- Nomor Urut --}}
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->services->firstItem() - 1) }}
                        </flux:table.cell>

                        {{-- Nama Service --}}
                        <flux:table.cell class="font-medium">
                            {{ $service->service_name }}
                        </flux:table.cell>

                        {{-- Nama Kategori (Mengambil dari relasi) --}}
                        <flux:table.cell>
                            <flux:badge size="sm" color="zinc" inset="top bottom">
                                {{ $service->category->name ?? 'Uncategorized' }}
                            </flux:badge>
                        </flux:table.cell>

                        {{-- Harga Terformat Rupiah --}}
                        <flux:table.cell class="whitespace-nowrap font-semibold text-zinc-700 dark:text-zinc-300">
                            Rp {{ number_format($service->price, 0, ',', '.') }}
                        </flux:table.cell>

                        {{-- Deskripsi --}}
                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ $service->description ?? '-' }}
                        </flux:table.cell>

                        {{-- Waktu Dibuat --}}
                        <flux:table.cell class="whitespace-nowrap">
                            {{ $service->created_at->diffForHumans() }}
                        </flux:table.cell>

                        {{-- Menu dropdown aksi --}}
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    {{-- Mengirim service_id untuk di-edit --}}
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $service->service_id }})">Edit</flux:menu.item>

                                    <flux:menu.separator />

                                    {{-- Mengirim service_id ke event konfirmasi hapus --}}
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $service->service_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>