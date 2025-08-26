<?php

namespace Kwhorne\WirementBreeze\Livewire;

use Carbon\Carbon;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Forms\Components\Actions;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

class BrowserSessions extends MyProfileComponent
{
    protected string $view = 'wirement-breeze::livewire.browser-sessions';

    protected string $listView = 'wirement-breeze::components.browser-sessions-list';

    public array $data;

    public static $sort = 50;

    public function mount()
    {
        //
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\ViewField::make('browserSessions')
                    ->label(__('wirement-breeze::default.profile.browser_sessions.label'))
                    ->hiddenLabel()
                    ->view($this->listView)
                    ->viewData(['data' => self::getSessions()]),

                Actions::make([
                    Actions\Action::make('deleteBrowserSessions')
                        ->label(__('wirement-breeze::default.profile.browser_sessions.logout_other_sessions'))
                        ->requiresConfirmation()
                        ->modalHeading(__('wirement-breeze::default.profile.browser_sessions.logout_heading'))
                        ->modalDescription(__('wirement-breeze::default.profile.browser_sessions.logout_description'))
                        ->modalSubmitActionLabel(__('wirement-breeze::default.profile.browser_sessions.logout_action'))
                        ->form([
                            Components\TextInput::make('password')
                                ->password()
                                ->revealable()
                                ->label(__('wirement-breeze::default.fields.password'))
                                ->required(),
                        ])
                        ->action(function (array $data) {
                            self::logoutOtherBrowserSessions($data['password']);
                        })
                        ->modalWidth('2xl'),
                ]),
            ]);
    }

    public static function getSessions(): array
    {
        if (config('session.driver') !== 'database') {
            return [];
        }

        $sessions = DB::connection(config('session.connection'))->table(config('session.table'))
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->latest('last_activity')
            ->get();

        return $sessions->map(function (object $session): object {
            $agent = self::createAgent($session);

            return (object) [
                'device' => [
                    'browser' => $agent->browser(),
                    'desktop' => $agent->isDesktop(),
                    'mobile' => $agent->isMobile(),
                    'tablet' => $agent->isTablet(),
                    'platform' => $agent->platform(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        })->toArray();
    }

    protected static function createAgent(mixed $session)
    {
        return tap(new Agent, fn ($agent) => $agent->setUserAgent($session->user_agent));
    }

    public static function logoutOtherBrowserSessions($password): void
    {
        if (! Hash::check($password, Auth::user()->password)) {
            Notification::make()
                ->danger()
                ->title(__('wirement-breeze::default.profile.browser_sessions.incorrect_password'))
                ->send();

            return;
        }

        Auth::guard()->logoutOtherDevices($password);

        request()->session()->put([
            'password_hash_'.Auth::getDefaultDriver() => Auth::user()->getAuthPassword(),
        ]);

        self::deleteOtherSessionRecords();

        Notification::make()
            ->success()
            ->title(__('wirement-breeze::default.profile.browser_sessions.logout_success'))
            ->send();
    }

    protected static function deleteOtherSessionRecords()
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table'))
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId())
            ->delete();
    }
}
