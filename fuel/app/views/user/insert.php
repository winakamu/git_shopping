<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofllow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
        <title>介護報酬請求シミュレータ | 利用者登録</title>
    </head>

    <body>
        <div class="js_title">
            <h1>
                <?= !empty($user_id) ? '利用者更新' : '利用者登録' ?>
            </h1>
        </div>

        <form action="" method="post" class="insert_form">
            <table class="insert_table">
                <tr>
                    <th>利用者名</th>
                    <td>
                        <input
                            type="text"
                            name="user_name"
                            value="<?= isset($user['user_name']) ? $user['user_name'] : '' ?>"
                        >
                    </td>
                </tr>

                <tr>
                    <th>介護度</th>
                    <td>
                        <select name="care_level">
                            <option value="">介護度を選択</option>

                            <?php foreach (Model_Pseudo::$care_level_name as $value => $name): ?>
                            <option
                                value="<?= $value ?>"
                                <?= isset($user['care_level']) && $user['care_level'] === $value ? 'selected' : '' ?>
                            >
                                <?= $name ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>介護保険給付率(%で入力)</th>
                    <td>
                        <input
                            type="number"
                            name="rate"
                            value="<?= isset($user['rate']) ? $user['rate'] : '' ?>"
                        >
                    </td>
                </tr>
            </table>

            <div class="js_submit">
                <button type="submit">
                    <?= !empty($user_id) ? '更新' : '登録' ?>
                </button>
            </div>
        </form>

        <div class="link_area">
            <p class="list"><a href="/user/list">利用者一覧ページ</a></p>
        </div>

        <div class="link_area">
            <p class="list"><a href="/dashboard">ダッシュボード</a></p>
        </div>

        <?= Asset::js('register.js'); ?>
        <?= Asset::css('master.css'); ?>
    </body>
</html>