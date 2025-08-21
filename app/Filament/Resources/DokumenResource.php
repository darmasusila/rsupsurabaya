<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DokumenResource\Pages;
use App\Filament\Resources\DokumenResource\RelationManagers;
use App\Models\Dokumen;
use Filament\Tables\Filters\Filter;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Enums\FiltersLayout;

class DokumenResource extends Resource
{
    protected static ?string $model = Dokumen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Dokumen';

    protected static ?string $pluralLabel = 'Daftar Dokumen';

    protected static ?int $navigationSort = 99;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Dokumen')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('kategori')
                            ->label('Kategori')
                            ->options([
                                'Artikel' => 'Artikel',
                                'Kebijakan' => 'Kebijakan',
                                'Panduan/Pedoman' => 'Panduan/Pedoman',
                                'Struktur Organisasi' => 'Struktur Organisasi',
                                'Uraian Tugas' => 'Uraian Tugas',
                                'SPO' => 'SPO',
                                'Formulir' => 'Formulir',
                                'Lainnya' => 'Lainnya'
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('nama_dokumen')
                            ->label('Nama Dokumen')
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Is Active')
                            ->required(),
                    ]),
                Section::make('Url atau Upload Berkas')
                    ->schema([
                        Forms\Components\TextInput::make('url')
                            ->label('URL')
                            ->helperText('Masukkan URL Bila Dokemen ini diambil dari link URL')
                            ->url()
                            ->suffixIcon('heroicon-m-globe-alt'),

                        Forms\Components\FileUpload::make('file_name')
                            ->label('Upload File')
                            ->helperText('Upload file dokumen jika tidak menggunakan URL')
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->storeFileNamesIn('original_file_name')
                            ->disk('public'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                function (Builder $query) {
                    if (Auth::user()->name != 'admin') {
                        $query->where('is_active', true);
                    }
                }
            )
            ->columns([
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori'),
                Tables\Columns\TextColumn::make('nama_dokumen')
                    ->label('Nama Dokumen')
                    ->description(fn(Dokumen $record) => $record->deskripsi)
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('counter')
                    ->label('Hit Counter')
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->options([
                        'Artikel' => 'Artikel',
                        'Kebijakan' => 'Kebijakan',
                        'Panduan/Pedoman' => 'Panduan/Pedoman',
                        'Struktur Organisasi' => 'Struktur Organisasi',
                        'Uraian Tugas' => 'Uraian Tugas',
                        'SPO' => 'SPO',
                        'Formulir' => 'Formulir',
                        'Lainnya' => 'Lainnya'
                    ]),
                Filter::make('active')
                    ->label('Dokumen Aktif')
                    ->default()
                    ->query(fn(Builder $query) => $query->where('is_active', true)),
                Filter::make('no_active')
                    ->label('Dokumen Tidak Aktif')
                    ->visible(
                        function () {
                            return (Auth::user()->name == 'admin') ? true : false;
                        }
                    )
                    ->query(fn(Builder $query) => $query->where('is_active', false))

            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(
                        function () {
                            return (Auth::user()->name == 'admin') ? true : false;
                        }
                    ),
                Tables\Actions\DeleteAction::make()
                    ->visible(
                        function () {
                            return (Auth::user()->name == 'admin') ? true : false;
                        }
                    ),
                Tables\Actions\Action::make('open_file')
                    ->label('Show')
                    ->url(
                        fn(Dokumen $record) => $record->file_name ? route('file.open', ['fileName' => $record->file_name]) : $record->url
                    )
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document-text')
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDokumens::route('/'),
        ];
    }
}
