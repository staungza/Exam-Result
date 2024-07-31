<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Region;
use App\Models\Township;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\TownshipResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TownshipResource\RelationManagers;
use App\Filament\Resources\TownshipResource\Pages\EditTownship;
use App\Filament\Resources\TownshipResource\Pages\ListTownships;
use App\Filament\Resources\TownshipResource\Pages\CreateTownship;

class TownshipResource extends Resource
{
    protected static ?string $model = Township::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Location Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                  
                    ->maxLength(255),
                    Forms\Components\Select::make('region_id')
                    ->label('Region')
                    ->options(Region::all()->pluck('name', 'id'))
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              
                Tables\Columns\TextColumn::make('name')
                ->label('TownShip Name')
                    ->searchable(),

               

               
                Tables\Columns\TextColumn::make('region_id')
                ->label('Region Name')
                ->state(function ($record) {  
                     $data = Township::where('region_id', $record->region_id)->first();
                     return $data ? $data->region->name : null;
                  })
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('students_count')->counts('students')->badge(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
          Section::make('TownShip Info')
          ->schema([
                TextEntry::make('region.name')->label('Region Name'),
                TextEntry::make('name')->label('TownShip Name'),
          ])->columns(2)
        ]);
    }

    public static function getRelations(): array
    {
        return [
         
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTownships::route('/'),
            //'create' => Pages\CreateTownship::route('/create'),
            //'edit' => Pages\EditTownship::route('/{record}/edit'),
        ];
    }
}
