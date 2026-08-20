<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofllow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
        <title>介護報酬請求シミュレータ | 単位数シミュレータ</title>
    </head>

    <body>
        <div class="js_title">
            <h1>単位数シミュレータ</h1>
        </div>
        <div class="explanation_area">
            <h3 class="js_user_data" data-user="<?= $user['_id']; ?>">
                <?= $user['user_name'] ?> 様
            </h3>
            <table class="user_info">
                <tr>
                    <th>要介護度</th>
                    <td>
                        <?= isset(Model_User::$care_level_name[$user['care_level']])
                            ? Model_User::$care_level_name[$user['care_level']]
                           : '不明' ?>
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

        <div class="service_code_area">
            <?php foreach ($service_code as $code): ?>
            <button type="button" class="service_code_button js_add_service"
                data-name="<?= $code['name']; ?>"
                data-code="<?= $code['service'].$code['item']; ?>"
                data-unit="<?= $code['unit']; ?>"
                data-type="<?= $code['type']; ?>"
                data-issue_limit="<?= $code['issue_limit']; ?>"
                data-calc="<?= $code['calc']; ?>"
            >
                <div class="service_code_name">
                    <?= $code['name']; ?>
                </div>
                <div class="service_code_info">
                    単位数: <?= $code['unit']; ?>
                </div>
            </button>
            <?php endforeach; ?>
        </div>

        <div class="border_line"></div>

        <form id="add_service" action="/claim/calc" method="post">
            <input
                type="hidden"
                name="user_id"
                value="<?= $user['_id']; ?>"
            >

            <table class="cart_table">
                <thead>
                    <tr>
                        <th>サービスコード</th>
                        <th>サービス名</th>
                        <th class="unit_col">単位数</th>
                        <th class="cnt_col">回数</th>
                    </tr>
                </thead>
                <tbody id="service_list"></tbody>
            </table>

            <div id="hidden_area"></div>

            <div class="js_submit">
                <button type="button" id="calc_btn">計算実行</button>
            </div>
        </form>


        <div class="link_area">
            <p class="list"><a href="/user/list">利用者一覧ページ</a></p>
            <span class="separator">|</span>
            <p class="calc"><a href="/user/upsert">利用者登録ページ</a></p>
        </div>

        <?= Asset::js('register.js'); ?>
        <?= Asset::css('master.css'); ?>
    </body>
</html>