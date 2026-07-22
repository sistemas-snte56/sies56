<?php

namespace App\Filament\Resources\Integrantes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class IntegranteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de Identidad')
                    ->description('Datos oficiales únicos del agremiado')
                    ->schema([
                        TextInput::make('numero_personal')
                            ->label('Número de Personal')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20)
                            ->numeric(),
                        TextInput::make('rfc')
                            ->label('RFC')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->minLength(13)
                            ->maxLength(13)
                            ->extraInputAttributes(['style' => 'text-transform:uppercase'])
                            ->validationMessages([
                                'min' => 'El RFC debe tener 13 caracteres alfanuméricos.',
                                'max' => 'El RFC debe tener 13 caracteres alfanuméricos.',
                            ]),
                        TextInput::make('curp')
                            ->label('CURP')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->minLength(18)
                            ->maxLength(18)
                            ->extraInputAttributes(['style' => 'text-transform:uppercase'])
                            ->validationMessages([
                                'min' => 'La CURP debe tener 18 caracteres alfanuméricos.',
                                'max' => 'La CURP debe tener 18 caracteres alfanuméricos.',
                            ]),
                        Select::make('nivel_integrante_id')
                            ->label('Nivel Educativo')
                            ->relationship('nivelIntegrante', 'nombre')
                            ->required(),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),

                Section::make('Datos Personales')
                    ->schema([
                        TextInput::make('nombre')
                            ->required()
                            ->maxLength(255)
                            ->extraInputAttributes(['style' => 'text-transform:uppercase']),
                        TextInput::make('apellido_paterno')
                            ->required()
                            ->maxLength(255)
                            ->extraInputAttributes(['style' => 'text-transform:uppercase']),
                        TextInput::make('apellido_materno')
                            ->maxLength(255)
                            ->extraInputAttributes(['style' => 'text-transform:uppercase']),
                        Select::make('genero')
                            ->options([
                                'M' => 'MUJER',
                                'H' => 'HOMBRE',
                            ])
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Contacto y Estatus')
                    ->schema([
                        TextInput::make('telefono')
                            ->tel()
                            ->minLength(10)
                            ->maxLength(10)
                            ->validationMessages([
                                'min' => 'El teléfono debe tener 10 caracteres numéricos.',
                                'max' => 'El teléfono debe tener 10 caracteres numéricos.',
                                'regex' => 'El teléfono debe contener solo números.',
                            ])
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255)
                            ->required(),
                        Select::make('estatus_global')
                            ->options([
                                'ACTIVO' => 'Activo',
                                'INACTIVO' => 'Inactivo',
                                'FINADO' => 'Finado',
                            ])
                            ->default('ACTIVO')
                            ->required(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}