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

    'accepted' => 'Se debe aceptar el atributo :.',
    'active_url' => 'El  :attributes no es una URL válida.',
    'after' => 'El  :attributes debe ser una fecha posterior a: fecha.',
    'after_or_equal' => 'El  :attributes debe ser una fecha posterior o igual a: fecha.',
    'alpha' => 'El  :attributes solo puede contener letras.',
    'alpha_dash' => 'El  :attributes solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El  :attributes solo puede contener letras y números.',
    'array' => 'El  :attributes debe ser una matriz.',
    'before' => 'El  :attributes debe ser una fecha anterior a: fecha.',
    'before_or_equal' => 'El  :attributes debe ser una fecha anterior o igual a: fecha.',
    'between' => [
        'numeric' => 'El  :attributes debe estar entre:min y:max.',
        'file' => 'El  :attributes debe estar entre:min y:max kilobytes.',
        'string' => 'El  :attributes debe estar entre:min y:max caracteres.',
        'array' => 'El  :attributes debe tener entre:min y:max elementos.',
    ],
    'boolean' => 'El campo de  :attributes debe ser verdadero o falso.',
    'confirmed' => 'La confirmación del  :attributes no coincide.',
    'current_password' => 'La contraseña es incorrecta.',
    'date' => 'El  :attributes no es una fecha válida.',
    'date_equals' => 'El  :attributes debe ser una fecha igual a: fecha.',
    'date_format' => 'El  :attributes no coincide con el formato: formato.',
    'different' => 'El  :attributes y: otro deben ser diferentes.',
    'digits' => 'El  :attributes debe ser: dígitos dígitos.',
    'digits_between' => 'El  :attributes debe estar entre:min y:max dígitos.',
    'dimensions' => 'El  :attributes tiene dimensiones de imagen no válidas.',
    'distinct' => 'El campo de  :attributes tiene un valor duplicado.',
    'email' => 'El  :attributes debe ser una dirección de correo electrónico válida.',
    'ends_with' => 'El  :attributes debe terminar con uno de los siguientes valores::.',
    'exists' => 'El atributo seleccionado: no es válido.',
    'file' => 'El  :attributes debe ser un archivo.',
    'filled' => 'El campo de  :attributes debe tener un valor.',
    'gt' => [
        'numeric' => 'El  :attributes debe ser mayor que :value.',
        'file' => 'El  :attributes debe ser mayor que :value kilobytes.',
        'string' => 'El  :attributes debe ser mayor que los caracteres de valor.',
        'array' => 'El  :attributes debe tener más de: elementos de valor.',
    ],
    'gte' => [
        'numeric' => 'El  :attributes debe ser mayor o igual que :value.',
        'file' => 'El  :attributes debe ser mayor o igual que :value kilobytes.',
        'string' => 'El  :attributes debe ser mayor o igual que los caracteres de valor.',
        'array' => 'El  :attributes debe tener: elementos de valor o más.',
    ],
    'image' => 'El  :attributes debe ser una imagen.',
    'in' => 'El atributo seleccionado: no es válido.',
    'in_array' => 'El campo de  :attributes no existe en: otro.',
    'integer' => 'El  :attributes debe ser un entero.',
    'ip' => 'El  :attributes debe ser una dirección IP válida.',
    'ipv4' => 'El  :attributes debe ser una dirección IPv4 válida.',
    'ipv6' => 'El  :attributes debe ser una dirección IPv6 válida.',
    'json' => 'El  :attributes debe ser una cadena JSON válida.',
    'lt' => [
        'numeric' => 'El  :attributes debe ser menor que :value.',
        'file' => 'El  :attributes debe ser menor que :value kilobytes.',
        'string' => 'El  :attributes debe tener menos de :valuees de caracteres.',
        'array' => 'El  :attributes debe tener menos de: elementos de valor.',
    ],
    'lte' => [
        'numeric' => 'El  :attributes debe ser menor o igual que :value.',
        'file' => 'El  :attributes debe ser menor o igual que :value kilobytes.',
        'string' => 'El  :attributes debe ser menor o igual que los caracteres de valor.',
        'array' => 'El  :attributes no debe tener más de: elementos de valor.',
    ],
    'max' => [
        'numeric' => 'El  :attributes no puede ser mayor que: máx.',
        'file' => 'El  :attributes no puede ser mayor que: kilobytes máximos.',
        'string' => 'El  :attributes no puede ser mayor que: máximo de caracteres.',
        'array' => 'El  :attributes no puede tener más de: elementos máximos.',
    ],
    'mimes' => 'El  :attributes debe ser un archivo de tipo: :valuees.',
    'mimetypes' => 'El  :attributes debe ser un archivo de tipo: :valuees.',
    'min' => [
        'numeric' => 'El  :attributes debe ser al menos:min.',
        'file' => 'El  :attributes debe ser al menos:min kilobytes.',
        'string' => 'El  :attributes debe tener al menos:min caracteres.',
        'array' => 'El  :attributes debe tener al menos: elementos mínimos.',
    ],
    'multiple_of' => 'El  :attributes debe ser un múltiplo de :value.',
    'not_in' => 'El atributo seleccionado: no es válido.',
    'not_regex' => 'El formato del atributo no es válido.',
    'numeric' => 'El  :attributes debe ser un número.',
    'password' => 'La contraseña es incorrecta.',
    'present' => 'El campo de  :attributes debe estar presente.',
    'regex' => 'El formato del atributo no es válido.',
    'required' => 'El campo de  :attributes es obligatorio.',
    'required_if' => 'El campo de  :attributes es obligatorio cuando: otro es :value.',
    'required_unless' => 'El campo  :attributes es obligatorio a menos que: otro esté en :valuees.',
    'required_with' => 'El campo  :attributes es obligatorio cuando :valuees están presentes.',
    'required_with_all' => 'El campo  :attributes es obligatorio cuando: los valores están presentes.',
    'required_without' => 'El campo  :attributes es obligatorio cuando: los valores no están presentes.',
    'required_without_all' => 'El campo de  :attributes es obligatorio cuando ninguno de los valores: está presente.',
    'prohibited' => 'El campo de  :attributes está prohibido.',
    'prohibited_if' => 'El campo de  :attributes está prohibido cuando: otro es :value.',
    'prohibited_unless' => 'El campo de  :attributes está prohibido a menos que: otro esté en :valuees.',
    'same' => 'El  :attributes y: otro deben coincidir.',
    'size' => [
        'numeric' => 'El  :attributes debe ser: tamaño.',
        'file' => 'El  :attributes debe ser: tamaño kilobytes.',
        'string' => 'El  :attributes debe tener: caracteres de tamaño.',
        'array' => 'El  :attributes debe contener: artículos de tamaño.',
    ],
    'starts_with' => 'El  :attributes debe comenzar con uno de los siguientes valores::',
    'string' => 'El  :attributes debe ser una cadena.',
    'timezone' => 'El  :attributes debe ser una zona válida.',
    'unique' => 'El  :attributes ya se ha tomado.',
    'uploaded' => 'El  :attributes no se pudo cargar.',
    'url' => 'El formato del atributo no es válido.',
    'uuid' => 'El  :attributes debe ser un UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'mensaje personalizado',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
