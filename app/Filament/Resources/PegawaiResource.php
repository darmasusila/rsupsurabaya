<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Biodata;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Filters\Filter;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Kepegawaian';
    protected static ?string $pluralModelLabel = 'Kepegawaian';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Kepegawaian')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('biodata_id')
                            ->label('Biodata Pegawai')
                            ->relationship('biodata', 'nama')
                            ->searchable()
                            ->required()
                            ->createOptionForm(
                                fn(Form $form) => $form
                                    ->schema([
                                        Forms\Components\TextInput::make('nama')
                                            ->label('Nama Pegawai')
                                            ->required(),
                                        Forms\Components\TextInput::make('gelar_depan')
                                            ->label('Gelar Depan')
                                            ->nullable()
                                            ->maxLength(50),
                                        Forms\Components\TextInput::make('gelar_belakang')
                                            ->label('Gelar Belakang')
                                            ->nullable()
                                            ->maxLength(50),
                                        Forms\Components\TextInput::make('nik')
                                            ->label('NIK')
                                            ->required()
                                            ->maxLength(18),
                                        Forms\Components\TextInput::make('tempat_lahir')
                                            ->label('Tempat Lahir')
                                            ->required(),
                                        Forms\Components\DatePicker::make('tanggal_lahir')
                                            ->label('Tanggal Lahir')
                                            ->required(),
                                        Forms\Components\Select::make('jenis_kelamin')
                                            ->label('Jenis Kelamin')
                                            ->options([
                                                'Laki - Laki' => 'Laki - Laki',
                                                'Perempuan' => 'Perempuan',
                                            ]),
                                    ])
                                    ->columns(2)
                            ),
                        Forms\Components\Select::make('fungsional_id')
                            ->label('Jabatan Fungsional')
                            ->relationship('fungsional', 'nama'),
                        Forms\Components\Select::make('struktural_id')
                            ->label('Jabatan Struktural')
                            ->relationship('struktural', 'nama'),
                        Forms\Components\Select::make('jenis_tenaga_id')
                            ->label('Jenis Tenaga')
                            ->relationship('jenisTenaga', 'nama')
                            ->required(),
                        Forms\Components\Select::make('status_kepegawaian_id')
                            ->label('Status Kepegawaian')
                            ->required()
                            ->relationship('statusKepegawaian', 'nama'),
                        Forms\Components\Select::make('direktorat_id')
                            ->label('Direktorat')
                            ->required()
                            ->relationship('direktorat', 'nama'),
                        Forms\Components\Select::make('departemen_id')
                            ->label('Departemen')
                            ->required()
                            ->relationship('departemen', 'nama'),
                        Forms\Components\Select::make('unit_id')
                            ->label('Unit Kerja')
                            ->relationship('unit', 'nama')
                            ->createOptionForm(
                                fn(Form $form) => $form
                                    ->schema([
                                        Forms\Components\TextInput::make('nama')
                                            ->label('Nama Unit')
                                            ->required(),
                                        Forms\Components\Select::make('direktorat_id')
                                            ->label('Direktorat')
                                            ->relationship('direktorat', 'nama')
                                            ->required(),
                                        Forms\Components\Select::make('struktural_id')
                                            ->label('Struktural')
                                            ->relationship('struktural', 'nama')
                                            ->required()
                                    ])
                            ),
                    ]),
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Kepegawaian')
                            ->schema([
                                Section::make('Informasi Nomor Kepegawaian')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('nip')
                                            ->label('NIP')
                                            ->maxLength(18),
                                        Forms\Components\TextInput::make('no_npwp')
                                            ->label('NPWP')
                                            ->maxLength(18),
                                        Forms\Components\TextInput::make('no_taspen')
                                            ->label('No Taspen')
                                            ->maxLength(50),
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Status KeAktifan')
                                            ->inline(false)
                                            ->required()
                                    ]),
                            ]),
                        Tabs\Tab::make('STR / SIP')
                            ->schema([
                                Section::make('Informasi STR / SIP')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('no_str')
                                            ->label('No STR'),
                                        Forms\Components\TextInput::make('no_sip')
                                            ->label('No SIP'),
                                        Forms\Components\DatePicker::make('tanggal_akhir_berlaku')
                                            ->label('Tanggal Akhir Berlaku'),
                                    ]),
                            ]),
                        Tabs\Tab::make('Tanggal Kepegawaian')
                            ->schema([
                                Section::make('Informasi Tanggal Kepegawaian')
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\DateTimePicker::make('created_at')
                                            ->disabled()
                                            ->label('Tanggal Masuk'),
                                        Forms\Components\DateTimePicker::make('tgl_promosi')
                                            ->label('Tanggal Promosi')
                                            ->timezone('Indonesia/Jakarta')
                                            ->native(false),
                                        Forms\Components\DateTimePicker::make('tgl_mutasi')
                                            ->label('Tanggal Mutasi')
                                            ->timezone('Indonesia/Jakarta')
                                            ->native(false),
                                        Forms\Components\DateTimePicker::make('tgl_pensiun')
                                            ->label('Tanggal Berhenti')
                                            ->timezone('Indonesia/Jakarta')
                                            ->native(false),
                                    ]),
                            ]),
                    ])
                    ->activeTab(1)
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('biodata.nama')
                    ->label('Nama Lengkap')
                    ->description(fn(Pegawai $record): string => $record->biodata->gelar_depan . ' ' . $record->biodata->gelar_belakang)
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fungsional.nama')
                    ->label('Jabatan Fungsional')
                    ->toggleable()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('direktorat.nama')
                    ->label('Direktorat')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenisTenaga.nama')
                    ->label('Jenis Tenaga')
                    ->searchable()
                    ->wrap()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('statusKepegawaian.nama')
                    ->label('Status Kepegawaian')
                    ->toggleable(),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Aktif')
                    ->disabled()

            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->label('Aktif')
                    ->query(
                        fn(Builder $query) =>
                        $query->where('is_active', 1)
                    )
                    ->default(true),
                Tables\Filters\Filter::make('tdk_aktif')
                    ->label('Tidak Aktif')
                    ->query(
                        fn(Builder $query) =>
                        $query->where('is_active', 0)
                    ),
                Tables\Filters\SelectFilter::make('status_kepegawaian_id')
                    ->label('Status Kepegawaian')
                    ->relationship('statusKepegawaian', 'nama'),
                Tables\Filters\SelectFilter::make('direktorat_id')
                    ->label('Direktorat')
                    ->relationship('direktorat', 'nama'),
                Tables\Filters\SelectFilter::make('struktural_id')
                    ->label('Struktural')
                    ->relationship('struktural', 'nama'),
                Tables\Filters\SelectFilter::make('fungsional_id')
                    ->label('Fungsional')
                    ->relationship('fungsional', 'nama'),
                Tables\Filters\SelectFilter::make('biodata.jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-Laki' => 'Laki-Laki',
                        'Perempuan' => 'Perempuan',
                    ]),
                Tables\Filters\SelectFilter::make('departemen_id')
                    ->label('Departemen')
                    ->relationship('departemen', 'nama'),
                Tables\Filters\SelectFilter::make('jenis_tenaga_id')
                    ->label('Jenis Tenaga')
                    ->relationship('jenisTenaga', 'nama'),
                Tables\Filters\SelectFilter::make('unit_id')
                    ->label('Unit')
                    ->relationship('unit', 'nama'),
                Tables\Filters\Filter::make('created_at')
                    ->label('Tanggal Masuk')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Tgl Masuk Awal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Tgl Masuk Akhir'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date)
                            );
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->defaultPaginationPageOption(25)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function (Tables\Actions\EditAction $action, $record) {
                        // cek apakah statusnya tidak aktif, bila tidak aktif disable user
                        if (!$record->is_active) {
                            $biodata = Biodata::find($record->biodata_id);
                            // Disable user
                            $user = \App\Models\User::where('email', $biodata->email)->first();
                            if ($user) {
                                $user->delete();
                            }
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePegawais::route('/'),
        ];
    }
}
