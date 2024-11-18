<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\EmployeeResource\Pages;
use App\Filament\App\Resources\EmployeeResource\RelationManagers;
use App\Models\city;
use App\Models\Employee;
use App\Models\state;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Name')
                ->description('Put the user name details in.')
                ->schema([Forms\Components\TextInput::make('Frist_name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('middle_name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255),])
                ->columns(3),
                Forms\Components\Select::make('country_id')
                    ->relationship('country' , 'name')
                    ->searchable()
                    // ->multiple()
                    ->live()
                    ->preload()
                    ->afterStateUpdated(fn(Set $set)=>$set('state_id',null))
                    ->required(),
                    Forms\Components\Select::make('state_id')
                    ->options(fn(Get $get):Collection =>state::query()
                        ->where('country_id',$get('country_id'))
                        ->pluck('name','id'))
                    ->live()
                    ->searchable()
                    // ->multiple()
                    ->preload()
                    ->afterStateUpdated(fn(Set $set)=>$set('city_id',null))
                    ->required(),
                    Forms\Components\Select::make('city_id')
                    ->options(fn(Get $get):Collection =>city::query()
                        ->where('state_id',$get('state_id'))
                        ->pluck('name','id'))
                    ->searchable()
                    // ->multiple()
                    ->preload()
                    ->live()
                    ->required(),
                    Forms\Components\Select::make('department_id')
                    ->relationship('department' , 'name',
                    fn(Builder $query)=>$query->whereBelongsTo(Filament::getTenant()))
                    ->searchable()
                    // ->multiple()
                    ->preload()
                    ->required(),
                Forms\Components\Section::make('User address')
                ->schema([Forms\Components\TextInput::make('address')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('zip_cde')
                ->required()
                ->maxLength(255),])
                ->columns(2),
                Forms\Components\Section::make('Dates')
                ->schema([Forms\Components\DatePicker::make('date_of_birth')
                ->required(),
            Forms\Components\DatePicker::make('date_hired')
                ->required(),])
                ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('Frist_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('zip_cde')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_hired')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('Department')
                ->relationship('department','name')
                ->searchable()
                ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('relation info')
                ->schema([
                TextEntry::make('country.name'),
                TextEntry::make('state.name'),
                TextEntry::make('city.name'),
                TextEntry::make('department.name'),
                ])->columns(2),
                Section::make('user info')
                ->schema([
                TextEntry::make('frist_namee'),
                TextEntry::make('middel_name'),
                TextEntry::make('last_name'),
                ])->columns(3),
                Section::make('address')
                ->schema([
                TextEntry::make('address'),
                TextEntry::make('zip_cde'),
                ])->columns(2),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
