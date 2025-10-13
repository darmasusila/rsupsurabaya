<x-filament-widgets::widget>
    @if (!$visible)
    <x-filament::section>
        <x-slot name="heading">
            Informasi Karyawan
        </x-slot>

        <div x-data="{activeTab : $wire.$entangle('activeTab') }">
            <x-filament::tabs label="Content tabs">
                <x-filament::tabs.item
                    :active="$activeTab === 'tab_1'"
                    wire:click="$set('activeTab', 'tab_1')"
                >
                    @lang('Visi & Misi')
                </x-filament::tabs.item>

                <x-filament::tabs.item
                    :active="$activeTab === 'tab_2'"
                    wire:click="$set('activeTab', 'tab_2')"
                >
                    @lang('Nilai Layanan')
                </x-filament::tabs.item>

                <x-filament::tabs.item
                    :active="$activeTab === 'tab_3'"
                    wire:click="$set('activeTab', 'tab_3')"
                >
                    @lang('Motto & Tujuan')
                </x-filament::tabs.item>
            </x-filament::tabs>

            <div>
                <div x-show="activeTab == 'tab_1'">
                    <div style="padding-top: 15px;">
                        <h1>Visi</h1>
                        <p class="text-sm text-gray-600">Menjadi rumah sakit rujukan dalam pelayanan kanker, jantung, stroke dan uronefrologi yang bertaraf internasional dengan pertumbuhan berkelanjutan.</p>
                        <h1 style="padding-top: 10px;">Misi</h1>
                        <p class="text-sm text-gray-600">
                            <ol class="list-decimal pl-5 text-gray-600" style="padding-left: 1rem;">
                                <li>Memberikan pelayanan kesehatan yang bermutu dengan berorientasi pada keselamatan pasien.</li>
                                <li>Menyelenggarakan proses bisnis rumah sakit yang produktif dan akuntabel.</li>
                                <li>Meningkatkan sistem, proses dan manajemen operasional rumah sakit secara efektif dan efisien melalui digitalisasi pelayanan.</li>
                            </ol>
                        </p>
                    </div>
                </div>
                <div x-show="activeTab == 'tab_2'">
                    <div style="padding-top: 15px;">
                        <p class=" text-sm text-gray-600" >
                            <ol class="list-disc pl-5 text-gray-600" style="padding-left: 1rem;">
                                <li>Handal : Kemampuan untuk selalu memberikan hasil yang terbaik dalam setiap situasi.</li>
                                <li>Cepat : Kemampuan merespons dan bertindak secara efektif dan efisien tanpa mengurangi kualitas.</li>
                                <li>Tepat : Kemampuan melakukan pekerjaan dengan benar sesuai tujuan.</li>
                                <li>Ramah : Kemampuan untuk menunjukkan sikap hangat, sopan, dan menghormati.</li>
                                <li>Proaktif : Kemampuan untuk bertindak sebelum diminta dan mengantisipasi kebutuhan atau masalah.</li>
                                <li>Konsisten : Kemampuan untuk mempertahankan standar dan nilai-nilai inti secara terus-menerus.</li>
                            </ol>
                        </p>
                    </div>
                </div>
                <div x-show="activeTab == 'tab_3'">
                    <div style="padding-top: 15px;">
                    <p class="text-sm text-gray-600">
                        <ol class="list-decimal pl-5 text-gray-600" style="padding-left: 1rem;">
                            <li><b>Motto:</b> Kesehatan Anda, prioritas kami.</li>
                            <li><b>Tujuan:</b> Menjadi rumah sakit rujukan kesehatan dalam pelayanan kanker, jantung, stroke dan uronefrologi dengan pelayanan yang terbaik serta meningkatkan kualitas hidup masyarakat.</li>
                        </ol>
                    </p>
                    </div>
                </div>
            </div>
        </div>

    </x-filament::section>
    @endif
    
</x-filament-widgets::widget>

