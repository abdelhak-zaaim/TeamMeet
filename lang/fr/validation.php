<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ' :attribute doit être accepté.',
    'active_url' => ' :attribute n\'est pas une URL valide.',
    'after' => ' :attribute doit être une date postérieure à: date.',
    'after_or_equal' => ' :attribute doit être une date postérieure ou égale à: date.',
    'alpha' => ' :attribute ne peut contenir que des lettres.',
    'alpha_dash' => ' :attribute ne peut contenir que des lettres, des chiffres, des tirets et des traits de soulignement.',
    'alpha_num' => ' :attribute ne peut contenir que des lettres et des chiffres.',
    'array' => ' :attribute doit être un tableau.',
    'before' => ' :attribute doit être une date antérieure à: date.',
    'before_or_equal' => ' :attribute doit être une date antérieure ou égale à: date.',
    'between' => [
        'numeric' => ' :attribute doit être compris entre:max et:max.',
        'file' => ' :attribute doit être compris entre:max et:max kilo-octets.',
        'string' => ' :attribute doit être compris entre:max et:max caractères.',
        'array' => ' :attribute doit avoir entre:max et:max éléments.',
    ],
    'boolean' => 'Le champ  :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation    :attributee ne correspond pas.',
    'current_password' => 'Le mot de passe est incorrect.',
    'date' => ' :attribute n\'est pas une date valide.',
    'date_equals' => ' :attribute doit être une date égale à: date.',
    'date_format' => ' :attribute ne correspond pas au format: format.',
    'different' => 'Les  :attribute et: autre doivent être différents.',
    'digits' => ' :attribute doit être: chiffres chiffres.',
    'digits_between' => ' :attribute doit être compris entre:max et:max chiffres.',
    'dimensions' => ' :attribute a des dimensions d\'image non valides.',
    'distinct' => 'Le champ  :attribute a une valeur en double.',
    'email' => ' :attribute doit être une adresse e-mail valide.',
    'ends_with' => 'Le  :attribute doit se terminer par l\'un des éléments suivants : :values.',
    'exists' => 'L\'attribute selected: n\'est pas valide.',
    'file' => ' :attribute doit être un fichier.',
    'filled' => 'Le champ  :attribute doit avoir une valeur.',
    'gt' => [
        'numeric' => ' :attribute doit être supérieur à:value.',
        'file' => ' :attribute doit être supérieur à: valeur kilo-octets.',
        'string' => ' :attribute doit être supérieur à: valeur caractères.',
        'array' => ' :attribute doit avoir plus de: éléments de valeur.',
    ],
    'gte' => [
        'numeric' => ' :attribute doit être supérieur ou égal à:value.',
        'file' => ' :attribute doit être supérieur ou égal à:value kilo-octets.',
        'string' => ' :attribute doit être supérieur ou égal à: valeur caractères.',
        'array' => ' :attribute doit avoir: éléments de valeur ou plus.',
    ],
    'image' => ' :attribute doit être une image.',
    'in' => 'L\'attribute selected: n\'est pas valide.',
    'in_array' => 'L\e champ  :attribute n\'existe pas dans: autre.',
    'integer' => ' :attribute doit être un entier.',
    'ip' => ' :attribute doit être une adresse IP valide.',
    'ipv4' => ' :attribute doit être une adresse IPv4 valide.',
    'ipv6' => ' :attribute doit être une adresse IPv6 valide.',
    'json' => ' :attribute doit être une chaîne JSON valide.',
    'lt' => [
        'numeric' => ' :attribute doit être inférieur à:value.',
        'file' => ' :attribute doit être inférieur à: valeur kilo-octets.',
        'string' => ' :attribute doit être inférieur à: valeur caractères.',
        'array' => ' :attribute doit avoir moins de: éléments de valeur.',
    ],
    'lte' => [
        'numeric' => ' :attribute doit être inférieur ou égal à:value.',
        'file' => ' :attribute doit être inférieur ou égal à:value kilo-octets.',
        'string' => ' :attribute doit être inférieur ou égal à: valeur caractères.',
        'array' => ' :attribute ne doit pas avoir plus de: éléments de valeur.',
    ],
    'max' => [
        'numeric' => ' :attribute ne doit pas être supérieur à:max.',
        'file' => ' :attribute ne peut pas être supérieur à:max kilo-octets.',
        'string' => ' :attribute ne peut pas être supérieur à:max caractères.',
        'array' => ' :attribute ne peut pas avoir plus de:max éléments.',
    ],
    'mimes' => ' :attribute doit être un fichier de type:: valeurs.',
    'mimetypes' => ' :attribute doit être un fichier de type:: valeurs.',
    'min' => [
        'numeric' => ' :attribute doit être au moins:max.',
        'file' => ' :attribute doit être d\'au moins:max kilo-octets.',
        'string' => ' :attribute doit contenir au moins:max caractères.',
        'array' => ' :attribute doit avoir au moins: éléments min.',
    ],
    'multiple_of' => 'Le  :attribute doit être un multiple de :value.',
    'not_in' => 'L\'attribute selected: n\'est pas valide.',
    'not_regex' => 'Le format    :attributee n\'est pas valide.',
    'numeric' => ' :attribute doit être un nombre.',
    'password' => 'Le mot de passe est incorrect.',
    'present' => 'Le champ  :attribute doit être présent.',
    'regex' => 'Le format    :attributee n\'est pas valide.',
    'required' => 'Le champ  :attribute est obligatoire.',
    'required_if' => 'Le champ  :attribute est obligatoire lorsque: autre est: valeur.',
    'required_unless' => 'Le champ  :attribute est obligatoire sauf si: autre est dans: valeurs.',
    'required_with' => 'Le champ  :attributee est obligatoire lorsque:values est présent.',
    'required_with_all' => 'Le champ  :attributee est obligatoire lorsque: des valeurs sont présentes.',
    'required_without' => 'Le champ  :attributee est obligatoire lorsque:values n\'est pas présent.',
    'required_without_all' => 'Le champ  :attributee est obligatoire lorsqu\'aucune des valeurs: n\'est présente.',
    'prohibited' => 'Le champ  :attribute est interdit.',
    'prohibited_if' => 'Le champ  :attribute est interdit lorsque :other vaut :value.',
    'prohibited_unless' => 'Le champ  :attribute est interdit sauf si :other est dans :values.',
    'same' => 'Les  :attributes et: other doivent correspondre.',
    'size' => [
        'numeric' => ' :attribute doit être: size.',
        'file' => ' :attribute doit être: size kilo-octets.',
        'string' => ' :attribute doit être: size caractères.',
        'array' => ' :attribute doit contenir des éléments: size.',
    ],
    'starts_with' => ' :attribute doit commencer par l\'un des éléments suivants:: valeurs',
    'string' => ' :attribute doit être une chaîne.',
    'timezone' => ' :attribute doit être une zone valide.',
    'unique' => ' :attribute a déjà été pris.',
    'uploaded' => ' :attribute n\'a pas pu être téléchargé.',
    'url' => 'L\e format    :attributee n\'est pas valide.',
    'uuid' => ' :attribute doit être un UUID valide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributees using the
    | convention "attributee.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attributee rule.
    |
    */

    'custom' => [
        'attributee-name' => [
            'rule-name' => 'message personnalisé',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attributee placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributees' => [],

];
