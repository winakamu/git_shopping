<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofllow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
        <title>介護報酬請求シミュレータ | 利用者一覧</title>
    </head>

    <body>
        <div class="js_title">
            <h1>利用者一覧</h1>
            <p>名前のリンクを押下すると単位数シミュレータに遷移するよ</p>
        </div>
        <table class="user_list">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>利用者名</th>
                    <th>介護度</th>
                    <th>編集</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
            <?php $cnt = 1;?>
                <?php if (!empty($users)):?>
                <?php foreach ($users as $user_data): ?>
                <tr>
                    <td>
                        <?= $cnt++; ?>
                    </td>
                    <td>
                        <a href="/claim/simulator/<?= $user_data['_id']; ?>">
                            <?= $user_data['user_name']; ?>
                        </a>
                    </td>
                    <td>
                        <?= isset(Model_Pseudo::$care_level_name[$user_data['care_level']])
                            ? Model_Pseudo::$care_level_name[$user_data['care_level']]
                            : '不明'; ?>
                    </td>
                    <td>
                        <a href="/user/upsert/<?= $user_data['_id']; ?>">
                            <button type="button">編集</button>
                        </a>
                    </td>
                    <td>
                        <button
                            type="button"
                            onclick="delete_confirm('<?= $user_data['_id']; ?>', 'user')"
                        >
                            削除
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5" class="text_center">
                        利用者がいません
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="link_area">
            <p class="list"><a href="/user/upsert">利用者登録ページ</a></p>
        </div>

        <div class="link_area">
            <p class="list"><a href="/dashboard">ダッシュボード</a></p>
        </div>

        <?= Asset::css('master.css'); ?>
        <?= Asset::js('register.js'); ?>
    </body>
</html>