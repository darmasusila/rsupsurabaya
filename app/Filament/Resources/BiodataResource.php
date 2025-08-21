<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BiodataResource\Pages;
use App\Filament\Resources\BiodataResource\RelationManagers;
use App\Models\Biodata;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\IconColumn;


class BiodataResource extends Resource
{
    protected static ?string $model = Biodata::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Biodata';
    protected static ?string $pluralModelLabel = 'Biodata';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Information Biodata')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(255),
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
                            ->numeric()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->required()
                            ->options([
                                'Laki-Laki' => 'Laki-Laki',
                                'Perempuan' => 'Perempuan',
                            ]),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->required()
                            ->maxDate(now()),
                    ])
                    ->columns(2),
                Section::make('Alamat dan Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('alamat')
                            ->label('Alamat')
                            ->nullable()
                            ->columnSpanFull()
                            ->maxLength(500),
                        Forms\Components\TextInput::make('telepon')
                            ->label('Telepon')
                            ->nullable()
                            ->numeric()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->nullable()
                            ->maxLength(255),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->description(fn(Biodata $record): string => $record->gelar_depan . ' ' . $record->gelar_belakang)
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->description(fn($record) => $record->jenis_kelamin)
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date()
                    ->description(fn($record) => $record->tempat_lahir)
                    ->searchable(),

                Tables\Columns\IconColumn::make('UserCreated')
                    ->label('Account Created')
                    ->icon(fn(Biodata $record): string => $record->GetUserCreatedAttribute() ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn(Biodata $record): string => $record->GetUserCreatedAttribute() ? 'success' : 'danger'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PendidikanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBiodatas::route('/'),
            'create' => Pages\CreateBiodata::route('/create'),
            'edit' => Pages\EditBiodata::route('/{record}/edit'),
        ];
    }
}
