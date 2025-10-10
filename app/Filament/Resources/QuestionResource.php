<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Question;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use App\Filament\Resources\QuestionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Filament\Resources\QuestionResource\RelationManagers;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'الأسئلة';
    protected static ?string $pluralLabel = 'الأسئلة';
    protected static ?string $modelLabel = 'سؤال';

    public static function form(Form $form): Form
    {
         return $form
            ->schema([
                TextInput::make('question')
                    ->label('السؤال')
                    ->required(),

                // ✅ حقل اختيار التصنيف
                 BelongsToSelect::make('category_id')
                    ->label('التصنيف')
                    ->relationship('category', 'name')
                    ->required(),

                TextInput::make('answer')
                    ->label('الإجابة')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label('السؤال')
                    ->limit(50),

                // ✅ عرض اسم التصنيف في الجدول
                Tables\Columns\TextColumn::make('category.name')
                    ->label('التصنيف'),

                Tables\Columns\TextColumn::make('answer')
                    ->label('الإجابة'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('Y-m-d H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}