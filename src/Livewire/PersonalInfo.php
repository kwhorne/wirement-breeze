<?php

namespace Kwhorne\WirementBreeze\Livewire;

use Filament\Facades\Filament;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Notifications\Notification;

class PersonalInfo extends MyProfileComponent
{
    protected string $view = 'wirement-breeze::livewire.personal-info';

    public ?array $data = [];

    public $user;

    public $userClass;

    public bool $hasAvatars;

    public array $only = ['name', 'email'];

    public static $sort = 10;

    public function mount(): void
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();
        $this->userClass = get_class($this->user);
        $this->hasAvatars = filament('wirement-breeze')->hasAvatars();

        if ($this->hasAvatars) {
            $this->only[] = filament('wirement-breeze')->getAvatarUploadComponent()->getStatePath(false);
        }

        $this->form->fill($this->user->only($this->only));
    }

    protected function getProfileFormSchema(): array
    {
        $groupFields = Group::make($this->getProfileFormComponents())
            ->columnSpan(2);

        return ($this->hasAvatars)
            ? [filament('wirement-breeze')->getAvatarUploadComponent(), $groupFields]
            : [$groupFields];
    }

    protected function getProfileFormComponents(): array
    {
        return [
            $this->getNameComponent(),
            $this->getEmailComponent(),
        ];
    }

    protected function getNameComponent(): Components\TextInput
    {
        return Components\TextInput::make('name')
            ->required()
            ->label(__('wirement-breeze::default.fields.name'));
    }

    protected function getEmailComponent(): Components\TextInput
    {
        return Components\TextInput::make('email')
            ->required()
            ->email()
            ->unique($this->userClass, ignorable: $this->user)
            ->label(__('wirement-breeze::default.fields.email'));
    }

    public function form(Form|Schema $form): Form|Schema
    {
        return $form->schema($this->getProfileFormSchema())->columns(3)
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = collect($this->form->getState())->only($this->only)->all();
        $this->user->update($data);
        $this->sendNotification();
    }

    protected function sendNotification(): void
    {
        Notification::make()
            ->success()
            ->title(__('wirement-breeze::default.profile.personal_info.notify'))
            ->send();
    }
}
