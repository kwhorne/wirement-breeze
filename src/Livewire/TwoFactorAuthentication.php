<?php

namespace Kwhorne\WirementBreeze\Livewire;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Kwhorne\WirementBreeze\Actions\PasswordButtonAction;

class TwoFactorAuthentication extends MyProfileComponent
{
    protected string $view = 'wirement-breeze::livewire.two-factor-authentication';

    // public ?array $data = [];
    public $user;

    public $code;

    public bool $showRecoveryCodes = false;

    public static $sort = 30;

    public function mount()
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();
    }

    public function enableAction(): Action
    {
        return PasswordButtonAction::make('enable')
            ->label(__('wirement-breeze::default.profile.2fa.actions.enable'))
            ->action(function () {
                // sleep(1);
                $this->user->enableTwoFactorAuthentication();
                Notification::make()
                    ->success()
                    ->title(__('wirement-breeze::default.profile.2fa.enabled.notify'))
                    ->send();
            });
    }

    public function disableAction(): Action
    {
        return PasswordButtonAction::make('disable')
            ->label(__('wirement-breeze::default.profile.2fa.actions.disable'))
            ->color('primary')
            ->requiresConfirmation()
            ->action(function () {
                $this->user->disableTwoFactorAuthentication();
                Notification::make()
                    ->warning()
                    ->title(__('wirement-breeze::default.profile.2fa.disabling.notify'))
                    ->send();
            });
    }

    public function confirmAction(): Action
    {
        return Action::make('confirm')
            ->color('success')
            ->label(__('wirement-breeze::default.profile.2fa.actions.confirm_finish'))
            ->modalWidth('sm')
            ->form([
                Forms\Components\TextInput::make('code')
                    ->label(__('wirement-breeze::default.fields.2fa_code'))
                    ->placeholder('###-###')
                    ->required(),
            ])
            ->action(function ($data, $action, $livewire) {
                if (! filament('wirement-breeze')->verify(code: $data['code'])) {
                    $livewire->addError('mountedActionsData.0.code', __('wirement-breeze::default.profile.2fa.confirmation.invalid_code'));
                    $action->halt();
                }
                $this->user->confirmTwoFactorAuthentication();
                $this->user->setTwoFactorSession();
                Notification::make()
                    ->success()
                    ->title(__('wirement-breeze::default.profile.2fa.confirmation.success_notification'))
                    ->send();
            });
    }

    public function regenerateCodesAction(): Action
    {
        return PasswordButtonAction::make('regenerateCodes')
            ->label(__('wirement-breeze::default.profile.2fa.actions.regenerate_codes'))
            ->requiresConfirmation()
            ->action(function () {
                // These needs to regenerate the codes, then show the section.
                $this->user->reGenerateRecoveryCodes();
                $this->showRecoveryCodes = true;
                Notification::make()
                    ->success()
                    ->title(__('wirement-breeze::default.profile.2fa.regenerate_codes.notify'))
                    ->send();
            });

    }

    public function getRecoveryCodesProperty(): Collection
    {
        return collect($this->user->two_factor_recovery_codes ?? []);
    }

    public function getTwoFactorQrCode()
    {
        return filament('wirement-breeze')->getTwoFactorQrCodeSvg($this->user->getTwoFactorQrCodeUrl());
    }

    public function toggleRecoveryCodes()
    {
        $this->showRecoveryCodes = ! $this->showRecoveryCodes;
    }

    public function showRequiresTwoFactorAlert()
    {
        return filament('wirement-breeze')->shouldForceTwoFactor();
    }
}
