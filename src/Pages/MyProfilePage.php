<?php

namespace Kwhorne\WirementBreeze\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class MyProfilePage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'wirement-breeze::filament.pages.my-profile';

    public function getTitle(): string|Htmlable
    {
        return __('wirement-breeze::default.profile.my_profile');
    }

    public function getHeading(): string|Htmlable
    {
        return __('wirement-breeze::default.profile.my_profile');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return __('wirement-breeze::default.profile.subheading') ?? null;
    }

    public static function getSlug(): string
    {
        return filament('wirement-breeze')->slug();
    }

    public static function getNavigationLabel(): string
    {
        return __('wirement-breeze::default.profile.profile');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return filament('wirement-breeze')->shouldRegisterNavigation('myProfile');
    }

    public static function getNavigationGroup(): ?string
    {
        return filament('wirement-breeze')->getNavigationGroup('myProfile');
    }

    public function getRegisteredMyProfileComponents(): array
    {
        return filament('wirement-breeze')->getRegisteredMyProfileComponents();
    }
}
