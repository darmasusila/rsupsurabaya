
<x-filament-widgets::widget>
    @if ($visible)
    <x-filament::section>
        <x-slot name="heading">
            Motto dan Tujuan
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
                Content here
                </div>
                <div x-show="activeTab == 'tab_2'">
                    More content
                </div>
                <div x-show="activeTab == 'tab_3'">
                    <p class="text-sm text-gray-600">
                        <ol class="list-decimal pl-5 text-gray-600" style="padding-left: 1rem;">
                            <li><b>Motto:</b> Kesehatan Anda, prioritas kami.</li>
                            <li><b>Tujuan:</b> Menjadi rumah sakit rujukan kesehatan dalam pelayanan kanker, jantung, stroke dan uronefrologi dengan pelayanan yang terbaik serta meningkatkan kualitas hidup masyarakat.</li>
                        </ol>
                    </p>
                </div>
            </div>
        </div>

    </x-filament::section>
    @endif
</x-filament-widgets::widget>
