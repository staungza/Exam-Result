<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Region;
use App\Models\Result;
use App\Models\Student;
use Columns\TextFilter;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Township;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Component;
use Laravel\Nova\Fields\Text;
use Filament\Actions\ViewAction;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Livewire\Attributes\Computed;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Collection;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Select;
use Filament\Forms\ComponentContainer;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ResultResource\Pages;
use App\Filament\Permission\NavigationPermission;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ResultResource\Pages\EditResult;
use App\Filament\Resources\ResultResource\RelationManagers;
use App\Filament\Resources\ResultResource\Pages\ListResults;
use App\Filament\Resources\ResultResource\Pages\CreateResult;
use League\CommonMark\Extension\DefaultAttributes\ApplyDefaultAttributesProcessor;

class ResultResource extends Resource
{
    // use NavigationPermission;

    protected static ?string $permission = 'result-list';

    protected static ?string $model = Result::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Student Info';

    public static function getNavigationBadge(): ?string{
        return static::$model::count();
    }
    
    public function chart(): array
    {
        $regions = Region::all();
        $data = [];

        foreach ($regions as $region) {
            $passCount = Result::where('region_id', $region->id)
                ->where('myanmar', '>=', 40)
                ->where('english', '>=', 40)
                ->where('mathematics', '>=', 40)
                ->where('chemistry', '>=', 40)
                ->where('physics', '>=', 40)
                ->where('biological', '>=', 40)
                ->count();

            $totalCount = Result::where('region_id', $region->id)
                ->count();

            $passRate = $totalCount > 0 ? ($passCount / $totalCount) * 100 : 0;

            $data[] = [
                'label' => $region->name,
                'data' => round($passRate, 2), // Round to 2 decimal places
            ];
        }

        return [
            'datasets' => $data,
            'labels' => $regions->pluck('name')->toArray(),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('roll_no')
                    ->live()
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        // Fetch student_name and major based on roll_no
                        $student = Student::where('roll_no', $state)->first();
                        if ($student) {
                            // Set the fetched values into the form state
                            $set('major', $student->major);
                            $set('student_name', $student->student_name);
                        } else {
                            // Clear fields if student not found
                            $set('major', '');
                            $set('student_name', '');
                        }
                    }),

                TextInput::make('student_name'),
                //TextInput::make('major'),

