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

    'accepted' => ':attribute должен быть принят.',
    'active_url' => ':attribute не является допустимым URL.',
    'after' => ':attribute должен быть датой после:date.',
    'after_or_equal' => ':attribute должен быть датой после или равной дате.',
    'alpha' => ':attribute может содержать только буквы.',
    'alpha_dash' => ':attribute может содержать только буквы, цифры, тире и подчеркивания.',
    'alpha_num' => ':attribute может содержать только буквы и цифры.',
    'array' => ':attribute должен быть массивом.',
    'before' => ':attribute должен быть датой перед:date.',
    'before_or_equal' => ':attribute должен быть датой до или равной дате.',
    'between' => [
        'numeric' => ':attribute должен находиться в диапазоне от:min до:max.',
        'file' => ':attribute должен находиться в диапазоне от:min до:max килобайт.',
        'string' => ':attribute должен содержать символы:min и:max.',
        'array' => ':attribute должен содержать от:min до:max элементов.',
    ],
    'boolean' => 'Поле:attribute должно быть истинным или ложным.',
    'confirmed' => 'Подтверждение:attribute не совпадает.',
    'current_password' => 'Пароль неверен.',
    'date' => ':attribute не является допустимой датой.',
    'date_equals' => ':attribute должен быть датой, равной:date.',
    'date_format' => ':attribute не соответствует формату:формат.',
    'different' => ':attribute и: другое должны быть разными.',
    'digits' => ':attribute должен быть:digits цифры.',
    'digits_between' => ':attribute должен быть между:min и:max цифрами.',
    'dimensions' => ':attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Поле:attribute имеет повторяющееся значение.',
    'email' => ':attribute должен быть действующим адресом электронной почты.',
    'ends_with' => ':attribute должен заканчиваться одним из следующих::values.',
    'exists' => 'attribute selected: недействителен.',
    'file' => ':attribute должен быть файлом.',
    'filled' => 'Поле:attribute должно иметь значение.',
    'gt' => [
        'numeric' => ':attribute должен быть больше, чем: значение.',
        'file' => ':attribute должен быть больше: value в килобайтах.',
        'string' => ':attribute должен быть больше, чем: значение символов.',
        'array' => ':attribute должен содержать более:values.',
    ],
    'gte' => [
        'numeric' => ':attribute должен быть больше или равен: value.',
        'file' => ':attribute должен быть больше или равен: значение в килобайтах.',
        'string' => ':attribute должен быть больше или равен символу: значение.',
        'array' => ':attribute должен иметь элементы: value или больше.',
    ],
    'image' => ':attribute должен быть изображением.',
    'in' => 'attribute selected: недействителен.',
    'in_array' => 'Поле:attribute не существует в:other :values.',
    'integer' => ':attribute должен быть целым числом.',
    'ip' => ':attribute должен быть действительным IP-адресом.',
    'ipv4' => ':attribute должен быть действительным IPv4-адресом.',
    'ipv6' => ':attribute должен быть действительным адресом IPv6.',
    'json' => ':attribute должен быть допустимой строкой JSON.',
    'lt' => [
        'numeric' => ':attribute должен быть меньше: значения.',
        'file' => ':attribute должен быть меньше: value килобайт.',
        'string' => ':attribute должен содержать меньше символов: value.',
        'array' => ':attribute должен содержать меньше:values элементов.',
    ],
    'lte' => [
        'numeric' => ':attribute должен быть меньше или равен: value.',
        'file' => ':attribute должен быть меньше или равен: значение в килобайтах.',
        'string' => ':attribute должен быть меньше или равен символу: значение.',
        'array' => ':attribute не может содержать более:values элементов.',
    ],
    'max' => [
        'numeric' => ':attribute не может быть больше, чем: макс.',
        'file' => ':attribute не может быть больше:max килобайт.',
        'string' => ':attribute не может содержать больше символов:max.',
        'array' => ':attribute не может содержать более:max элементов.',
    ],
    'mimes' => ':attribute должен быть файлом типа::values.',
    'mimetypes' => ':attribute должен быть файлом типа::values.',
    'min' => [
        'numeric' => ':attribute должен быть не меньше: мин.',
        'file' => ':attribute должен быть не меньше:min килобайт.',
        'string' => ':attribute должен содержать не менее:min символов.',
        'array' => ':attribute должен содержать как минимум:min элементов.',
    ],
    'multiple_of' => ':attribute должен быть кратным: value.',
    'not_in' => 'attribute selected: недействителен.',
    'not_regex' => 'Формат:attribute недействителен.',
    'numeric' => ':attribute должен быть числом.',
    'password' => 'Пароль неверен.',
    'present' => 'Поле:attribute должно присутствовать.',
    'regex' => 'Формат attribute: неверен.',
    'required' => 'Поле:attribute обязательно для заполнения.',
    'required_if' => 'Поле:attribute необходимо, когда:other :values: значение.',
    'required_unless' => 'Поле: attribute является обязательным, если:other :values не находится в:values.',
    'required_with' => 'Поле:attribute требуется, если присутствует:values.',
    'required_with_all' => 'Поле:attribute необходимо, когда присутствуют: значения.',
    'required_without' => 'Поле:attribute является обязательным, если:values отсутствует.',
    'required_without_all' => 'Поле:attribute является обязательным, если нет ни одного из:values.',
    'prohibited' => 'Поле:attribute запрещено. ',
    'prohibited_if' => 'Поле:attribute запрещено, когда:other :values равно: value. ',
    'prohibited_unless' => 'Поле:attribute запрещено, если:other :values не находится в:values. ',
    'same' => ':attribute и: другое должны совпадать.',
    'size' => [
        'numeric' => ':attribute должен быть размером :size.',
        'file' => ':attribute должен быть размером в килобайтах.',
        'string' => ':attribute должен содержать символы :size.',
        'array' => ':attribute должен содержать элементы :size.',
    ],
    'starts_with' => ':attribute должен начинаться с одного из следующих значений::',
    'string' => ':attribute должен быть строкой.',
    'timezone' => ':attribute должен быть допустимой зоной.',
    'unique' => ':attribute уже был занят.',
    'uploaded' => ':attribute не удалось загрузить.',
    'url' => 'Формат :attribute неверен.',
    'uuid' => ':attribute должен быть действительным UUID.',

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
            'rule-name' => 'на заказ сообщения',
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
