<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Forms\Components\Tabs\Tab as TabsTab;
use Filament\Infolists\Components\Tabs;
//use Filament\Infolists\Components\Tabs\Tab;
use Filament\Resources\Components\Tab as ComponentsTab;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
{
    return [
        'all' => Tab::make(),
        'This Week'=>Tab::make()
        ->modifyQueryUsing(fn(Builder $query)=> $query->where('date_hired','=>',now()->subWeek())),
    ];
}
}
