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

    'accepted' => 'يجب قبول  :attributes:.',
    'active_url' => ' :attributes: ليست عنوان URL صالحًا.',
    'after' => 'يجب أن تكون  :attributes تاريخًا بعد: التاريخ.',
    'after_or_equal' => 'يجب أن تكون  :attributes تاريخًا بعد: التاريخ أو مساويًا له.',
    'alpha' => 'لا يجوز أن تحتوي  :attributes: إلا على أحرف.',
    'alpha_dash' => 'لا يجوز أن تحتوي  :attributes: إلا على أحرف وأرقام وشرطات وشرطات سفلية.',
    'alpha_num' => 'لا يجوز أن تحتوي  :attributes: إلا على أحرف وأرقام.',
    'array' => 'يجب أن تكون  :attributes مصفوفة.',
    'before' => 'يجب أن تكون  :attributes تاريخًا قبل: التاريخ.',
    'before_or_equal' => 'يجب أن تكون  :attributes تاريخًا قبل: التاريخ أو مساويًا له.',
    'between' => [
        'numeric' => 'يجب أن تكون  :attributes: بين: min و: max.',
        'file' => 'يجب أن تكون  :attributes: بين: min و: max كيلوبايت.',
        'string' => 'يجب أن تكون  :attributes: بين: min و: max من الأحرف.',
        'array' => 'يجب أن تحتوي  :attributes: على ما بين: min و: max items.',
    ],
    'boolean' => 'يجب أن يكون حقل  :attributes صحيحًا أو خطأ.',
    'confirmed' => 'تأكيد  :attributes غير مطابق.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => ' :attributes: ليست تاريخًا صالحًا.',
    'date_equals' => 'يجب أن تكون  :attributes: تاريخ يساوي: date.',
    'date_format' => ' :attributes: لا تتوافق مع التنسيق: التنسيق.',
    'different' => 'يجب أن تكون  :attributes و: أخرى مختلفة.',
    'digits' => 'يجب أن تكون  :attributes: أرقام أرقام.',
    'digits_between' => 'يجب أن تكون  :attributes: بين: min و: max أرقام.',
    'dimensions' => ' :attributes لها أبعاد صورة غير صالحة.',
    'distinct' => 'يحتوي حقل  :attributes على قيمة مكررة.',
    'email' => 'يجب أن تكون  :attributes: عنوان بريد إلكتروني صالح.',
    'ends_with' => 'يجب أن تنتهي:  :attributes بأحد ما يلي: القيم.',
    'exists' => ' :attributes المحددة غير صالحة.',
    'file' => 'يجب أن تكون  :attributes: ملفًا.',
    'filled' => 'يجب أن يحتوي حقل  :attributes على قيمة.',
    'gt' => [
        'numeric' => 'يجب أن تكون  :attributes: أكبر من:  :value.',
        'file' => 'يجب أن تكون  :attributes: أكبر من:  :value كيلوبايت.',
        'string' => 'يجب أن تكون  :attributes: أكبر من: أحرف  :value.',
        'array' => 'يجب أن تحتوي  :attributes: على أكثر من: عناصر  :value.',
    ],
    'gte' => [
        'numeric' => 'يجب أن تكون  :attributes: أكبر من أو تساوي: value.',
        'file' => 'يجب أن تكون  :attributes: أكبر من أو تساوي:  :value كيلوبايت.',
        'string' => 'يجب أن تكون  :attributes: أكبر من أو تساوي: أحرف  :value.',
        'array' => 'يجب أن تحتوي  :attributes: على عناصر قيمة أو أكثر.',
    ],
    'image' => 'يجب أن تكون  :attributes صورة.',
    'in' => ' :attributes المحددة غير صالحة.',
    'in_array' => 'حقل  :attributes: غير موجود في: أخرى.',
    'integer' => 'يجب أن تكون  :attributes عددًا صحيحًا.',
    'ip' => 'يجب أن تكون  :attributes: عنوان IP صالحًا.',
    'ipv4' => 'يجب أن تكون  :attributes: عنوان IPv4 صالحًا.',
    'ipv6' => 'يجب أن تكون  :attributes: عنوان IPv6 صالحًا.',
    'json' => 'يجب أن تكون  :attributes: سلسلة JSON صالحة.',
    'lt' => [
        'numeric' => 'يجب أن تكون  :attributes: أقل من:  :value.',
        'file' => 'يجب أن تكون  :attributes: أقل من: value كيلوبايت.',
        'string' => 'يجب أن تكون  :attributes: أقل من: أحرف  :value.',
        'array' => 'يجب أن تحتوي  :attributes: على أقل من: عناصر  :value.',
    ],
    'lte' => [
        'numeric' => 'يجب أن تكون  :attributes: أقل من أو تساوي:  :value.',
        'file' => 'يجب أن تكون  :attributes: أقل من أو تساوي: value كيلوبايت.',
        'string' => 'يجب أن تكون  :attributes: أقل من أو تساوي: أحرف  :value.',
        'array' => 'يجب ألا تحتوي  :attributes: على أكثر من: عناصر  :value.',
    ],
    'max' => [
        'numeric' => 'لا يجوز أن تكون  :attributes: أكبر من: max.',
        'file' => 'لا يجوز أن تكون  :attributes: أكبر من: أقصى كيلوبايت.',
        'string' => 'لا يجوز أن تكون  :attributes: أكبر من: max حرفًا.',
        'array' => 'لا يجوز أن تحتوي  :attributes: على أكثر من: max items.',
    ],
    'mimes' => 'يجب أن تكون  :attributes: ملفًا من النوع: القيم.',
    'mimetypes' => 'يجب أن تكون  :attributes: ملفًا من النوع: القيم.',
    'min' => [
        'numeric' => 'يجب أن تكون  :attributes: min.',
        'file' => 'يجب ألا تقل  :attributes: عن :min كيلوبايت.',
        'string' => 'يجب ألا تقل  :attributes: عن: min حرفًا.',
        'array' => 'يجب أن تحتوي  :attributes: على الأقل على: min من العناصر.',
    ],
    'multiple_of' => 'يجب أن تكون  :attributes من مضاعفات  :value.',
    'not_in' => 'attributes: المحدد غير صالحة.',
    'not_regex' => 'تنسيق  :attributes غير صالح.',
    'numeric' => 'يجب أن تكون  :attributes رقمًا.',
    'password' => 'كلمة المرور غير صحيحة.',
    'present' => 'يجب أن يكون حقل  :attributes موجودًا.',
    'regex' => 'تنسيق  :attributes غير صالح.',
    'required' => ' حقل  :attributes مطلوب.',
    'required_if' => 'يكون حقل  :attributes مطلوبًا عندما: الآخر هو:  :value.',
    'required_unless' => 'حقل  :attributes: مطلوب إلا إذا كان الآخر في: القيم.',
    'required_with' => 'حقل  :attributes مطلوب عندما: القيم موجودة.',
    'required_with_all' => 'يكون حقل  :attributes مطلوبًا عندما تكون: القيم موجودة.',
    'required_without' => 'حقل  :attributes مطلوب عندما: القيم غير موجودة.',
    'required_without_all' => 'يكون حقل  :attributes مطلوبًا في حالة عدم وجود أي من قيم:.',
    'prohibited' => ': حقل  :attributes محظور.',
    'prohibited_if' => 'يُحظر حقل  :attributes عندما: الآخر هو  :value.',
    'prohibited_unless' => 'يُحظر حقل  :attributes ما لم الآخر في: القيم.',
    'same' => 'يجب أن تتطابق  :attributes: و: other.',
    'size' => [
        'numeric' => 'يجب أن تكون  :attributes: الحجم.',
        'file' => 'يجب أن تكون  :attributes: الحجم كيلوبايت.',
        'string' => 'يجب أن تكون  :attributes: حجم الأحرف.',
        'array' => 'يجب أن تحتوي  :attributes: على عناصر الحجم.',
    ],
    'starts_with' => 'يجب أن تبدأ  :attributes: بأحد القيم التالية:',
    'string' => 'يجب أن تكون  :attributes: سلسلة.',
    'timezone' => 'يجب أن تكون  :attributes: منطقة صالحة.',
    'unique' => 'تم بالفعل استخدام  :attributes.',
    'uploaded' => 'فشل تحميل  :attributes.',
    'url' => 'تنسيق  :attributes غير صالح.',
    'uuid' => 'يجب أن تكون  :attributes: UUID صالحًا.',

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
            'rule-name' => 'رسالة مخصصة',
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