                Select::make('region_id')
                    ->label('Region Name')
                    ->searchable()
                    ->options(function (Get $get) {
                        // Fetch regions associated with the entered roll_no
                        $rollNo = $get('roll_no');
                        if ($rollNo) {
                            return Region::whereHas('students', function ($query) use ($rollNo) {
                                $query->where('roll_no', $rollNo);
                            })->pluck('name', 'id');
                        } else {
                            return [];
                        }
                    })
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),

                Select::make('township_id')
                    ->label('TownShip Name')
                    ->options(function (Get $get) {
                        // Fetch regions associated with the entered roll_no
                        $rollNo = $get('roll_no');
                        if ($rollNo) {
                            return Township::whereHas('students', function ($query) use ($rollNo) {
                                $query->where('roll_no', $rollNo);
                            })->pluck('name', 'id');
                        } else {
                            return [];
                        }
                    })
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required(),

                Forms\Components\TextInput::make('myanmar')
                    ->integer()
                    ->placeholder('Myanmar')
                    ->required()
                    ->rules('max:100')
                    ->maxLength(3),

                Forms\Components\TextInput::make('english')
                    ->required()
                    ->integer()
                    ->rules('max:100')
                    ->maxLength(3),

                Forms\Components\TextInput::make('mathematics')
                    ->required()
                    ->integer()
                    ->rules('max:100')
                    ->maxLength(3),

                Forms\Components\TextInput::make('chemistry')
                    ->required()
                    ->integer()
                    ->rules('max:100')
                    ->maxLength(3),

                Forms\Components\TextInput::make('physics')
                    ->required()
                    ->integer()
                    ->rules('max:100')
                    ->maxLength(3),

                Forms\Components\TextInput::make('biological')
                ->label('Biological Or Economical')
                    ->required()
                    ->integer()
                    ->rules('max:100')
                    ->maxLength(3),
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

                Tables\Columns\TextColumn::make('myanmar')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('english')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('mathematics')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('chemistry')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('physics')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('biological')

                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('Pass or Fail')
                    ->searchable()
                    ->state(function ($record) {
                        // Determine pass or fail status
                        $passOrFail = ($record->myanmar >= 40 &&
                                       $record->english >= 40 &&
                                       $record->mathematics >= 40 &&
                                       $record->chemistry >= 40 &&
                                       $record->physics >= 40 &&
                                       $record->biological >= 40) ? 'Pass' : 'Fail';

                        // Apply CSS classes based on status
                        $class = $passOrFail === 'Pass' ? 'pass' : 'fail';

                        return "<span class='$class'>$passOrFail</span>";
                    })
                    ->html() // Enable HTML rendering
                    ->sortable(),

                Tables\Columns\TextColumn::make('Total Score')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->state(function ($record) {
                        // Calculate total score
                        $totalScore = $record->myanmar +
                                      $record->english +
                                      $record->mathematics +
                                      $record->chemistry +
                                      $record->physics +
                                      $record->biological;

                        return $totalScore;
                    }),

                Tables\Columns\TextColumn::make('Credit Subjects')
                    ->searchable()
                    ->state(function (Model $record) {
                        // Initialize an array to hold subjects that meet the credit requirement
                        $subjectsPassed = [];

                        // Check each subject's score against its respective credit requirement
                        if ($record->myanmar >= 75) {
                            $subjectsPassed[] = 'Myanmar';
                        }
                        if ($record->english >= 75) {
                            $subjectsPassed[] = 'English';
                        }
                        if ($record->mathematics >= 80) {
                            $subjectsPassed[] = 'Mathematics';
                        }
                        if ($record->chemistry >= 80) {
                            $subjectsPassed[] = 'Chemistry';
                        }
                        if ($record->physics >= 80) {
                            $subjectsPassed[] = 'Physics';
                        }

                        // Access the related student model to check the major
                        $student = Student::where('roll_no', $record->roll_no)->first();
                        // Check the biological score and the major
                        if ($record->biological >= 75) {
                            if ($student && $student->major === 'bio') {
                                $subjectsPassed[] = 'Biological';
                            } elseif ($student && $student->major === 'eco') {
                                $subjectsPassed[] = 'Economical';
                            }
                        }

                        // Return the subjects as a comma-separated string
                        return !empty($subjectsPassed) ? implode(', ', $subjectsPassed) : 'None';
                    }),

                Tables\Columns\TextColumn::make('Credits Count')
                    ->searchable()
                    ->state(function ($record) {
                        // Initialize a counter for subjects with scores greater than 75
                        $subjectsGreaterThan75Count = 0;

                        // Check each subject's score against its respective credit requirement
                        if ($record->myanmar >= 75) {
                            $subjectsGreaterThan75Count++;
                        }
                        if ($record->english >= 75) {
                            $subjectsGreaterThan75Count++;
                        }
                        if ($record->mathematics >= 80) {
                            $subjectsGreaterThan75Count++;
                        }
                        if ($record->chemistry >= 80) {
                            $subjectsGreaterThan75Count++;
                        }
                        if ($record->physics >= 80) {
                            $subjectsGreaterThan75Count++;
                        }
                        if ($record->biological >= 75) {
                            $subjectsGreaterThan75Count++;
                        }

                        // Return the count of subjects with scores greater than 75
                        return $subjectsGreaterThan75Count;
                    }),

                Tables\Columns\TextColumn::make('region_id')
                    ->label('Region Name')
                    ->state(function ($record) {
                        $data = Student::where('roll_no', $record->roll_no)->first();
                        return $data ? $data->region->name : null;
                    })
                    ->searchable('region_id')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('township_id')
                    ->label('TownShip Name')
                    ->state(function ($record) {
                        $data = Student::where('roll_no', $record->roll_no)->first();
                        return $data ? $data->township->name : null;
                    })
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('roll_no')
                    ->label('Select Student Rollno')
                    ->placeholder('Select Student Rollno')
                    ->options(Result::all()->pluck('roll_no', 'id'))
                    ->multiple(),

                SelectFilter::make('roll_no')
                    ->label('Select Student Name')
                    ->placeholder('Select Student Name')
                    ->options(Result::all()->pluck('student_name', 'id'))
                    ->multiple(),

                SelectFilter::make('region_id')
                    ->label('Select Region')
                    ->placeholder('Select Region')
                    ->options(Region::all()->pluck('name', 'id'))
                    ->multiple(),

                SelectFilter::make('township_id')
                    ->label('Select TownShip')
                    ->placeholder('Select TownShip')
                    ->options(Township::all()->pluck('name', 'id'))
                    ->multiple(),
            ])
            ->filtersFormColumns(2)
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
            'index' => Pages\ListResults::route('/'),
            'create' => Pages\CreateResult::route('/create'),
            'edit' => Pages\EditResult::route('/{record}/edit'),
        ];
    }

    public function maxDigits($maxDigits)
    {
        $this->maxDigits = $maxDigits;
        return $this;
    }
}
