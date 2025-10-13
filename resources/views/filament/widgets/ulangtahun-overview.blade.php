<x-filament-widgets::widget>
    @if ($visible)
    <x-filament::section collapsible
        icon="heroicon-o-user"
        icon-color="info"
    >
        <x-slot name="heading">
            Daftar Pegawai Ulang Tahun Minggu Ini
        </x-slot>

        <x-slot name="description">
            Berikut adalah daftar pegawai yang akan merayakan ulang tahun pada minggu ini.
        </x-slot>

        <br><br>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($data['ulangtahun'] as $pegawai)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pegawai->nama }}
                            <br>
                            <i>{{ \Carbon\Carbon::parse($pegawai->ulangtahun)->format('d M Y') }} </i>
                            <br>
                            {{ $pegawai->unit }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if ($pegawai->status == 'Hari Ini')
                                <x-filament::badge color="success">
                                    {{ $pegawai->status }}
                                </x-filament::badge>
                            @else
                                <x-filament::badge color="info">
                                    {{ $pegawai->status }}
                                </x-filament::badge>
                            @endif
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>

    </x-filament::section>
    @endif
</x-filament-widgets::widget>
