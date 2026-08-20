<?php

class Model_Pseudo extends Model
{
    /**
     * [
     *     'service': サービス種類
     *     'item': サービスコード下4桁
     *     'name': サービス名
     *     'unit': 単位数
     *     'type': 基本/合成なら'basic', 加算・減算なら'add_or_sub'
     *     'issue_limit': 限度額内なら'within', 限度額外なら'outside'
     *     'calc': 回数は'time', 日単位は'daily', 月単位は'monthly', 週単位は'weekly', %なら'percent'
     *     'sort': 計算順
     * ],
     */
    public static $service_code = [
        [
            'service' => '11',
            'item' => '1111',
            'name' => '身体介護１',
            'unit' => '244',
            'type' => 'basic',
            'issue_limit' => 'within',
            'calc' => 'time',
            'sort' => 1
        ],
        [
            'service' => '11',
            'item' => '8111',
            'name' => '通院等乗降介助',
            'unit' => '97',
            'type' => 'basic',
            'issue_limit' => 'within',
            'calc' => 'time',
            'sort' => 2
        ],
        [
            'service' => '11',
            'item' => '6410',
            'name' => '訪問介護特定事業所加算Ⅴ',
            'unit' => '3%',
            'type' => 'add_or_sub',
            'issue_limit' => 'within',
            'calc' => 'percent',
            'sort' => 3
        ],
        [
            'service' => '11',
            'item' => '6361',
            'name' => '訪問介護共生型サービス居宅介護１',
            'unit' => '-30%',
            'type' => 'add_or_sub',
            'issue_limit' => 'within',
            'calc' => 'percent',
            'sort' => 4
        ],
        [
            'service' => '11',
            'item' => '4114',
            'name' => '訪問介護同一建物減算１',
            'unit' => '-10%',
            'type' => 'add_or_sub',
            'issue_limit' => 'outside',
            'calc' => 'percent',
            'sort' => 5
        ],
        [
            'service' => '11',
            'item' => '8000',
            'name' => '特別地域訪問介護加算',
            'unit' => '15%',
            'type' => 'add_or_sub',
            'issue_limit' => 'outside',
            'calc' => 'percent',
            'sort' => 6
        ],
        [
            'service' => '11',
            'item' => '8100',
            'name' => '訪問介護小規模事業所加算',
            'unit' => '10%',
            'type' => 'add_or_sub',
            'issue_limit' => 'outside',
            'calc' => 'percent',
            'sort' => 7
        ],
        [
            'service' => '11',
            'item' => '8110',
            'name' => '訪問介護中山間地域等提供加算',
            'unit' => '5%',
            'type' => 'add_or_sub',
            'issue_limit' => 'outside',
            'calc' => 'percent',
            'sort' => 8
        ],
        [
            'service' => '11',
            'item' => '4001',
            'name' => '訪問介護初回加算',
            'unit' => '200',
            'type' => 'add_or_sub',
            'issue_limit' => 'within',
            'calc' => 'monthly',
            'sort' => 9
        ],
        [
            'service' => '11',
            'item' => '4004',
            'name' => '訪問介護認知症専門ケア加算Ⅰ',
            'unit' => '3',
            'type' => 'add_or_sub',
            'issue_limit' => 'within',
            'calc' => 'daily',
            'sort' => 10
        ],
        [
            'service' => '11',
            'item' => '6275',
            'name' => '訪問介護処遇改善加算Ⅰ１',
            'unit' => '27%',
            'type' => 'add_or_sub',
            'issue_limit' => 'outside',
            'calc' => 'percent',
            'sort' => 11
        ],
    ];

    public static $sort_struct = [
        '111111' => 1,
        '118111' => 2,
        '116410' => 3,
        '116361' => 4,
        '114114' => 5,
        '118000' => 6,
        '118100' => 7,
        '118110' => 8,
        '114001' => 9,
        '114004' => 10,
        '116275' => 11
    ];

    public static $limit_unit = [
        'integ' => '5032',
        'prev1' => '5032',
        'prev2' => '10531',
        'care1' => '16765',
        'care2' => '19705',
        'care3' => '27048',
        'care4' => '30938',
        'care5' => '36217'
    ];
}
