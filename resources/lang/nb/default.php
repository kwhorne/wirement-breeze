<?php

return [
    'password_confirm' => [
        'heading' => 'Bekreft passord',
        'description' => 'Vennligst bekreft passordet ditt for å fullføre denne handlingen.',
        'current_password' => 'Nåværende passord',
    ],
    'two_factor' => [
        'heading' => 'Tofaktor-utfordring',
        'description' => 'Vennligst bekreft tilgang til kontoen din ved å skrive inn koden fra autentiseringsappen din.',
        'code_placeholder' => 'XXX-XXX',
        'recovery' => [
            'heading' => 'Tofaktor-utfordring',
            'description' => 'Vennligst bekreft tilgang til kontoen din ved å skrive inn en av dine nødgjenopprettingskoder.',
        ],
        'recovery_code_placeholder' => 'abcdef-98765',
        'recovery_code_text' => 'Mistet enheten?',
        'recovery_code_link' => 'Bruk en gjenopprettingskode',
        'back_to_login_link' => 'Tilbake til innlogging',
    ],
    'profile' => [
        'account' => 'Konto',
        'profile' => 'Profil',
        'my_profile' => 'Min profil',
        'subheading' => 'Administrer brukerprofilen din her.',
        'personal_info' => [
            'heading' => 'Personlig informasjon',
            'subheading' => 'Administrer din personlige informasjon.',
            'submit' => [
                'label' => 'Oppdater',
            ],
            'notify' => 'Profil oppdatert!',
        ],
        'password' => [
            'heading' => 'Passord',
            'subheading' => 'Må være minst 8 tegn langt.',
            'submit' => [
                'label' => 'Oppdater',
            ],
            'notify' => 'Passord oppdatert!',
        ],
        '2fa' => [
            'title' => 'Tofaktor-autentisering',
            'description' => 'Administrer tofaktor-autentisering for kontoen din (anbefalt).',
            'actions' => [
                'enable' => 'Aktiver',
                'regenerate_codes' => 'Generer nye gjenopprettingskoder',
                'disable' => 'Deaktiver',
                'confirm_finish' => 'Bekreft og fullfør',
                'cancel_setup' => 'Avbryt oppsett',
            ],
            'setup_key' => 'Oppsettsnøkkel',
            'must_enable' => 'Du må aktivere tofaktor-autentisering for å bruke denne applikasjonen.',
            'not_enabled' => [
                'title' => 'Du har ikke aktivert tofaktor-autentisering.',
                'description' => 'When tofaktor-autentisering er aktivert, vil du bli bedt om en sikker, tilfeldig kode under autentisering. Du kan bruke autentiseringsapper på smarttelefonen din som Google Authenticator, Microsoft Authenticator osv. for å gjøre dette',
            ],
            'finish_enabling' => [
                'title' => 'Fullfør aktivering av tofaktor-autentisering.',
                'description' => "For å fullføre aktiveringen av tofaktor-autentisering, skann følgende QR-kode med telefonens autentiseringsapp eller skriv inn oppsettsnøkkelen og oppgi den genererte OTP-koden.",
            ],
            'enabled' => [
                'notify' => 'Tofaktor-autentisering aktivert.',
                'title' => 'Du har aktivert tofaktor-autentisering!',
                'description' => 'Tofaktor-autentisering er nå aktivert. Dette bidrar til å gjøre kontoen din sikrere.',
                'store_codes' => 'Disse kodene kan brukes til å gjenopprette tilgang til kontoen din hvis enheten din går tapt. Advarsel! Disse kodene vises bare én gang.',
            ],
            'disabling' => [
                'notify' => 'Tofaktor-autentisering har blitt deaktivert.',
            ],
            'regenerate_codes' => [
                'notify' => 'Nye gjenopprettingskoder har blitt generert.',
            ],
            'confirmation' => [
                'success_notification' => 'Kode verifisert. Tofaktor-autentisering aktivert.',
                'invalid_code' => 'Koden du har skrevet inn er ugyldig.',
            ],
        ],
        'sanctum' => [
            'title' => 'API-tokens',
            'description' => 'Administrer API-tokens som lar tredjepartstjenester få tilgang til denne applikasjonen på dine vegne.',
            'create' => [
                'notify' => 'Token opprettet!',
                'message' => 'Tokenet ditt vises bare én gang ved opprettelse. Hvis du mister tokenet, må du slette det og opprette et nytt.',
                'submit' => [
                    'label' => 'Opprett',
                ],
            ],
            'update' => [
                'notify' => 'Token oppdatert!',
                'submit' => [
                    'label' => 'Oppdater',
                ],
            ],
            'copied' => [
                'label' => 'Jeg har kopiert tokenet mitt',
            ],
        ],
        'browser_sessions' => [
            'heading' => 'Nettleserøkter',
            'subheading' => 'Administrer dine aktive økter.',
            'label' => 'Nettleserøkter',
            'content' => 'Om nødvendig kan du logge ut av alle andre nettleserøkter på alle enhetene dine. Noen av dine nylige økter er listet nedenfor; denne listen er imidlertid kanskje ikke uttømmende. Hvis du føler at kontoen din har blitt kompromittert, bør du også oppdatere passordet ditt.',
            'device' => 'Denne enheten',
            'last_active' => 'Sist aktiv',
            'logout_other_sessions' => 'Logg ut andre nettleserøkter',
            'logout_heading' => 'Logg ut andre nettleserøkter',
            'logout_description' => 'Vennligst skriv inn passordet ditt for å bekrefte at du vil logge ut av andre nettleserøkter på alle enhetene dine.',
            'logout_action' => 'Logg ut andre nettleserøkter',
            'incorrect_password' => 'Passordet du skrev inn var feil. Vennligst prøv igjen.',
            'logout_success' => 'Alle andre nettleserøkter har blitt logget ut.',
        ],
    ],
    'clipboard' => [
        'link' => 'Kopier til utklippstavle',
        'tooltip' => 'Kopiert!',
    ],
    'fields' => [
        'avatar' => 'Avatar',
        'email' => 'E-post',
        'login' => 'Innlogging',
        'name' => 'Navn',
        'password' => 'Passord',
        'password_confirm' => 'Bekreft passord',
        'new_password' => 'Nytt passord',
        'new_password_confirmation' => 'Bekreft passord',
        'token_name' => 'Token-navn',
        'token_expiry' => 'Token utløp',
        'abilities' => 'Tillatelser',
        '2fa_code' => 'Kode',
        '2fa_recovery_code' => 'Gjenopprettingskode',
        'created' => 'Opprettet',
        'expires' => 'Utløper',
    ],
    'or' => 'Eller',
    'cancel' => 'Avbryt',
];
