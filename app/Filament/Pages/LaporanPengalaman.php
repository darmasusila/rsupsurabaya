<?php

namespace App\Filament\Pages;

use App\Models\Pegawai;
use App\Models\Biodata;
use App\Models\Pendidikan;
use Filament\Pages\Page;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Support\Collection;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Summarizers\Count;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LaporanPengalaman extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.laporan-pengalaman';

    protected static ?string $navigationGroup = 'Laporan';
    protected static ?string $navigationLabel = 'Laporan Pengalaman';

    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        $user = User::find(Auth::id());

        return $user->can('view_any_pegawai');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Pegawai::with('biodata', 'pendidikan')
                    ->join('biodata', 'biodata.id', '=', 'pegawai.biodata_id')
                    ->join('pendidikan', 'biodata.id', '=', 'pendidikan.biodata_id')
                    ->where('pegawai.is_active', true)
            )
            ->columns([
                Split::make([
                    TextColumn::make('nama')
                        ->label('Nama Lengkap')
                        ->description(fn(Pegawai $record): string => $record->biodata->gelar_depan . ' ' . $record->biodata->gelar_belakang)
                        ->wrap()
                        ->searchable()
                        ->sortable(),
                    Stack::make([
                        TextColumn::make('pendidikan.jenjang')
                            ->label('Jenjang Pendidikan')
                            ->summarize([
                                Count::make()
                            ])
                            ->icon('heroicon-m-academic-cap'),
                        TextColumn::make('pendidikan.program_studi'),
                        TextColumn::make('pendidikan.institusi'),
                        TextColumn::make('pendidikan.keterangan'),
                    ])->space(1),
                    Stack::make([
                        TextColumn::make('pendidikan.institusi_spesialis')
                            ->prefix('Spesialis: '),
                        TextColumn::make('pendidikan.institusi_subspesialis')
                            ->prefix('Sub Spesialis: ')
                    ]),
                    Stack::make([
                        TextColumn::make('pegawai.instansi_sebelumnya')
                            ->prefix('Instansi Sebelumnya: '),
                        TextColumn::make('pegawai.posisi_jabatan_sebelumnya')
                            ->prefix('Jabatan: '),
                        TextColumn::make('pegawai.lama_bekerja')
                            ->prefix('Lama : ')
                            ->suffix(' tahun'),
                        TextColumn::make('pegawai.status_keahlian')
                            ->prefix('Status Keahlian: '),
                    ]),
                ]),
            ])
            ->filters([
                SelectFilter::make('status_kepegawaian_id')
                    ->label('Status Kepegawaian')
                    ->options(function () {
                        return \App\Models\StatusKepegawaian::pluck('nama', 'id')->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->where('pegawai.status_kepegawaian_id', $data['value']);
                        }
                    }),
                SelectFilter::make('direktorat_id')
                    ->label('Direktorat')
                    ->options(function () {
                        return \App\Models\Direktorat::pluck('nama', 'id')->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->where('pegawai.direktorat_id', $data['value']);
                        }
                    }),
                SelectFilter::make('struktural_id')
                    ->label('Struktural')
                    ->options(function () {
                        return \App\Models\Struktural::pluck('nama', 'id')->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->where('pegawai.struktural_id', $data['value']);
                        }
                    }),
                SelectFilter::make('fungsional_id')
                    ->label('Fungsional')
                    ->options(function () {
                        return \App\Models\Fungsional::pluck('nama', 'id')->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->where('pegawai.fungsional_id', $data['value']);
                        }
                    }),
                SelectFilter::make('biodata.jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-Laki' => 'Laki-Laki',
                        'Perempuan' => 'Perempuan',
                    ]),
                SelectFilter::make('departemen_id')
                    ->label('Departemen')
                    ->options(function () {
                        return \App\Models\Departemen::pluck('nama', 'id')->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->where('pegawai.departemen_id', $data['value']);
                        }
                    }),
                SelectFilter::make('jenis_tenaga_id')
                    ->label('Jenis Tenaga')
                    ->options(function () {
                        return \App\Models\JenisTenaga::pluck('nama', 'id')->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->where('pegawai.jenis_tenaga_id', $data['value']);
                        }
                    }),
                SelectFilter::make('unit_id')
                    ->label('Unit')
                    ->options(function () {
                        return \App\Models\Unit::pluck('nama', 'id')->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->where('pegawai.unit_id', $data['value']);
                        }
                    }),
                SelectFilter::make('pendidikan.jenjang')
                    ->label('Jenjang')
                    ->options([
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMA' => 'SMA',
                        'SMK' => 'SMK',
                        'D-III' => 'D-III',
                        'D-IV' => 'D-IV',
                        'S1' => 'S1',
                        'S2' => 'S2',
                        'S3' => 'S3',
                        'Spesialis' => 'Spesialis',
                        'Profesi' => 'Profesi',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->where('pendidikan.jenjang', $data['value']);
                        }
                    })
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->defaultPaginationPageOption(25)
        ;
    }
}
