<x-filament-panels::page>
@if ($data)
    <x-filament::section>
        <x-slot name="heading">
            Daftar Posting RS Kemenkes Surabaya
        </x-slot>

        <div class="space-y-4">
            @if ($data->isEmpty())
                <p>Tidak ada data yang perlu di like.</p>
            @else
                <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Url</th>
                        </tr>
                    </thead>
                    
                    <tbody class="text-sm divide-y divide-gray-200 dark:divide-white/5">
                        @foreach ($data as $index => $result)
                            
                            <tr>
                                <td class="py-2 px-2 border-spacing-1">{{ $index + 1 }}</td>
                                <td class="py-2 px-2 border-spacing-1">{{ $result->judul }}</td>
                                <td class="py-2 px-2 border-spacing-1">
                                    <a href="{{ route('post.goTo', $result->id) }}" target="_blank" class="text-blue-500 hover:underline">{{ $result->url }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            @endif
        </div>
    </x-filament::section>
                        
@endif
</x-filament-panels::page>
