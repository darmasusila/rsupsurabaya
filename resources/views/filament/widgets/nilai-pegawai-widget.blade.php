<x-filament-widgets::widget >
    @if ($visible)
    <x-filament::section >
        {{-- Widget title --}}
        {{-- Widget content --}}
        <x-slot name="heading">
            Rekap Data Pegawai Aktif
            
        </x-slot>

        <a href="{{ route('filament.admin.pages.laporan-pegawai') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:ring-4 focus:ring-gray-200 disabled:opacity-50 dark:text-white dark:bg-gray-700 dark:hover:bg-gray-800 dark:focus:ring-gray-700">
            Lihat Detail
        </a>

        <br><br>
        <div class="flex col-span-12 bg-amber-100">
            <h1>Berdasarkan Jenis Tenaga</h1>
            <hr>
        </div>
        <div class="flex col-span-12 bg-white" style="display: flex; flex-wrap: wrap;">
            {{-- Loop through the data and display each item --}}
            {{-- Assuming $data['rekap_jenistenaga'] contains the data to be displayed --}}
            @php
                $total_jenistenaga = 0;
                $total_statuspegawai = 0;
                $total_direktorat = 0;
                $total_jenjangpendidikan = 0;
            @endphp
            @foreach ($data['rekap_jenistenaga'] as $item)
                <div class="flex-1 p-4 border-b border-gray-200">
                    <div class="font-semibold">{{ $item->nama }}</div>
                    <div class="text-sm text-gray-600">{{ $item->jumlah }} pegawai</div>
                    @php
                        $total_jenistenaga += $item->jumlah;
                    @endphp
                </div>
            @endforeach
            <div class="flex-1 p-4 border-b border-gray-200">
                <div class="font-semibold">TOTAL</div>
                <div class="text-sm text-gray-600">{{ $total_jenistenaga }} pegawai</div>
            </div>

            <!-- New Section for Status Pegawai -->
            <div class="flex col-span-12 bg-amber-100" style="margin-top: 20px; width: 100%;">
                <h1>Berdasarkan Status Pegawai</h1>
                <hr>
            </div>
            <div class="flex col-span-12 bg-white" style="display: flex; flex-wrap: wrap;">
                {{-- Loop through the data and display each item --}}
                {{-- Assuming $data['rekap_statuspegawai'] contains the data to be displayed --}}
                @foreach ($data['rekap_statuspegawai'] as $item)
                    <div class="flex-1 p-4 border-b border-gray-200">
                        <div class="font-semibold">{{ $item->nama }}</div>
                        <div class="text-sm text-gray-600">{{ $item->jumlah }} pegawai</div>
                        @php
                            $total_statuspegawai += $item->jumlah;
                        @endphp
                    </div>
                @endforeach
                <div class="flex-1 p-4 border-b border-gray-200">
                    <div class="font-semibold">TOTAL</div>
                    <div class="text-sm text-gray-600">{{ $total_statuspegawai }} pegawai</div>
                </div>

                <!-- End of Status Pegawai Section -->

                <!--New Section for Direktorat -->
                <div class="flex col-span-12 bg-amber-100" style="margin-top: 20px; width: 100%;">
                    <h1>Berdasarkan Direktorat</h1>
                    <hr>
                </div>
                <div class="flex col-span-12 bg-white" style="display: flex; flex-wrap: wrap;">
                    {{-- Loop through the data and display each item --}}
                    {{-- Assuming $data['rekap_direktorat'] contains the data to be displayed --}}
                    @foreach ($data['rekap_direktorat'] as $item)
                        <div class="flex-1 p-6 border-b border-gray-200">
                            <div class="font-semibold">{{ $item->nama }}</div>
                            <div class="text-sm text-gray-600">{{ $item->jumlah }} pegawai</div>
                            @php
                                $total_direktorat += $item->jumlah;
                            @endphp
                        </div>
                    @endforeach
                    <div class="flex-1 p-6 border-b border-gray-200">
                        <div class="font-semibold">TOTAL</div>
                        <div class="text-sm text-gray-600">{{ $total_direktorat }} pegawai</div>
                    </div>
                </div>
                <!-- End of Direktorat Section -->

                <!-- New Section for Jenjang Pendidikan -->
                <div class="flex col-span-12 bg-amber-100" style="margin-top: 20px; width: 100%;">
                    <h1>Berdasarkan Jenjang Pendidikan</h1>
                    <hr>
                </div>
                <div class="flex col-span-12 bg-white" style="display: flex; flex-wrap: wrap;">
                    {{-- Loop through the data and display each item --}}
                    {{-- Assuming $data['rekap_jenjangpendidikan'] contains the data to be displayed --}}
                    @foreach ($data['rekap_jenjangpendidikan'] as $item)
                        <div class="flex-1 p-6 border-b border-gray-200">
                            <div class="font-semibold">{{ $item->jenjang }}</div>
                            <div class="text-sm text-gray-600">{{ $item->jumlah }}</div>
                        </div>
                        @php
                            $total_jenjangpendidikan += $item->jumlah;
                        @endphp
                    @endforeach
                    <div class="flex-1 p-6 border-b border-gray-200">
                        <div class="font-semibold">TOTAL</div>
                        <div class="text-sm text-gray-600">{{ $total_jenjangpendidikan }}</div>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>
    @endif
</x-filament-widgets::widget>
