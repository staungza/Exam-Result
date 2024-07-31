<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Region;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\RegionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegionResource\Pages\EditRegion;
use App\Filament\Resources\RegionResource\RelationManagers;
use App\Filament\Resources\RegionResource\Pages\ListRegions;
use App\Filament\Resources\RegionResource\Pages\CreateRegion;

class RegionResource extends Resource
{
    protected static ?string $model = Region::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Location Management';

    protected static ?int $navigationSort = 1;

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
             ->columns([
               
            Tables\Columns\TextColumn::make('name')
                ->label('Region Name')
                ->searchable(),
        
            Tables\Columns\TextColumn::make('students_count')
            ->label('Number of Students')
            ->counts('students')->badge()
            ->toggleable(isToggledHiddenByDefault: true),
            
            Tables\Columns\ToggleColumn::make('is_active')
            ->label('Active Status')
            ->toggleable(),
          
            

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
                
                TextEntry::make('name')->label('Region Name'),
          ])->columns(2)
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
            'index' => Pages\ListRegions::route('/'),
            //'create' => Pages\CreateRegion::route('/create'),
            //'edit' => Pages\EditRegion::route('/{record}/edit'),
        ];
    }
}
