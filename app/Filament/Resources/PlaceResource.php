<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceResource\Pages;
use App\Filament\Resources\PlaceResource\RelationManagers;
use App\Models\Place;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire;
use App\Filament\Resources\PlaceResource\Pages\Log;
use Filament\Forms\Components\RichEditor;


class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('File')
                    ->relationship('file')
                    ->saveRelationshipsWhenHidden()
                    ->schema([
                        Forms\Components\FileUpload::make('filepath')
                        ->required()
                        ->image()
                        ->maxSize(2048)
                        ->directory('uploads')
                        ->getUploadedFileNameForStorageUsing(function (Livewire\TemporaryUploadedFile $file): string {
                            return time() . '_' . $file->getClientOriginalName();
                        }),
                    ]),
                Forms\Components\Select::make('author_id')
                    ->required()
                    ->relationship('author', 'name')
                    ->default(auth()->user()->id)
                    ->disablePlaceholderSelection(),
                    
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->maxLength(255)
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),
                Forms\Components\TextInput::make('latitude')
                    ->required(),
                Forms\Components\TextInput::make('longitude')
                    ->required(),
            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('file_id')->translateLabel(),
                Tables\Columns\TextColumn::make('author_id')->translateLabel(),
                Tables\Columns\TextColumn::make('name')->translateLabel(),
                Tables\Columns\TextColumn::make('description')->translateLabel(),
                Tables\Columns\TextColumn::make('latitude')->translateLabel(),
                Tables\Columns\TextColumn::make('longitude')->translateLabel(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->translateLabel(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()->translateLabel(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListPlaces::route('/'),
            'create' => Pages\CreatePlace::route('/create'),
            'view' => Pages\ViewPlace::route('/{record}'),
            'edit' => Pages\EditPlace::route('/{record}/edit'),
        ];
    }    
}
