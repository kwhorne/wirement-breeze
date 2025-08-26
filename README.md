# Wirement Breeze

## Enhanced security for Filament v4+ Panels

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kwhorne/wirement-breeze.svg?style=flat-square)](https://packagist.org/packages/kwhorne/wirement-breeze)
[![Total Downloads](https://img.shields.io/packagist/dt/kwhorne/wirement-breeze.svg?style=flat-square)](https://packagist.org/packages/kwhorne/wirement-breeze)
[![License](https://img.shields.io/packagist/l/kwhorne/wirement-breeze.svg?style=flat-square)](https://packagist.org/packages/kwhorne/wirement-breeze)

**Wirement Breeze** is a complete security package for Filament v4+ panels. The package includes a customizable "My Profile" page with personal information and avatar support, password updates, two-factor authentication, and Sanctum token management.

### ✨ Key Features
- 🔐 **Two-factor authentication** with recovery codes
- 👤 **My Profile page** with avatar support
- 🔑 **Password updates** with customizable validation rules
- 🛡️ **Password confirmation** for sensitive actions
- 🎫 **Sanctum token management**
- 🌐 **Browser session management**
- ⚡ **Quick installation** - ready in minutes!

### 🚀 Compatibility
- **Laravel 12+** (with full support for Laravel 12 features)
- **Filament v4.0+** (optimized for latest Filament features)
- **TailwindCSS v4.0+** (compatible with modern CSS features)
- **PHP 8.2+** (supports PHP 8.2, 8.3, and 8.4)

## 📸 Features

### My Profile - Personal information with avatar support

### Password updates with customizable validation rules

### Protected actions with password confirmation

### Two-factor authentication with recovery codes

### Required two-factor authentication

### Sanctum token management

### Browser session management

## 📦 Installation

Install the package via Composer:

```bash
composer require kwhorne/wirement-breeze
php artisan wirement-breeze:install
```

### Publish views (optional)

```bash
php artisan vendor:publish --tag="wirement-breeze-views"
```

### Publish translations (optional)

```bash
php artisan vendor:publish --tag="wirement-breeze-translations"
```

## ⚙️ Usage & Configuration

You must enable Wirement Breez by adding the class to your Filament Panel's `plugin()` or `plugins([])` method:

```php
use Kwhorne\WirementBreeze\WirementBreezeCore;

class CustomersPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ...
            ->plugin(
                WirementBreezeCore::make()
            )
    }
}
```

### Update auth guard

Wirement Breez will use the `authGuard` set on the Filament Panel that you create. You may update the authGuard as you please:

```php
use Kwhorne\WirementBreeze\WirementBreezeCore;

class CustomersPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ...
            ->authGuard('customers')
            ->plugin(
                WirementBreezeCore::make()
            )
    }
}
```

**NOTE:** you must ensure that the model used in your Guard extends the Authenticatable class.

### My Profile

Enable the My Profile page with configuration options.

**NOTE:** if you are using avatars,

```php
WirementBreezeCore::make()
    ->myProfile(
        shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
        userMenuLabel: 'My Profile', // Customizes the 'account' link label in the panel User Menu (default = null)
        shouldRegisterNavigation: false, // Adds a main navigation item for the My Profile page (default = false)
        navigationGroup: 'Settings', // Sets the navigation group for the My Profile page (default = null)
        hasAvatars: false, // Enables the avatar upload form component (default = false)
        slug: 'my-profile' // Sets the slug for the profile page (default = 'my-profile')
    )
```

#### Custom My Profile page class

You can also use a custom My Profile page class by extending the default one, and registering it with the plugin.

```php
WirementBreezeCore::make()
    ->myProfile()
    ->customMyProfilePage(AccountSettingsPage::class),
```

#### Using avatars in your Panel

The instructions for using custom avatars is found in the Filament v4 docs under [Setting up user avatars](https://filamentphp.com/docs/4.x/panels/users#setting-up-user-avatars).

Here is a possible implementation using the example from the docs:

```php
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    // ...

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null ;
    }
}

```

#### Customize the avatar upload component


```php
use Filament\Schemas\Components\FileUpload;

WirementBreezeCore::make()
    ->avatarUploadComponent(fn($fileUpload) => $fileUpload->disableLabel())
    // OR, replace with your own component
    ->avatarUploadComponent(fn() => FileUpload::make('avatar_url')->disk('profile-photos'))
```

#### Add column to table

If you wish to have your own avatar, you need to create a column on the users table named `avatar_url`. It is recommended that you create a new migration for it, and add the column there:

```
php artisan make:migration add_avatar_url_column_to_users_table
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar_url');
        });
    }
};
```

#### Add column to user model
```php
    protected $fillable = [
        ...
        'avatar_url',
        ...
    ];
```


#### Customize password update

You can customize the validation rules for the update password component by passing an array of validation strings, or an instance of the `Illuminate\Validation\Rules\Password` class.

```php
use Illuminate\Validation\Rules\Password;

WirementBreezeCore::make()
    ->passwordUpdateRules(
        rules: [Password::default()->mixedCase()->uncompromised(3)], // you may pass an array of validation rules as well. (default = ['min:8'])
        requiresCurrentPassword: true, // when false, the user can update their password without entering their current password. (default = true)
        )

```

#### Exclude default My Profile components

If you don't want a default My Profile page component to be used, you can exclude them using the `withoutMyProfileComponents` helper.

```php
WirementBreezeCore::make()
    ->withoutMyProfileComponents([
        'update_password'
    ])
```


#### Create custom My Profile components

In Wirement Breeze, you can now create custom Livewire components for the My Profile page and append them easily.

1. Create a new Livewire component in your project using:

```
php artisan make:livewire MyCustomComponent
```

2. Extend the `MyProfileComponent` class included with Wirement Breeze. This class implements Actions and Forms.

```php
use Kwhorne\WirementBreeze\Livewire\MyProfileComponent;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class MyCustomComponent extends MyProfileComponent
{
    protected string $view = "livewire.my-custom-component";
    public array $only = ['my_custom_field'];
    public array $data;
    public $user;
    public $userClass;

    // this example shows an additional field we want to capture and save on the user
    public function mount()
    {
        $this->user = Filament::getCurrentPanel()->auth()->user();
        $this->userClass = get_class($this->user);

        $this->form->fill($this->user->only($this->only));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('my_custom_field')
                    ->required()
            ])
            ->statePath('data');
    }

    // only capture the custome component field
    public function submit(): void
    {
        $data = collect($this->form->getState())->only($this->only)->all();
        $this->user->update($data);
        Notification::make()
            ->success()
            ->title(__('Custom component updated successfully'))
            ->send();
    }
}

```

3. Within your Livewire component's view, you can use Wirement Breeze's `grid-section` blade component to match the style:

```blade
<x-wirement-breeze::grid-section md=2 title="Your title" description="This is the description">
    <x-filament::card>
        <form wire:submit.prevent="submit" class="space-y-6">

            {{ $this->form }}

            <div class="text-right">
                <x-filament::button type="submit" form="submit" class="align-right">
                    Submit!
                </x-filament::button>
            </div>
        </form>
    </x-filament::card>
</x-wirement-breeze::grid-section>
```

4. Finally, register your new component with Wirement Breeze:

```php
use App\Livewire\MyCustomComponent;

WirementBreezeCore::make()
    ->myProfileComponents([MyCustomComponent::class])
```

#### Override My Profile components

You may override the existing MyProfile components to replace them with your own:

```php
use App\Livewire\MyCustomComponent;

WirementBreezeCore::make()
    ->myProfileComponents([
        // 'personal_info' => ,
        'update_password' => MyCustomComponent::class, // replaces UpdatePassword component with your own.
        // 'two_factor_authentication' => ,
        // 'sanctum_tokens' =>
        // 'browser_sessions' =>
    ])
```

If you want to customize only the fields and notification in the personal info component, you can extend the original breezy component:

```php
namespace App\Livewire;

use Filament\Forms\Components;
use Filament\Notifications\Notification;
use Kwhorne\WirementBreeze\Livewire\PersonalInfo;

class CustomPersonalInfo extends PersonalInfo
{
    public ?array $only = ['custom_name_field', 'custom_email_field'];

    // You can override the default components by returning an array of components.
    protected function getProfileFormComponents(): array
    {
        return [
            $this->getNameComponent(),
            $this->getEmailComponent(),
            $this->getCustomComponent(),
        ];
    }

    protected function getNameComponent(): Components\TextInput
    {
        return Components\TextInput::make('custom_name_field')
            ->required();
    }

    protected function getEmailComponent(): Components\TextInput
    {
        return Components\TextInput::make('custom_email_field')
            ->required();
    }

    protected function sendNotification(): void
    {
        Notification::make()
            ->success()
            ->title('Saved Data!')
            ->send();
    }
}

```
Now, as mentioned above, give this component to `WirementBreezeCore::make()->myProfileComponents` to override the original and use your custom component.

#### Sorting My Profile components

Custom MyProfile components can be sorted by setting their static `$sort` property. This property can be set for existing MyProfile components in any service provider:

```php
TwoFactorAuthentication::setSort(4);
```

A lot of the time this won't be necessary, though, as the default sort order is spaced out in steps of 10, so there should be enough numbers to place any custom components in between.

### Two Factor Authentication

1. Add `Kwhorne\WirementBreeze\Traits\TwoFactorAuthenticatable` to your Authenticatable model:

```php
use Kwhorne\WirementBreeze\Traits\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;
    // ...

}
```

2. Enable Two Factor Authentication using the `enableTwoFactorAuthentication()` method on the Wirement Breeze plugin.

```php
WirementBreezeCore::make()
    ->enableTwoFactorAuthentication(
        force: false, // force the user to enable 2FA before they can use the application (default = false)
        action: CustomTwoFactorPage::class // optionally, use a custom 2FA page
        authMiddleware: MustTwoFactor::class // optionally, customize 2FA auth middleware or disable it to register manually by setting false
    )
```

3. Adjust the 2FA page

The Wirement Breeze 2FA page can be swapped for a custom implementation (see above), same as the Filament auth pages. This allows, for example, to define a custom auth layout like so:

```php
use Kwhorne\WirementBreeze\Pages\TwoFactorPage;

class CustomTwoFactorPage extends TwoFactorPage
{
    protected static string $layout = 'custom.auth.layout.view';
}
```

### Sanctum Personal Access tokens

As of Laravel 8.x Sanctum is included with Laravel, but if you don't already have the package follow the [installation instructions here](https://laravel.com/docs/8.x/sanctum#installation).

Enable the Sanctum token management component:

```php
WirementBreezeCore::make()
    ->enableSanctumTokens(
        permissions: ['my','custom','permissions'] // optional, customize the permissions (default = ["create", "view", "update", "delete"])
    )
```

### Password Confirmation Button Action

This button action will prompt the user to enter their password for sensitive actions (eg. delete). This action uses the same `'password_timeout'` number of seconds found in `config/auth.php`.

```php
use Kwhorne\WirementBreeze\Actions\PasswordButtonAction;

PasswordButtonAction::make('secure_action')->action('doSecureAction')

// Customize the icon, action, modalHeading and anything else.
PasswordButtonAction::make('secure_action')->label('Delete')->icon('heroicon-s-shield-check')->modalHeading('Confirmation')->action(fn()=>$this->doAction())
```

### Browser Sessions

The **Browser Sessions** feature, which is disabled by default, allows users to manage their active sessions on different devices and remotely log out of other browser sessions, enhancing account security. To enable this feature, you must use the `enableBrowserSessions` method.

#### Enabling Browser Sessions

To enable the Browser Sessions feature, use the `enableBrowserSessions` method in `WirementBreezeCore`:

```php
WirementBreezeCore::make()
    ->enableBrowserSessions(condition: true) // Enable the Browser Sessions feature (default = true)
```

#### Viewing Active Sessions

On the user's profile page, active sessions are displayed with device information, including:

- Browser and platform of the device
- IP address
- Last activity of the session

#### Logging Out of Other Browser Sessions

Users can log out of other active sessions by entering their password for confirmation. This allows them to securely log out of all other active sessions on other devices.

#### Additional Configuration

If you want to customize the component or modify its behavior, you can override the `browser_sessions` component in the `myProfileComponents` method:

```php
WirementBreezeCore::make()
    ->myProfileComponents([
        'browser_sessions' => \App\Livewire\CustomBrowserSessions::class, // Your custom component
    ])
```

### Customizing Registration Forms

Filament v4+ introduces enhanced capabilities for handling and customizing registration forms seamlessly. 

## 🙋‍♀️ Frequently Asked Questions (FAQ)

### How do 2FA sessions work across multiple panels?
By default, Wirement Breeze uses the same guard as defined on your Panel. The default is 'web'. Only panels that have registered the WirementBreezeCore plugin will have access to 2FA. If multiple panels use 2FA and share the same guard, the user only needs to enter the OTP code once for the duration of the session.

### How does 2FA interact with MustVerifyEmail?
When 2FA is properly configured, the user is prompted for the OTP code before email verification.

### How long does the 2FA session last?
The 2FA session is the same as the Laravel session lifetime. When the user is logged out, or the session expires, they must enter the OTP code again.

### Which languages are supported?
The package supports 30+ languages including Norwegian (nb). You can publish and customize translations:
```bash
php artisan vendor:publish --tag="wirement-breeze-translations"
```

### Can I customize the appearance?
Yes! You can publish and customize all views:
```bash
php artisan vendor:publish --tag="wirement-breeze-views"
```



## 🧪 Testing

```bash
composer test
```

## 📝 Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## 🤝 Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details on how to contribute.

## 🔒 Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## 🚀 Quick Start

To get started quickly with Wirement Breez:

1. **Install the package:**
   ```bash
   composer require kwhorne/wirement-breeze
   php artisan wirement-breeze:install
   ```

2. **Add plugin to your Panel:**
   ```php
   use Kwhorne\WirementBreeze\WirementBreezeCore;
   
   ->plugin(WirementBreezeCore::make())
   ```

3. **Enable 2FA (optional):**
   ```php
   ->plugin(
       WirementBreezeCore::make()
           ->enableTwoFactorAuthentication()
   )
   ```

4. **Add trait to User model:**
   ```php
   use Kwhorne\WirementBreeze\Traits\TwoFactorAuthenticatable;
   
   class User extends Authenticatable
   {
       use TwoFactorAuthenticatable;
   }
   ```

Done! You now have a secure Filament application with profile management and 2FA.

## 🙏 Credits

-   [Jeff Greco](https://github.com/jeffgreco13) - Original Filament Breezy developer
-   [Knut W. Horne](https://github.com/kwhorne) - Wirement Breeze developer
-   [All Contributors](../../contributors)

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---

**Wirement Breeze** - A complete security package for modern Filament v4+ applications.

Developed with ❤️ by Knut W. Horne(https://kwhorne.com)
