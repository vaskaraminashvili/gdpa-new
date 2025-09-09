<?php

namespace App\Filament\Resources\TrainingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicantsRelationManager extends RelationManager
{
    protected static string $relationship = 'applicants';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                            ->unique('applicants', 'personal_id', ignoreRecord: true, modifyRuleUsing: function ($rule) {
                                return $rule->where('training_id', $this->getOwnerRecord()->id);
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
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

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Applied At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_certificate')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('certificate_number'))
                    ->label('Has Certificate'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Applicant')
                    ->modalHeading('Add New Applicant')
                    ->before(function ($action) {
                        $training = $this->getOwnerRecord();
                        if ($training->is_full) {
                            $action->halt();
                            \Filament\Notifications\Notification::make()
                                ->title('Training is Full')
                                ->body('This training has no available places.')
                                ->danger()
                                ->send();
                        }
                    }),
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
            ])
            ->defaultSort('created_at', 'desc');
    }
}
