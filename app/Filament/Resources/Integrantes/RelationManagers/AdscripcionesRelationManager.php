<?php

namespace App\Filament\Resources\Integrantes\RelationManagers;

use App\Filament\Resources\Integrantes\IntegranteResource;
use Filament\Forms\Components\Select;
// use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class AdscripcionesRelationManager extends RelationManager
{
    protected static string $relationship = 'adscripciones';

    protected static ?string $title = 'Delegación / Adscripciones Laborales';

    protected static ?string $relatedResource = IntegranteResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('delegacion_id')
                    ->label('Delegación')
                    ->relationship(
                        name: 'delegacion',
                        titleAttribute: 'delegacion',
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn ($record) => $record->nombre_completo
                    )
                    ->searchable(['delegacion', 'sede'])
                    ->preload()
                    ->required()
                    ->columnSpan(2),

                Select::make('nivel_integrante_id')
                    ->label('Nivel al que pertenece')
                    ->relationship('nivelIntegrante', 'nombre')
                    ->required()
                    ->columnSpan(1),

                Select::make('funcion')
                    ->label('Función que desempeña')
                    ->options([
                        'DIRECTOR' => 'DIRECTOR',
                        'DOCENTE' => 'DOCENTE',
                        'INTENDENTE' => 'INTENDENTE',
                        'ADMINISTRATIVO' => 'ADMINISTRATIVO',
                        'COORDINADOR' => 'COORDINADOR',
                        'OTRO' => 'OTRO',
                    ])
                    ->required()
                    ->columnSpan(2),

                DatePicker::make('fecha_ingreso_sev')
                    ->label('Fecha Ingreso SEP')
                    ->native(false)
                    ->columnSpan(1),

                Select::make('estatus_adscripcion')
                    ->label('Estatus de la Delegación')
                    ->options([
                        'ACTIVO' => 'Activo',
                        'PENDIENTE_BAJA' => 'Pendiente de Baja',
                        'INACTIVO' => 'Inactivo',
                    ])
                    ->default('ACTIVO')
                    ->required()
                    ->columnSpanFull(),
            ])
            ->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('funcion')
            ->columns([
                TextColumn::make('delegacion.nombre_completo')
                    ->label('Delegación')
                    ->sortable()
                    ->searchable(),
                
                // TextColumn::make('delegacion.sede')
                //     ->label('Sede'),

                // TextColumn::make('nivelIntegrante.nombre')
                //     ->label('Nivel'),

                TextColumn::make('funcion')
                    ->label('Función'),

                TextColumn::make('estatus_adscripcion')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ACTIVO' => 'success',
                        'PENDIENTE_BAJA' => 'warning',
                        'INACTIVO' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Añadir Delegación'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}