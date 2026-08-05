<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofllow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
        <title>介護報酬請求シミュレータ | 計算結果</title>
    </head>

    <body>
        <div class="js_title">
            <h1>計算結果</h1>
        </div>

        <div class="explanation_area">
            <h3 class="js_user_data" data-user="<?= $user['_id']; ?>">
                <?= $user['user_name'] ?> 様
            </h3>
            <table class="user_info">
                <tr>
                    <th>要介護度</th>
                    <td>
                        <?= $user['care_level_name'] ?>
                    </td>
                </tr>
                <tr>
                    <th>区分支給単位数</th>
                    <td>
                        <?= $user['limit_unit'] ?>
                    </td>
                </tr>
                <tr>
                    <th>介護保険給付率</th>
                    <td>
                        <?= $user['rate'] ?> %
                    </td>
                </tr>
            </table>
        </div>

        <div class="border_line"></div>

        <table class="cart_table">
            <thead>
                <tr>
                    <th class="col_120">サービスコード</th>
                    <th>サービス名<br>(◎は限度額外)</th>
                    <th class="unit_col">サービス<br>単位数</th>
                    <th class="cnt_col">回数</th>
                    <th class="col_120">区分支給限度<br>基準内単位数</th>
                </tr>
                <?php foreach ($items['service_data'] as $service): ?>
                <tr>
                    <td class="js_service_code"><?= $service['code'] ?></td>
                    <td class="js_name">
                        <?php if ($service['issue_limit'] === 'outside'): ?>
                        ◎
                        <?php endif; ?>
                        <?= $service['name'] ?></td>
                    <td class="js_unit"><?= $service['unit'] ?></td>
                    <td class="js_service_count"><?= $service['service_count'] ?></td>
                    <td class="js_service_unit"><?= $service['service_unit'] ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="result_total" colspan="4">限度額内単位数</td>
                    <td><?= $items['within_total'] ?></td>
                </tr>
                <tr>
                    <td class="result_total" colspan="4">限度額外単位数</td>
                    <td><?= $items['outside_total'] ?></td>
                </tr>
                <tr>
                    <td class="result_total" colspan="4">合計</td>
                    <td><?= $items['within_total']+$items['outside_total'] ?></td>
                </tr>
            </thead>
            <tbody id="service_list"></tbody>
        </table>

        <div class="link_area">
            <p class="list"><a href="/user/list">利用者一覧ページ</a></p>
            <span class="separator">|</span>
            <p class="calc"><a href="/user/upsert">利用者登録ページ</a></p>
        </div>

        <?= Asset::js('register.js'); ?>
        <?= Asset::css('master.css'); ?>
    </body>
</html>