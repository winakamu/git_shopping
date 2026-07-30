<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- 文字コード・画面設定 -->
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofllow">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- jQuery読込 -->
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

        <title>お会計アプリ | レシート</title>
    </head>

    <body>

        <!-- タイトル -->
        <div class="js_title">
            <h1>レシート</h1>
        </div>

        <!-- レシート発行日時 -->
        <div class="receipt_date">
            <?= $receipt_data['view_date'] ?>
        </div>

        <!-- レシート内容 -->
        <table class="receipt_table">
            <tbody>

                <!-- 購入商品一覧 -->
                <?php foreach ($receipt_data['items'] as $item): ?>
                <tr>
                    <td class="item_name">

                        <!-- 商品の税区分を表示 -->
                        <?php if($item['tax']=='8%'): ?>
                            軽)
                        <?php elseif($item['tax']=='非課税'): ?>
                            非)
                        <?php elseif($item['tax']=='税込'): ?>
                            込)
                        <?php endif; ?>

                        <!-- 商品名 -->
                        <?= $item['name'] ?>
                    </td>

                    <!-- 商品価格 -->
                    <td class="item_price">
                        <?= $item['price'] ?>
                    </td>
                </tr>
                <?php endforeach; ?>

                <!-- 区切り線 -->
                <tr class="receipt_border">
                    <td colspan="2"></td>
                </tr>

                <!-- 軽減税率(8%) -->
                <?php if((isset($receipt_data['subtotal']['tax_8'])) && ($receipt_data['subtotal']['tax_8']['excluding_tax']!=0)): ?>
                    <tr>
                        <td class="subtotal_name">小計(税抜 8%)</td>
                        <td class="subtotal_data">
                            <?= $receipt_data['subtotal']['tax_8']['excluding_tax'] ?>円
                        </td>
                    </tr>

                    <tr>
                        <td class="subtotal_name">消費税等(税抜 8%)</td>
                        <td class="subtotal_data">
                            <?= $receipt_data['subtotal']['tax_8']['consumption_tax'] ?>円
                        </td>
                    </tr>
                <?php endif; ?>

                <!-- 税率10% -->
                <?php if((isset($receipt_data['subtotal']['tax_10'])) && ($receipt_data['subtotal']['tax_10']['excluding_tax']!=0)): ?>
                    <tr>
                        <td class="subtotal_name">小計(税抜 10%)</td>
                        <td class="subtotal_data">
                            <?= $receipt_data['subtotal']['tax_10']['excluding_tax'] ?>円
                        </td>
                    </tr>

                    <tr>
                        <td class="subtotal_name">消費税等(税抜 10%)</td>
                        <td class="subtotal_data">
                            <?= $receipt_data['subtotal']['tax_10']['consumption_tax'] ?>円
                        </td>
                    </tr>
                <?php endif; ?>

                <!-- 税込商品 -->
                <?php if((isset($receipt_data['subtotal']['tax_included'])) && ($receipt_data['subtotal']['tax_included']['excluding_tax']!=0)): ?>
                    <tr>
                        <td class="subtotal_name">小計(税込)</td>
                        <td class="subtotal_data">
                            <?= $receipt_data['subtotal']['tax_included']['excluding_tax'] ?>円
                        </td>
                    </tr>
                <?php endif; ?>

                <!-- 非課税商品 -->
                <?php if((isset($receipt_data['subtotal']['tax_exempt'])) && ($receipt_data['subtotal']['tax_exempt']['excluding_tax']!=0)): ?>
                    <tr>
                        <td class="subtotal_name">小計(非課税)</td>
                        <td class="subtotal_data">
                            <?= $receipt_data['subtotal']['tax_exempt']['excluding_tax'] ?>円
                        </td>
                    </tr>
                <?php endif; ?>

                <!-- 区切り線 -->
                <tr class="receipt_border">
                    <td colspan="2"></td>
                </tr>

                <!-- 合計金額 -->
                <tr>
                    <td class="total_name">合計</td>
                    <td class="total_data">
                        <?= $receipt_data['total'] ?>円
                    </td>
                </tr>

            </tbody>
        </table>

        <!-- メッセージ -->
        <div class="receipt_date">
            ありがとうございました。
        </div>

        <!-- 画面遷移リンク -->
        <div class="link_area">
            <p class="list">
                <a href="/receipt/list">商品一覧ページ</a>
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