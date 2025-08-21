<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostingLikedResource\Pages;
use App\Filament\Resources\PostingLikedResource\RelationManagers;
use App\Models\PostingLiked;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Biodata;
use App\Models\Pegawai;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;


class PostingLikedResource extends Resource
{
    protected static ?string $model = PostingLiked::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationLabel = 'Posting Likes';
    protected static ?string $pluralModelLabel = 'Posting Likes';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                function (Builder $query) {
                    // Get the current user's biodata ID
                    $biodataId = Biodata::where('email', Auth::user()->email)->value('id');
                    $pegawaiId = Pegawai::where('biodata_id', $biodataId)->value('id');
                    $query->where('pegawai_id', $pegawaiId)
                        ->where('is_open_link', false);
                }
            )
            ->columns([
                Tables\Columns\TextColumn::make('posting.judul')
                    ->label('Judul Posting')
                    ->description(fn(PostingLiked $record): string => $record->posting->jenis)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('posting.url')
                    ->label('URL Posting')
                    ->url(fn(PostingLiked $record): string => route('post.goTo', encrypt($record->id)))
                    ->description('Mohon klik untuk membuka postingan dan klik tombol suka')
                    ->openUrlInNewTab(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->emptyStateHeading('No Posting Likes Found')
            ->emptyStateDescription('You have not liked any postings yet.')
            ->emptyStateIcon('heroicon-o-heart');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePostingLikeds::route('/'),
        ];
    }
}
