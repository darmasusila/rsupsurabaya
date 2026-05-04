<?php

namespace App\Filament\Clusters\Referensi\Resources;

use App\Filament\Clusters\Referensi;
use App\Filament\Clusters\Referensi\Resources\JenisDokumenResource\Pages;
use App\Filament\Clusters\Referensi\Resources\JenisDokumenResource\RelationManagers;
use App\Models\JenisDokumen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JenisDokumenResource extends Resource
{
    protected static ?string $model = JenisDokumen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Referensi::class;

    protected static ?string $navigationLabel = 'Jenis Dokumen';
    protected static ?string $pluralModelLabel = 'Jenis Dokumen';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_jenis_dokumen')
                    ->label('Kode Jenis Dokumen')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('nama_jenis_dokumen')
                    ->label('Nama Jenis Dokumen')
                    ->required(),
                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi'),
                Forms\Components\TextInput::make('durasi_reminder')
                    ->label('Durasi Reminder (hari)')
                    ->numeric()
                    ->default(30)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_jenis_dokumen')->label('Kode Jenis Dokumen')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nama_jenis_dokumen')->label('Nama Jenis Dokumen')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')->label('Deskripsi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('durasi_reminder')->label('Durasi Reminder (hari)')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\DeleteAction::make(),

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
            'index' => Pages\ManageJenisDokumens::route('/'),
        ];
    }
}
