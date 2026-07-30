<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- 文字コード・画面設定 -->
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofllow">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- jQuery読込 -->
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

        <title>お会計アプリ | 商品編集</title>
    </head>

    <body>

        <!-- タイトル -->
        <div class="js_title">
            <h1>商品編集ページ</h1>
        </div>

        <!-- 商品編集フォーム -->
        <form action="/management/update/<?= $item['_id']; ?>" method="post">

            <table class="insert_table">

                <!-- 商品名 -->
                <tr>
                    <th>商品名</th>
                    <td>
                        <input type="text" name="product_name" value="<?= $item['name']; ?>">
                    </td>
                </tr>

                <!-- 消費税区分 -->
                <tr>
                    <th>消費税</th>
                    <td>
                        <select name="tax">
                            <option value="exempt" <?php if ($item['tax'] == 'exempt') echo 'selected'; ?>>
                                非課税
                            </option>

                            <option value="included" <?php if ($item['tax'] == 'included') echo 'selected'; ?>>
                                税込
                            </option>

                            <option value="8" <?php if ($item['tax'] == 8) echo 'selected'; ?>>
                                8%
                            </option>

                            <option value="10" <?php if ($item['tax'] == 10) echo 'selected'; ?>>
                                10%
                            </option>
                        </select>
                    </td>
                </tr>

                <!-- 商品価格 -->
                <tr>
                    <th>1個あたりの値段(税抜)</th>
                    <td>
                        <input type="text" name="price" value="<?= $item['price']; ?>">
                    </td>
                </tr>

            </table>

            <!-- 更新ボタン -->
            <div class="js_submit">
                <button type="submit">更新</button>
            </div>

        </form>

        <!-- 画面遷移リンク -->
        <div class="link_area">
            <p class="list">
                <a href="/management/list">商品一覧ページ</a>
            </p>

            <span class="separator">|</span>

            <p class="calc">
                <a href="/receipt">お会計ページ</a>
            </p>

            <span class="separator">|</span>

            <p class="calc">
                <a href="/receipt/list">レシート一覧ページ</a>
            </p>
        </div>

        <!-- ダッシュボードへ戻る -->
        <div class="link_area">
            <p class="list">
                <a href="/dashboard">ダッシュボード</a>
            </p>
        </div>

        <!-- JavaScript読込 -->
        <?= Asset::js('register.js'); ?>

        <!-- CSS読込 -->
        <?= Asset::css('master.css'); ?>

    </body>
</html>