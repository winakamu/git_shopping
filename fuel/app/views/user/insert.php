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
            <h1>利用者登録</h1>
        </div>

        <form action="/user/insert" method="post">
            <table class="insert_table">
                <tr>
                    <th>利用者名</th>
                    <td>
                        <input type="text" name="user_name">
                    </td>
                </tr>

                <tr>
                    <th>介護度</th>
                    <td>
                        <select name="care_level">
                            <option value="">介護度を選択</option>
                            <option value="integ">事業対象者</option>
                            <option value="prev1">要支援1</option>
                            <option value="prev2">要支援2</option>
                            <option value="care1">要介護1</option>
                            <option value="care2">要介護2</option>
                            <option value="care3">要介護3</option>
                            <option value="care4">要介護4</option>
                            <option value="care5">要介護5</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>介護保険給付率(%で入力)</th>
                    <td>
                        <input type="number" name="rate">
                    </td>
                </tr>
            </table>

            <div class="js_submit">
                <button type="submit">登録</button>
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