<?php

/**
 * 単位数計算を行うModelです。
 *
 * 【機能】
 * ・選択されたサービス情報の取得
 * ・サービスの計算順への並べ替え
 * ・算定単位ごとの単位数計算
 * ・限度額内単位数の集計
 * ・限度額外単位数の集計
 * ・合計単位数の算出
 */
class Model_Claim extends Model
{
    /**
     * 選択されたサービスの単位数を計算します。
     *
     * Model_Pseudoに定義されているサービス情報と
     * 選択されたサービスを照合し、sort順に計算します。
     *
     * @param array $services 選択されたサービス一覧
     * @return array 計算結果
     */
    public static function calculate(array $services)
    {
        $service_list = [];

        /*
         * 選択されたサービスと
         * Model_Pseudoのサービス定義を結合
         */
        foreach ($services as $service) {
            $code = $service['code'];

            foreach (Model_Pseudo::$service_code as $master) {
                $master_code =
                    $master['service'] . $master['item'];

                // サービスコードが一致した場合、
                // 計算に必要な情報を一覧へ追加
                if ($master_code === $code) {
                    $service_list[] = [
                        'code' => $code,
                        'count' => (int) $service['count'],
                        'master' => $master,
                    ];

                    break;
                }
            }
        }

        /*
         * サービスを計算順に並べ替え
         */
        usort($service_list, function ($a, $b) {
            $a_sort =
                Model_Pseudo::$sort_struct[$a['code']];

            $b_sort =
                Model_Pseudo::$sort_struct[$b['code']];

            if ($a_sort == $b_sort) {
                return 0;
            }

            return ($a_sort < $b_sort) ? -1 : 1;
        });

        // 結果画面へ渡すサービス情報
        $rows = [];

        // 限度額内・限度額外の単位数
        $within_total = 0;
        $outside_total = 0;

        /*
         * それまでに計算したサービス単位数の合計
         *
         * percent計算時の「所定単位数」として使用
         */
        $running_total = 0;

        /*
         * サービスを計算順に1件ずつ処理
         */
        foreach ($service_list as $service) {
            $master = $service['master'];

            $code = $service['code'];
            $count = $service['count'];

            $name = $master['name'];
            $unit = $master['unit'];
            $calc = $master['calc'];
            $issue_limit = $master['issue_limit'];

            // このサービスの計算結果
            $service_unit = 0;

            /*
             * 1回につき
             */
            if ($calc === 'time') {
                $service_unit =
                    (int) $unit * $count;
            }

            /*
             * 1日につき
             */
            elseif ($calc === 'daily') {
                $service_unit =
                    (int) $unit * $count;
            }

            /*
             * 1月につき
             */
            elseif ($calc === 'monthly') {
                $service_unit =
                    (int) $unit;
            }

            /*
             * 1週間につき
             */
            elseif ($calc === 'weekly') {
                if ($count <= 4) {
                    $service_unit =
                        (int) $unit * $count;
                } else {
                    $service_unit =
                        (int) $unit * 4;
                }
            }

            /*
             * %
             */
            elseif ($calc === 'percent') {
                $percent =
                    (float) str_replace('%', '', $unit);

                $service_unit = round(
                    $running_total * $percent / 100
                );

                $service_unit =
                    (int) $service_unit;
            }

            /*
             * 計算結果を限度額内・限度額外へ振り分け
             */
            if ($issue_limit === 'within') {
                $within_total += $service_unit;
            } else {
                $outside_total += $service_unit;
            }

            /*
             * 次のpercent計算用に累計へ加算
             */
            $running_total += $service_unit;

            /*
             * 結果画面表示用データ
             */
            $rows[] = [
                'code' => $code,
                'name' => $name,
                'unit' => $unit,
                'issue_limit' => $issue_limit,
                'service_count' => $count,
                'service_unit' => $service_unit,
            ];
        }

        return [
            'service_data' => $rows,
            'within_total' => $within_total,
            'outside_total' => $outside_total,
            'total' => $within_total + $outside_total,
        ];
    }
}