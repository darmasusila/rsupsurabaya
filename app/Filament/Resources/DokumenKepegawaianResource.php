<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DokumenKepegawaianResource\Pages;
use App\Filament\Resources\DokumenKepegawaianResource\RelationManagers;
use App\Models\DokumenKepegawaian;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Enums\FiltersLayout;
use Carbon\Carbon;

class DokumenKepegawaianResource extends Resource
{
    protected static ?string $model = DokumenKepegawaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Dokumen Kepegawaian';
    protected static ?string $pluralModelLabel = 'Dokumen Kepegawaian';
    protected static ?int $navigationSort = 5;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pegawai_id')
                    ->label('Pegawai')
                    ->options(\App\Models\Pegawai::with('biodata')->get()->pluck('biodata.nama', 'id'))
                    ->searchable()
                    ->columnSpanFull()
                    ->required(),
                Select::make('jenis_dokumen_id')
                    ->label('Jenis Dokumen')
                    ->options(\App\Models\JenisDokumen::pluck('nama_jenis_dokumen', 'id'))
                    ->required(),
                TextInput::make('nomor_dokumen')
                    ->label('Nomor Dokumen')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('tanggal_terbit')
                    ->label('Tanggal Terbit')
                    ->required(),
                DatePicker::make('tanggal_berakhir')
                    ->label('Tanggal Berakhir')
                    ->required(),
                TextInput::make('file_path')
                    ->label('URL File Dokumen')
                    ->columnSpanFull()
                    ->url()
                    ->suffixIcon('heroicon-m-globe-alt')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Tidak Aktif' => 'Tidak Aktif',
                    ])
                    ->required(),
                Textarea::make('catatan')
                    ->label('Keterangan')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.biodata.nama')
                    ->label('Nama Pegawai')->sortable()->searchable()
                    ->description(fn(DokumenKepegawaian $record): string => $record->jenisDokumen->nama_jenis_dokumen),
                Tables\Columns\TextColumn::make('nomor_dokumen')->label('Nomor Dokumen')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('tanggal_terbit')
                    ->label('Tanggal Terbit')
                    ->date('d M Y')
                    ->sortable()
                    ->description(
                        fn(DokumenKepegawaian $record): string => 'Berakhir pada: ' . Carbon::parse($record->tanggal_berakhir)->format('d M Y')
                    ),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')->sortable()->searchable()
                    ->badge()
                    ->colors([
                        'success' => 'Aktif',
                        'danger' => 'Tidak Aktif',
                    ])
                    ->description(fn(DokumenKepegawaian $record): string => $record->sisa_waktu ?? ''),
            ])
            ->filters([
                SelectFilter::make('jenis_dokumen_id')
                    ->label('Jenis Dokumen')
                    ->options(\App\Models\JenisDokumen::pluck('nama_jenis_dokumen', 'id')),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Tidak Aktif' => 'Tidak Aktif',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tanggal_berakhir', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDokumenKepegawaians::route('/'),
            'create' => Pages\CreateDokumenKepegawaian::route('/create'),
            'edit' => Pages\EditDokumenKepegawaian::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            \App\Filament\Resources\DokumenKepegawaianResource\Widgets\DokumenReminder::class,
        ];
    }
}
