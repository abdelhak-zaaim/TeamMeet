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

    'accepted' => 'O :attribute deve ser aceito.',
    'active_url' => 'O :atribute não é um URL válido.',
    'after' => 'O :attribute deve ser uma data após :date.',
    'after_or_equal' => 'O :attribute deve ser uma data posterior ou igual a :date.',
    'alpha' => 'O :attribute só pode conter letras.',
    'alpha_dash' => 'O :attribute só pode conter letras, números, travessões e sublinhados.',
    'alpha_num' => 'O :attribute só pode conter letras e números.',
    'array' => 'O :attribute deve ser uma matriz.',
    'before' => 'O :attribute deve ser uma data anterior a :date.',
    'before_or_equal' => 'O :attribute deve ser uma data anterior ou igual a :date.',
    'between' => [
        'numeric' => 'O :attribute deve estar entre  :min e :max.',
        'file' => 'O :attribute deve estar entre  :min e  :max kilobytes.',
        'string' => 'O :attribute deve ter entre  :min e  :max caracteres.',
        'array' => 'O :atribute deve ter entre  :min e  :max itens.',
    ],
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed' => 'A confirmação de :attribute não corresponde.',
    'current_password' => 'A senha está incorreta.',
    'date' => 'O :atribute não é uma data válida.',
    'date_equals' => 'O :attribute deve ser uma data igual a :date.',
    'date_format' => 'O :attribute não corresponde ao formato: format.',
    'different' => 'O :attribute e :other devem ser diferentes.',
    'digits' => 'O :attribute deve ser: dígitos dígitos.',
    'digits_between' => 'O :attribute deve ter entre  :min e  :max dígitos.',
    'dimensions' => 'O :attribute tem dimensões de imagem inválidas.',
    'distinct' => 'O campo :attribute tem um valor duplicado.',
    'email' => 'O :attribute deve ser um endereço de e-mail válido.',
    'ends_with' => 'O :attribute deve terminar com um dos seguintes:: valores.',
    'exists' => 'O atributo selecionado: é inválido.',
    'file' => 'O :atribute deve ser um arquivo.',
    'filled' => 'O campo :attribute deve ter um valor.',
    'gt' => [
        'numeric' => 'O :attribute deve ser maior que :value.',
        'file' => 'O :attribute deve ser maior que :value kilobytes.',
        'string' => 'O :atribute deve ser maior que: caracteres de valor.',
        'array' => 'O :attribute deve ter mais de: itens de valor.',
    ],
    'gte' => [
        'numeric' => 'O :attribute deve ser maior ou igual :value.',
        'file' => 'O :attribute deve ser maior ou igual :value kilobytes.',
        'string' => 'O :attribute deve ser maior ou igual a caracteres de valor.',
        'array' => 'O :attribute deve ter: itens de valor ou mais.',
    ],
    'image' => 'O :attribute deve ser uma imagem.',
    'in' => 'O atributo selecionado: é inválido.',
    'in_array' => 'O campo :attribute não existe em :other.',
    'integer' => 'O :attribute deve ser um número inteiro.',
    'ip' => 'O :attribute deve ser um endereço IP válido.',
    'ipv4' => 'O :attribute deve ser um endereço IPv4 válido.',
    'ipv6' => 'O :atribute deve ser um endereço IPv6 válido.',
    'json' => 'O :attribute deve ser uma string JSON válida.',
    'lt' => [
        'numeric' => 'O :attribute deve ser menor que :value.',
        'file' => 'O :attribute deve ser menor que :value kilobytes.',
        'string' => 'O :attribute deve ter menos que: caracteres de valor.',
        'array' => 'O :attribute deve ter menos que: itens de valor.',
    ],
    'lte' => [
        'numeric' => 'O :attribute deve ser menor ou igual :value.',
        'file' => 'O :atribute deve ser menor ou igual a: kilobytes de valor.',
        'string' => 'O :atribute deve ser menor ou igual a: caracteres de valor.',
        'array' => 'O :attribute não deve ter mais do que: itens de valor.',
    ],
    'max' => [
        'numeric' => 'O :atribute não pode ser maior que: máx.',
        'file' => 'O :attribute não pode ser maior que  :max kilobytes.',
        'string' => 'O :attribute não pode ser maior que  :max caracteres.',
        'array' => 'O :attribute não pode ter mais do que  :max itens.',
    ],
    'mimes' => 'O :attribute deve ser um arquivo do tipo:  :attribute.',
    'mimetypes' => 'O :atribute deve ser um arquivo do tipo:  :attribute.',
    'min' => [
        'numeric' => 'O :attribute deve ser pelo menos  :min.',
        'file' => 'O :attribute deve ter pelo menos  :min kilobytes.',
        'string' => 'O :attribute deve ter pelo menos  :min caracteres.',
        'array' => 'O :attribute deve ter pelo menos  :min itens.',
    ],
    'multiple_of' => 'O :attribute deve ser um múltiplo de :value.',
    'not_in' => 'O atributo selecionado: é inválido.',
    'not_regex' => 'O formato do atributo é inválido.',
    'numeric' => 'O :atribute deve ser um número.',
    'password' => 'A senha está incorreta.',
    'present' => 'O campo :attribute deve estar presente.',
    'regex' => 'O formato do atributo é inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_if' => 'O campo :attribute é obrigatório quando :other for :value.',
    'required_unless' => 'O campo :attribute é obrigatório, a menos que :other esteja em  :attribute.',
    'required_with' => 'O campo :attribute é obrigatório quando  :attribute estiver presente.',
    'required_with_all' => 'O campo :attribute é obrigatório quando: valores estão presentes.',
    'required_without' => 'O campo :attribute é obrigatório quando  :attribute não estiver presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos valores: está presente.',
    'prohibited' => 'O campo :attribute é proibido.',
    'prohibited_if' => 'O campo :attribute é proibido quando :other for :value.',
    'prohibited_unless' => 'O campo :attribute é proibido, a menos que :other esteja em  :attribute.',
    'same' => 'O :attribute e :other devem corresponder.',
    'size' => [
        'numeric' => 'O :atribute deve ser :size.',
        'file' => 'O :attribute deve ter :size kilobytes.',
        'string' => 'O :attribute deve ter: caracteres de tamanho.',
        'array' => 'O :attribute deve conter: itens de tamanho.',
    ],
    'starts_with' => 'O :atribute deve começar com um dos seguintes:  :attribute',
    'string' => 'O :attribute deve ser uma string.',
    'timezone' => 'O :atribute deve ser uma zona válida.',
    'unique' => 'O :atribute já foi utilizado.',
    'uploaded' => 'O :attribute falhou ao carregar.',
    'url' => 'O formato do atributo é inválido.',
    'uuid' => 'O :attribute deve ser um UUID válido.',

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
            'rule-name' => 'mensagem personalizada',
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
