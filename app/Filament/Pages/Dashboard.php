<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'لوحة التحكم الرئيسية';

    public function getHeading(): string
    {
        return 'لوحة التحكم الرئيسية';
    }

    public function getSubheading(): ?string
    {
        return 'نظرة عامة على أداء النظام';
    }

    public function getColumns(): int | string | array
    {
        return 1;
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\CustomDashboardWidget::class,
        ];
    }
}
