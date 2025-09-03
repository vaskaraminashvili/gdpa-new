<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlideResource\Pages;
use App\Filament\Resources\SlideResource\RelationManagers;
use App\Models\Slide;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use IbrahimBougaoua\FilamentSortOrder\Actions\DownStepAction;
use IbrahimBougaoua\FilamentSortOrder\Actions\UpStepAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SlideResource extends Resource
{
    protected static ?string $model = Slide::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Slides';

    protected static ?string $modelLabel = 'Slide';

    protected static ?string $pluralModelLabel = 'Slides';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Slide Information')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('slides')
                            ->label('Slide Images')
                            ->collection('slides')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->multiple()
                            ->reorderable()
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('status')
                            ->label('Active')
                            ->default(true)
                            ->required(),

                        Forms\Components\TextInput::make('sort')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(fn() => Slide::max('sort') + 1)
                            ->required()
                            ->minValue(0),
                    ])
                    ->columns(2),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title.en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title.ka')
                            ->label('Title (Georgian)')
                            ->maxLength(255),

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
                            ]),


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
                            ]),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort')
                    ->label('#')
                    ->sortable()
                    ->alignCenter()
                    ->size('sm'),

                SpatieMediaLibraryImageColumn::make('slides')
                    ->label('Images')
                    ->collection('slides')
                    ->conversion('thumb')
                    ->size(60)
                    ->limit(3),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->getStateUsing(
                        fn(Slide $record): string =>
                        $record->getTranslation('title', app()->getLocale()) ??
                            $record->getTranslation('title', 'en') ??
                            'No title'
                    )
                    ->searchable()
                    ->wrap(),

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
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    DownStepAction::make(),
                    UpStepAction::make(),
                ])
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort')
            ->defaultSort('sort')
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Slide')
                    ->icon('heroicon-o-plus'),
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
            'index' => Pages\ListSlides::route('/'),
            'create' => Pages\CreateSlide::route('/create'),
            'edit' => Pages\EditSlide::route('/{record}/edit'),
        ];
    }
}
