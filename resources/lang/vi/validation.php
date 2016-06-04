<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute phải được chấp thuận.',
    'active_url'           => ':attribute phải là URL hợp lệ.',
    'after'                => ':attribute phải là ngày ở sau ngày :date.',
    'alpha'                => ':attribute chỉ được gồm các chữ cái.',
    'alpha_dash'           => ':attribute chỉ được gồm chữ cái, chữ số và các dấu gạch ngang.',
    'alpha_num'            => ':attribute chỉ được gồm chữ cái và chữ số.',
    'array'                => ':attribute phải là một mảng.',
    'before'               => ':attribute phải là ngày ở trước ngày :date.',
    'between'              => [
        'numeric' => ':attribute phải nằm giữa :min and :max.',
        'file'    => ':attribute phải có dung lượng nằm giữa :min và :max KB.',
        'string'  => ':attribute phải có số ký tự nằm giữa :min và :max.',
        'array'   => ':attribute phải có số lượng phần tử nằm giữa :min và :max.',
    ],
    'boolean'              => ':attribute phải có giá trị đúng hoặc sai.',
    'confirmed'            => ':attribute xác nhận không khớp.',
    'date'                 => ':attribute không phải là ngày hợp lệ.',
    'date_format'          => ':attribute không đúng với định dạng :format.',
    'different'            => ':attribute và :other phải khác nhau.',
    'digits'               => ':attribute phải là số có độ dài là :digits.',
    'digits_between'       => ':attribute phải là số nằm giữa :min và :max.',
    'email'                => ':attribute phải là địa chỉ thư điện tử hợp lệ.',
    'exists'               => ':attribute đã chọn không hợp lệ.',
    'filled'               => ':attribute không được để trống.',
    'image'                => ':attribute phải là ảnh.',
    'in'                   => ':attribute đã chọn không hợp lệ.',
    'integer'              => ':attribute phải là số nguyên.',
    'ip'                   => ':attribute phải là địa chỉ IP hợp lệ.',
    'json'                 => ':attribute phải là chuỗi JSON hợp lệ.',
    'max'                  => [
        'numeric' => ':attribute không được lớn hơn :max.',
        'file'    => ':attribute có dung lượng lớn nhất là :max KB.',
        'string'  => ':attribute có số ký tự lớn nhất là :max.',
        'array'   => ':attribute có số lượng lớn nhất là :max.',
    ],
    'mimes'                => ':attribute phải là tập tin định dạng: :values.',
    'min'                  => [
        'numeric' => ':attribute không được nhỏ hơn :min.',
        'file'    => ':attribute có dung lượng ít nhất là :min KB.',
        'string'  => ':attribute có số ký tự ít nhất là :min.',
        'array'   => ':attribute có số lượng ít nhất là :min items.',
    ],
    'not_in'               => ':attribute đã chọn không hợp lệ.',
    'numeric'              => ':attribute phải là một số.',
    'regex'                => ':attribute không đúng định dạng.',
    'required'             => ':attribute không được để trống.',
    'required_if'          => ':attribute không được để trống khi :other có giá trị là :value.',
    'required_with'        => ':attribute không được để trống khi :values được điền giá trị.',
    'required_with_all'    => ':attribute không được để trống khi tất cả :values được điền giá trị.',
    'required_without'     => ':attribute không được để trống khi :values không được điền giá trị.',
    'required_without_all' => ':attribute không được để trống khi tất cả :values không được điền giá trị.',
    'same'                 => ':attribute và :other phải có giá trị giống nhau.',
    'size'                 => [
        'numeric' => ':attribute phải có :size chữ số.',
        'file'    => ':attribute phải có dung lượng bằng :size KB.',
        'string'  => ':attribute phải có :size ký tự.',
        'array'   => ':attribute phải có số lượng bằng :size.',
    ],
    'string'               => ':attribute phải là một chuỗi.',
    'timezone'             => ':attribute phải là múi giờ quốc tế hợp lệ.',
    'unique'               => ':attribute này đã được đăng ký.',
    'url'                  => ':attribute phải là URL hợp lệ.',

    'password'             => ':attribute không đúng với mật khẩu hiện tại của bạn',
    'wizard'               => ':attribute không hợp lệ',

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
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'topics'=> 'Chủ đề',
        'about_me'=>'Giới thiệu',
        'experience'=>'Kinh nghiệm giảng dạy',
        'methodology'=>'Phương pháp giảng dạy',
    ],

];
