<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Forms\Components\Checkboxes;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use Filament\Forms\Components\CheckboxList;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Settings';

    // Define the form used to create or edit users
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->maxLength(255),
                
                // Permissions field with CheckboxList
                CheckboxList::make('permissions')
                    ->label('Permissions')
                    ->options(Permission::all()->pluck('name', 'id')->toArray())  // Get all permissions from DB
                    ->columnSpan(2)
                    ->columns(4)  // Show permissions in 4 columns
                    ->required()
                    ->reactive(),  // Make the field reactive
            ]);
    }

    // Define the table to show a list of users
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->searchable(),
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

    // Handle syncing permissions after form is submitted
    public static function afterFormSubmit($form, $record): void
    {
        // $form contains the form data
        $permissions = $form->getState()['permissions'] ?? [];
        
        // Sync permissions after the form is submitted
        if ($record instanceof User) {
            $record->permissions()->sync($permissions);  // Sync the selected permissions
        }
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
