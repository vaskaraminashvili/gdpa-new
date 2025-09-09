<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingResource\Pages;
use App\Filament\Resources\TrainingResource\RelationManagers;
use App\Models\Training;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainingResource extends Resource
{
    protected static ?string $model = Training::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Trainings';

    protected static ?string $modelLabel = 'Training';

    protected static ?string $pluralModelLabel = 'Trainings';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Training Title')
                    ->schema([
                        Forms\Components\TextInput::make('title.en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title.ka')
                            ->label('Title (Georgian)')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Training Description')
                    ->schema([
                        Forms\Components\RichEditor::make('description.en')
                            ->label('Description (English)')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description.ka')
                            ->label('Description (Georgian)')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Training Details')
                    ->schema([
                        Forms\Components\DateTimePicker::make('date_from')
                            ->label('Start Date & Time')
                            ->required()
                            ->seconds(false),

                        Forms\Components\DateTimePicker::make('date_to')
                            ->label('End Date & Time')
                            ->required()
                            ->seconds(false)
                            ->after('date_from'),

                        Forms\Components\TextInput::make('number_of_places')
                            ->label('Number of Places')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(1000),

                        Forms\Components\Toggle::make('status')
                            ->label('Active')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->getStateUsing(
                        fn(Training $record): string =>
                        $record->getTranslation('title', app()->getLocale()) ??
                            $record->getTranslation('title', 'en') ??
                            'No title'
                    )
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('date_from')
                    ->label('Start Date')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date_to')
                    ->label('End Date')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('number_of_places')
                    ->label('Total Places')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('applicants_count')
                    ->label('Applicants')
                    ->getStateUsing(fn(Training $record): string => $record->applicants()->count())
                    ->alignCenter()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('available_places')
                    ->label('Available')
                    ->getStateUsing(fn(Training $record): string => $record->available_places)
                    ->alignCenter()
                    ->badge()
                    ->color(fn(Training $record): string => $record->available_places > 0 ? 'warning' : 'danger'),

                Tables\Columns\ToggleColumn::make('status')
                    ->label('Status')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Status')
                    ->boolean()
                    ->trueLabel('Active')
                    ->falseLabel('Inactive')
                    ->native(false),

                Tables\Filters\Filter::make('upcoming')
                    ->query(fn(Builder $query): Builder => $query->upcoming())
                    ->label('Upcoming Only'),

                Tables\Filters\Filter::make('ongoing')
                    ->query(fn(Builder $query): Builder => $query->ongoing())
                    ->label('Ongoing Only'),

                Tables\Filters\Filter::make('past')
                    ->query(fn(Builder $query): Builder => $query->past())
                    ->label('Past Only'),

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
                    ->label('New Training')
                    ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('date_from', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ApplicantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainings::route('/'),
            'create' => Pages\CreateTraining::route('/create'),
            'view' => Pages\ViewTraining::route('/{record}'),
            'edit' => Pages\EditTraining::route('/{record}/edit'),
        ];
    }
}
