<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicantResource\Pages;
use App\Filament\Resources\ApplicantResource\RelationManagers;
use App\Models\Applicant;
use App\Models\Training;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicantResource extends Resource
{
    protected static ?string $model = Applicant::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Applicants';

    protected static ?string $modelLabel = 'Applicant';

    protected static ?string $pluralModelLabel = 'Applicants';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Training Selection')
                    ->schema([
                        Forms\Components\Select::make('training_id')
                            ->label('Training')
                            ->relationship('training', 'id')
                            ->getOptionLabelFromRecordUsing(fn (Training $record): string => 
                                ($record->getTranslation('title', app()->getLocale()) ?? 
                                 $record->getTranslation('title', 'en') ?? 
                                 'No title') . 
                                ' (' . $record->date_from->format('M d, Y') . ')'
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                if ($state) {
                                    $training = Training::find($state);
                                    if ($training && $training->is_full) {
                                        $set('training_id', null);
                                        // You could add a notification here
                                    }
                                }
                            })
                            ->helperText(function (Forms\Get $get): ?string {
                                $trainingId = $get('training_id');
                                if ($trainingId) {
                                    $training = Training::find($trainingId);
                                    if ($training) {
                                        return "Available places: {$training->available_places} / {$training->number_of_places}";
                                    }
                                }
                                return null;
                            }),
                    ]),

                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('personal_id')
                            ->label('Personal ID')
                            ->required()
                            ->maxLength(255)
                            ->unique(Applicant::class, 'personal_id', ignoreRecord: true, modifyRuleUsing: function ($rule, $get) {
                                return $rule->where('training_id', $get('training_id'));
                            }),

                        Forms\Components\TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Professional Information')
                    ->schema([
                        Forms\Components\TextInput::make('certificate_number')
                            ->label('Certificate Number')
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('certificate_date')
                            ->label('Certificate Date'),

                        Forms\Components\TextInput::make('specialty')
                            ->label('Specialty')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('work_place')
                            ->label('Work Place')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('work_place_address')
                            ->label('Work Place Address')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('training.title')
                    ->label('Training')
                    ->getStateUsing(
                        fn(Applicant $record): string =>
                        $record->training->getTranslation('title', app()->getLocale()) ??
                            $record->training->getTranslation('title', 'en') ??
                            'No title'
                    )
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('personal_id')
                    ->label('Personal ID')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('specialty')
                    ->label('Specialty')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('work_place')
                    ->label('Work Place')
                    ->searchable()
                    ->toggleable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('training.date_from')
                    ->label('Training Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Applied At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('training_id')
                    ->label('Training')
                    ->relationship('training', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Training $record): string => 
                        ($record->getTranslation('title', app()->getLocale()) ?? 
                         $record->getTranslation('title', 'en') ?? 
                         'No title') . 
                        ' (' . $record->date_from->format('M d, Y') . ')'
                    )
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('has_certificate')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('certificate_number'))
                    ->label('Has Certificate'),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Applicant')
                    ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListApplicants::route('/'),
            'create' => Pages\CreateApplicant::route('/create'),
            'view' => Pages\ViewApplicant::route('/{record}'),
            'edit' => Pages\EditApplicant::route('/{record}/edit'),
        ];
    }
}
