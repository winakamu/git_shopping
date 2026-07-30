<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- 文字コード・画面設定 -->
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofllow">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- jQuery読込 -->
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

        <title>お会計アプリ | お会計</title>
    </head>

    <body>

        <!-- タイトル -->
        <div class="js_title">
            <h1>お会計ページ</h1>
        </div>

        <!-- 商品一覧 -->
        <div class="product_area">

            <?php foreach ($items as $item): ?>

            <!-- 商品追加ボタン -->
            <button type="button" class="product_button js_add_item"
                data-name="<?= $item['name']; ?>"
                data-price="<?= $item['price']; ?>"
                data-tax="<?= $item['tax']; ?>"
            >
                <!-- 商品名 -->
                <div class="product_name">
                    <?= $item['name']; ?>
                </div>

                <!-- 価格・税率 -->
                <div class="product_info">
                    <?= number_format($item['price']); ?>円(税抜)
                    /
                    <?php if ($item['tax']=='exempt'):?>
                        非課税
                    <?php elseif ($item['tax']=='included'):?>
                        税込
                    <?php else: ?>
                        <?= $item['tax']; ?>%
                    <?php endif; ?>
                </div>
            </button>

            <?php endforeach; ?>

        </div>

        <!-- お買い物リスト -->
        <form id="cart_form" action="/receipt/receipt_create" method="post">

            <!-- 選択した商品一覧 -->
            <table class="cart_table">
                <thead>
                    <tr>
                        <th>商品名</th>
                        <th>値段(税抜)</th>
                        <th>消費税(%)</th>
                    </tr>
                </thead>

                <!-- JavaScriptで商品を追加 -->
                <tbody id="cart_list"></tbody>
            </table>

            <!-- Controllerへ送信するhidden項目 -->
            <div id="hidden_area"></div>

            <!-- お会計ボタン -->
            <div class="js_submit">
                <button type="button" id="checkout_btn">
                    お会計
                </button>
            </div>

        </form>

        <!-- 画面遷移リンク -->
        <div class="link_area">
            <p class="list">
                <a href="/management/list">商品一覧ページ</a>
            </p>

            <span class="separator">|</span>

            <p class="calc">
                <a href="/management/insert">商品登録ページ</a>
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