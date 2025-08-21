<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostingResource\Pages;
use App\Filament\Resources\PostingResource\RelationManagers;
use App\Models\Posting;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\PostingResource\RelationManagers\LikesRelationManager;

class PostingResource extends Resource
{
    protected static ?string $model = Posting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Posting';
    protected static ?string $pluralModelLabel = 'Posting';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Posting')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul')
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\TextInput::make('url')
                            ->label('URL')
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\TextInput::make('jenis')
                            ->label('Jenis')
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->description(fn(Posting $record): string => $record->url)
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('generate_like')
                    ->label('Generate Liked Postings')
                    ->icon('heroicon-o-hand-thumb-up')
                    ->requiresConfirmation()
                    ->action(
                        function (Posting $record): void {
                            // Logic to generate liked postings for the posting
                            $pegawais = \App\Models\Pegawai::where('is_active', true)->get();

                            foreach ($pegawais as $pegawai) {
                                $record->likes()->create([
                                    'posting_id' => $record->id,
                                    'pegawai_id' => $pegawai->id,
                                    'created_at' => now(),
                                    'is_open_link' => false,
                                ]);
                            }
                        }
                    )
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
            'index' => Pages\ManagePostings::route('/'),
            'view' => Pages\ViewPosting::route('/{record}'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\LikesRelationManager::class,
        ];
    }
}
