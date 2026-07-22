<?php

namespace App\Filament\Resources\Integrantes;

use App\Filament\Resources\Integrantes\Pages\CreateIntegrante;
use App\Filament\Resources\Integrantes\Pages\EditIntegrante;
use App\Filament\Resources\Integrantes\Pages\ListIntegrantes;
use App\Filament\Resources\Integrantes\Schemas\IntegranteForm;
use App\Filament\Resources\Integrantes\Tables\IntegrantesTable;
use App\Models\Integrante;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IntegranteResource extends Resource
{
    protected static ?string $model = Integrante::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return IntegranteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IntegrantesTable::configure($table);
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
            'index' => ListIntegrantes::route('/'),
            'create' => CreateIntegrante::route('/create'),
            'edit' => EditIntegrante::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
