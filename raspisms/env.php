<?php
	/*
        This file define constants and options for the app
	*/

    $env = [
        'ENV' => 'dev',
        'SESSION_NAME' => 'raspisms',

        //RaspiSMS settings
        'WEBSITE_TITLE' => 'RaspiSMS',
        'WEBSITE_DESCRIPTION' => '',
        'WEBSITE_AUTHOR' => 'Raspberry Pi FR',
        'PWD_SCRIPTS' => PWD . '/scripts',
        'PWD_RECEIVEDS' => PWD . '/receiveds',
        'HTTP_PWD_SOUND' => HTTP_PWD_ASSETS . '/sounds',
        'PWD_ADAPTERS' => PWD . '/adapters',
        'PWD_DATAS' => PWD . '/datas',
        'PWD_LOGS' => '/var/log/',
        'PWD_PID' => '/var/run/raspisms',
        'APP_SECRET' => 'retyuijokplmrtè34567890',

        //E-mail types
        'EMAIL_RESET_PASSWORD' => [
            'type' => 'email_reset_password',
            'subject' => 'Réinitialisation de votre mot de passe',
            'template' => 'email/reset-password',  
        ],
        'EMAIL_CREATE_USER' => [
            'type' => 'email_create_user',
            'subject' => 'Création de votre compte RaspiSMS',
            'template' => 'email/create-user',  
        ],
        'EMAIL_TRANSFER_SMS' => [
            'type' => 'email_transfer_sms',
            'subject' => 'Vous avez reçu un SMS',
            'template' => 'email/transfer-sms',  
        ],

        //Phone messages types
        'QUEUE_TYPE_SEND_MSG' => 1, 
        'QUEUE_TYPE_RECEIVE_MSG' => 2, 

        //Queues ids
        'QUEUE_ID_WEBHOOK' => 8265838073837783,
        'QUEUE_TYPE_WEBHOOK' => 3,

        //User default settings
        'USER_DEFAULT_SETTINGS' => [
            'detect_url' => 1,
            'sms_reception_sound' => 1,
            'transfer' => 0,
            'smsstop' => 1,
            'sms_flash' => 0,
            'templating' => 1,
            'display_help' => 1,
            'conditional_group' => 1,
            'webhook' => 1,
            'preferred_phone_country' => 'fr,be,ca',
            'default_phone_country' => 'fr',
            'authorized_phone_country' => 'fr,be,ca',
            'mms' => 0,
        ],
	];
