<?php

namespace App\Filament\Resources;


use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\State;
use App\Models\Region;
use App\Models\Quarter;
use App\Models\Student;

use Filament\Forms\Get;
use App\Models\Township;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Traits\CheckPermission;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Collection;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Filament\Resources\StudentResource\Pages\EditStudent;
use App\Filament\Resources\StudentResource\Pages\ListStudents;
use App\Filament\Resources\StudentResource\Pages\CreateStudent;

class StudentResource extends Resource
{
    use CheckPermission;
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Student Info';

    protected static array $permissions = [
        'student-view',
        'student-edit',
        'student-create'
    ];
    public static function getNavigationBadge(): ?string{
        return static::$model::count();
    }
    
    public static function form(Form $form): Form
    {
        return $form
       
            ->schema([
            Section::make('Student Info')
                ->schema([
            TextInput::make('roll_no')
                    ->required()
                    ->maxLength(255),
            TextInput::make('student_name')
                    ->required()
                    ->maxLength(255),
            Select::make('major')
                    ->options([
                        'bio'=>'Biological',
                        'eco'=>'Ecomonics',

                    ]),
                    
            TextInput::make('father_name')
                    ->required()
                    ->maxLength(255),
                   
                ])->columns(2),

            Section::make('Address')

                ->schema([
            Select::make('region_id')
                ->relationship(name:'region',titleAttribute:'name')
                ->searchable()
                ->preload()
                ->live()
                ->required(),

            Select::make('township_id')
                    ->label('Township')
                    ->options(fn (Get $get): Collection => Township::query()
                       ->where('region_id', $get('region_id'))
                        ->pluck('name','id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),

                   
                ])->columns(2),
            Section::make('Dates')
                ->schema([
                    Forms\Components\DatePicker::make('date_of_birth')
                    ->required(),
              
                ]),


                    
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('roll_no')
                    ->searchable()
                    ->sortable(),
               
                Tables\Columns\TextColumn::make('student_name')
                    ->searchable(),
                 Tables\Columns\TextColumn::make('region.name')
                 ->searchable(),
                Tables\Columns\TextColumn::make('township.name')
                    ->searchable(),
                
               
            ])
            ->filters([
                //     Filter::make('region-section-filter')
                //    ->form([
                //     select::make('region_id')
                //     ->label('Filter By Region')
                //     ->placeholder(('Select a region'))
                //     ->options(
                //         Region::pluck('name','id')->toArray(),

                //     )
                //    ])
                //    ->query(function (Builder $query, array $data ): Builder{
                         
                //         return $query->when($data['region_id'],function($query) use ($data)
                //         {
                //         $query->where('region_id');
                //         });
                //    }),
                SelectFilter::make('region_id')
                ->options(Region::all()->pluck('name','id'))
                ->multiple(),

                SelectFilter::make('township_id')
                ->options(Township::all()->pluck('name','id'))
                ->multiple(),
            ])
            ->actions([

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    
}
