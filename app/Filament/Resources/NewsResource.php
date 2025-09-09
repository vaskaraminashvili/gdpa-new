<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'News';

    protected static ?string $modelLabel = 'News Article';

    protected static ?string $pluralModelLabel = 'News';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('News Information')
                    ->schema([
                        Forms\Components\Toggle::make('status')
                            ->label('Active')
                            ->default(true)
                            ->columnSpanFull()
                            ->required(),

                        Forms\Components\DateTimePicker::make('publish_date')
                            ->label('Publish Date')
                            ->default(now())
                            ->required()
                            ->columnSpanFull(),

                        SpatieMediaLibraryFileUpload::make('images')
                            ->label('News Images')
                            ->collection('images')
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


                    ])
                    ->columns(2),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(News::class, 'slug', ignoreRecord: true)
                            ->rules(['alpha_dash'])
                            ->columnSpanFull()
                            ->disabled(),
                        Forms\Components\TextInput::make('title.en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                                if (filled($state)) {
                                    $set('slug', \Illuminate\Support\Str::slug($state));
                                }
                            }),



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
                SpatieMediaLibraryImageColumn::make('images')
                    ->label('Images')
                    ->collection('images')
                    ->conversion('thumb')
                    ->size(60)
                    ->limit(3),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->getStateUsing(
                        fn(News $record): string =>
                        $record->getTranslation('title', app()->getLocale()) ??
                            $record->getTranslation('title', 'en') ??
                            'No title'
                    )
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\ToggleColumn::make('status')
                    ->label('Status')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger'),

                Tables\Columns\TextColumn::make('publish_date')
                    ->label('Publish Date')
                    ->dateTime()
                    ->sortable(),

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

                Tables\Filters\Filter::make('published')
                    ->query(fn(Builder $query): Builder => $query->published())
                    ->label('Published Only'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
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
                ]),
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make()
                //     ->label('New Article')
                //     ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('publish_date', 'desc');
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'view' => Pages\ViewNews::route('/{record}'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
