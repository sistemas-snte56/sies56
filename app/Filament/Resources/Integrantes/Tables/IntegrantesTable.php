<?php

namespace App\Filament\Resources\Integrantes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;


class IntegrantesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('numero_personal')
                    ->label('No. de Personal')
                    ->searchable(),
                 
                TextColumn::make('nombre_completo')
                    ->label('Nombre') 
                    // ->searchable(query: function ($query, $search) {
                    //     $query->where(function ($q) use ($search) {
                    //         $q->where('nombre', 'like', "%{$search}%")
                    //         ->orWhere('apellido_paterno', 'like', "%{$search}%")
                    //         ->orWhere('apellido_materno', 'like', "%{$search}%");
                    //     });
                    // })
                 
                    ->searchable([
                        'apellido_paterno',
                        'apellido_materno',
                        'nombre',
                    ]),
                    
                TextColumn::make('rfc')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('curp')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('genero')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('telefono')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('nivelIntegrante.nombre')
                    ->searchable(),
                TextColumn::make('estatus_global')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ACTIVO' => 'success',
                        'INACTIVO' => 'warning',
                        'FINADO' => 'danger',
                        default => 'gray',
                    }),
                    


            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('estatus_global')
                    ->options([
                        'ACTIVO' => 'Activo',
                        'INACTIVO' => 'Inactivo',
                        'FINADO' => 'Finado',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
