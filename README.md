# PNJ SSO Provider

```bash
composer require chillrend/pnj-socialite-provider
```

## Installation & Basic Usage

Please see the [Base Installation Guide](https://socialiteproviders.com/usage/), then follow the provider specific instructions below.

### Add configuration to `config/services.php`

```php
'pnj' => [    
  'client_id' => env('CLIENT_ID'),  
  'client_secret' => env('CLIENT_SECRET'),  
  'redirect' => env('REDIRECT_URI') 
],
```

### Add provider event listener

Configure the package's listener to listen for `SocialiteWasCalled` events.

Add the event to your `listen[]` array in `app/Providers/EventServiceProvider`. See the [Base Installation Guide](https://socialiteproviders.com/usage/) for detailed instructions.

```php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        // ... other providers
        'SocialiteProviders\\PNJ\\PNJExtendSocialite@handle',
    ],
];
```

### Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

```php
return Socialite::driver('pnj')->redirect();
```

### Returned User fields

- ``sub`` the system internal ID of a user
- ``ident`` the user's internal identification number (can be a NIP (Nomor Induk Pegawai) or NIM (Nomor Induk Mahasiswa) depends on the access level of the user)
- ``name`` the user's full name
- ``email`` the user's email address
- ``address`` the user's home address
- ``date_of_birth`` the user's date of birth
- ``department_and_level`` the user's access level and the user's department (in array)
  - ``access_level`` the user's access level in a department
  - ``access_level_name`` the 'human readable' representation of the access level  
  - ``department`` the user's department
  - ``department_short_name`` the department short abbreviation or name 

**JSON Representative of the user fields**
```json
{
  "address": "187 Justen Point Suite 090\nWest Shania, TX 99746-9546",
  "date_of_birth": "1979-03-14",
  "department_and_level": [
    {
      "access_level": 99,
      "access_level_name": "Admin",
      "department": "Teknik Informatika dan Komputer",
      "department_short_name": "TIK"
    }
  ],
  "email": "wilkinson.marquise@example.com",
  "iat": 1622287930,
  "ident": 80779,
  "name": "Prof. Ivory Ferry",
  "sub": "4"
}
```
