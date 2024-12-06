<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the 尺寸  rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ' :attributes  必須被接受。',
    'active_url' => ' :attributes  不是有效的URL。',
    'after' => ' :attributes  必須是：日期  之後的日期。',
    'after_or_equal' => ' :attributes  必須是等於或小於：日期 的日期。',
    'alpha' => ' :attributes  只能包含字母。',
    'alpha_dash' => ' :attributes  只能包含字母，數字，破折號和下劃線。',
    'alpha_num' => ' :attributes  只能包含字母和數字。',
    'array' => ' :attributes  必須是一個數組。',
    'before' => ' :attributes  必須是：日期  之前的日期。',
    'before_or_equal' => ' :attributes  必須是等於或小於：日期  的日期。',
    'between' => [
        'numeric' => ' :attributes  必須介於：分钟 和：最大限度之間。',
        'file' => ' :attributes  必須介於：分钟 和：最大限度千字節之間。',
        'string' => ' :attributes 必須介於：分钟 和：最大限度之間。',
        'array' => ' :attributes 必須在：分钟 和：最大限度之間。',
    ],
    'boolean' => ' :attributes 字段必須為true或false。',
    'confirmed' => ' :attributes 確認不匹配。',
    'current_password' => '密码不正确。',
    '日期 ' => ' :attributes 不是有效日期。',
    '日期 _equals' => ' :attributes 必須是等於：日期 的日期。',
    '日期 _format' => ' :attributes 與格式：format不匹配。',
    'different' => ' :attributes 和：others 必須不同。',
    'digits' => ' :attributes 必須為：digits位數。',
    'digits_between' => ' :attributes 必須介於：分钟 和：最大限度數字之間。',
    'dimensions' => ' :attributes 的圖片尺寸無效。',
    'distinct' => ' :attributes 字段具有重複值。',
    'email' => ' :attributes 必須是有效的電子郵件地址。',
    'ends_with' => ' :attributes 必須以下列之一結尾：：价值观 ',
    'exists' => '所選的 :attributes 無效。',
    'file' => ' :attributes 必須是一個文件。',
    'filled' => ' :attributes 字段必須有一個值。',
    'gt' => [
        'numeric' => ' :attributes 必須大於：价值 。',
        'file' => ' :attributes 必須大於：价值 千字節。',
        'string' => ' :attributes 必須大於：价值 字符。',
        'array' => ' :attributes 必須包含多個：价值 項目。',
    ],
    'gte' => [
        'numeric' => 'a :attributes 必須大於或等於：价值 。',
        'file' => ' :attributes 必須大於或等於：价值 千字節。',
        'string' => ' :attributes 必須大於或等於：价值 字符。',
        'array' => ' :attributes 必須具有：价值 項或更多。',
    ],
    'image' => ' :attributes 必須是圖像。',
    'in' => '所選的 :attributes 無效。',
    'in_array' => ' :attributes 字段在：others 中不存在。',
    'integer' => ' :attributes 必須為整數。',
    'ip' => ' :attributes 必須是有效的IP地址。',
    'ipv4' => ' :attributes 必須是有效的IPv4地址。',
    'ipv6' => ' :attributes 必須是有效的IPv6地址。',
    'json' => ' :attributes 必須是有效的JSON字符串。',
    'lt' => [
        'numeric' => ' :attributes 必須小於：价值 。',
        'file' => ' :attributes 必須小於：价值 千字節。',
        'string' => ' :attributes 必須小於：价值 字符。',
        'array' => ' :attributes 必須少於：价值 個項目。',
    ],
    'lte' => [
        'numeric' => ' :attributes 必須小於或等於：价值 。',
        'file' => ' :attributes 必須小於或等於：价值 千字節。',
        'string' => ' :attributes 必須小於或等於：价值 字符。',
        'array' => ' :attributes 不得超過：价值 個項目。',
    ],
    '最大限度' => [
        'numeric' => ' :attributes 不得大於：最大限度。',
        'file' => ' :attributes 不得大於：最大限度千字節。',
        'string' => ' :attributes 不得大於：最大限度個字符。',
        'array' => ' :attributes 最多只能包含：最大限度個項目。',
    ],
    'mimes' => ' :attributes 必須是類型：：价值观 的文件。',
    'mimetypes' => ' :attributes 必須是類型：：价值观 的文件。',
    '分钟 ' => [
        'numeric' => ' :attributes 必須至少為：分钟 。',
        'file' => ' :attributes 必須至少為：分钟 千字節。',
        'string' => ' :attributes 必須至少為：分钟 個字符。',
        'array' => ' :attributes 必須至少包含：分钟 個項目。',
    ],
    'multiple_of' => ' :attributes  必须是 :价值  的倍数。',
    'not_in' => '所選的 :attributes 無效。',
    'not_regex' => ' :attributes 格式無效。',
    'numeric' => ' :attributes 必須為數字。',
    'password' => '密码不正确。',
    'present' => ' :attributes 字段必須存在。',
    'regex' => ' :attributes 格式無效。',
    'required' => ' :attributes 字段是必需的。',
    'required_if' => '當：others 是：价值 時， :attributes 字段是必需的。',
    'required_unless' => '除非：others 位於：价值观 中，否則 :attributes 字段是必填字段。',
    'required_with' => '如果存在：价值观 ，則 :attributes 字段為必填字段。',
    'required_with_all' => '如果存在：价值观 ，則 :attributes 字段是必需的。',
    'required_without' => '當：价值观 不存在時， :attributes 字段是必需的。',
    'required_without_all' => '當：价值观 不存在時， :attributes 字段是必需的。',
    'prohibited' => '禁止  :attributes  字段。',
    'prohibited_if' => '当 :others  为 :价值  时，禁止  :attributes 字段。',
    'prohibited_unless' => '禁止  :attributes 字段，除非 :others  在 :价值观  中。',
    'same' => ' :attributes 和：others 必須匹配。',
    '尺寸 ' => [
        'numeric' => ' :attributes 必須為：尺寸 。',
        'file' => ' :attributes 必須為：尺寸 千字節。',
        'string' => ' :attributes 必須為：尺寸 字符。',
        'array' => ' :attributes 必須包含：尺寸 項。',
    ],
    'starts_with' => ' :attributes 必須以下列之一開頭：：价值观 ',
    'string' => ' :attributes 必須為字符串。',
    'timezone' => ' :attributes 必須是有效的區域。',
    'unique' => ' :attributes 已經被使用。',
    'uploaded' => ' :attributes 上傳失敗。',
    'url' => ' :attributes 格式無效。',
    'uuid' => ' :attributes 必須是有效的UUID。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for  attributes s using the
    | convention " attributes .rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given  attributes  rule.
    |
    */

    'custom' => [
        ' attributes -name' => [
            'rule-name' => '自定義消息',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our  attributes  placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    ' attributes s' => [],

];
