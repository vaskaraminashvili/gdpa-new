<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Locales
    |--------------------------------------------------------------------------
    |
    | Contains an array with the applications available locales.
    |
    */
    'locales' => [
        'ka',
        'en',
    ],

    /*
    |--------------------------------------------------------------------------
    | Locale Separator
    |--------------------------------------------------------------------------
    |
    | This is a string used to glue the language and the country when defining
    | the available locales. Example: if set to '-', then the locale for
    | colombian spanish will be 'es-CO'.
    |
    */
    'locale_separator' => '-',

    /*
    |--------------------------------------------------------------------------
    | Default locale
    |--------------------------------------------------------------------------
    |
    | As a default locale, Translatable takes the application fallback locale.
    | However, sometimes you may want to have a different fallback locale
    | for your translatable models. Here you may change that.
    |
    */
    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Translation Suffix
    |--------------------------------------------------------------------------
    |
    | Defines the default 'Translation' suffix for the models Translations.
    | So if you have for example a News model, its corresponding
    | Translation class will be NewsTranslation.
    |
    */
    'translation_suffix' => 'Translation',

    /*
    |--------------------------------------------------------------------------
    | Locale key
    |--------------------------------------------------------------------------
    |
    | Defines the 'locale' field name, which is used by Translatable to
    | determine the Translation language.
    |
    */
    'locale_key' => 'locale',

    /*
    |--------------------------------------------------------------------------
    | Always load translations
    |--------------------------------------------------------------------------
    |
    | Always load translations when retrieving translatable models.
    |
    */
    'always_load_translations' => true,

    /*
    |--------------------------------------------------------------------------
    | Load empty translations
    |--------------------------------------------------------------------------
    |
    | Loads empty translations when retrieving translatable models.
    |
    */
    'load_empty_translations' => false,

    /*
    |--------------------------------------------------------------------------
    | Translation Model Namespace
    |--------------------------------------------------------------------------
    |
    | Defines the default 'Translation' model namespace.
    |
    */
    'translation_model_namespace' => null,

    /*
    |--------------------------------------------------------------------------
    | Translation Model Path
    |--------------------------------------------------------------------------
    |
    | Defines the default 'Translation' model path.
    |
    */
    'translation_model_path' => null,

    /*
    |--------------------------------------------------------------------------
    | Auto translation of translatable fields
    |--------------------------------------------------------------------------
    |
    | Enables/disables the auto translation of translatable fields.
    |
    */
    'auto_translate_translatable_fields' => false,
]; 