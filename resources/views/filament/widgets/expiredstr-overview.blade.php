<x-filament-widgets::widget>
    @if ($visible)
    <x-filament::section collapsible
        icon="heroicon-o-user"
        icon-color="info"
    >
        <x-slot name="heading">
            Daftar Pegawai SIP Expired < 3 Bulan
        </x-slot>

        <x-slot name="description">
            Berikut adalah daftar pegawai yang SIP-nya akan berakhir dalam waktu kurang dari 3 bulan.
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
                @foreach ($data['expired_str'] as $pegawai)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pegawai->nama }}
                            <br>
                            <p style="font-size: 0.7rem">{{ $pegawai->no_sip }}
                            <br>
                            <i>{{ \Carbon\Carbon::parse($pegawai->tanggal_akhir_berlaku)->format('d M Y') }} </i>
                            | {{ $pegawai->unit }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if ($pegawai->status == 'expired')
                                <x-filament::badge color="danger" icon="heroicon-o-exclamation-circle">
                                </x-filament::badge>
                            @else
                                <x-filament::badge color="warning" icon="heroicon-o-exclamation-circle">
                                </x-filament::badge>
                            @endif
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>

    </x-filament::section>
    @endif
</x-filament-widgets::widget>
