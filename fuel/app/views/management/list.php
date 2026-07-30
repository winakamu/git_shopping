<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- 文字コード・画面設定 -->
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofllow">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- jQuery読込 -->
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

        <title>お会計アプリ | 商品一覧</title>
    </head>

    <body>

        <!-- タイトル -->
        <div class="js_title">
            <h1>商品一覧ページ</h1>
        </div>

        <!-- 商品一覧 -->
        <table class="item_list">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>商品名</th>
                    <th>消費税(%)</th>
                    <th>値段(税抜)</th>
                    <th>編集</th>
                    <th>削除</th>
                </tr>
            </thead>

            <tbody>

                <!-- 表示用連番 -->
                <?php $cnt = 1;?>

                <!-- 商品が存在する場合 -->
                <?php if (!empty($items)):?>

                    <!-- 商品一覧表示 -->
                    <?php foreach ($items as $item): ?>
                    <tr>

                        <!-- 連番 -->
                        <td>
                            <?= $cnt++; ?>
                        </td>

                        <!-- 商品名 -->
                        <td>
                            <?= $item['name']; ?>
                        </td>

                        <!-- 消費税区分 -->
                        <td>
                            <?php if ($item['tax']=='exempt'):?>
                                非課税
                            <?php elseif ($item['tax']=='included'):?>
                                税込
                            <?php else: ?>
                                <?= $item['tax']; ?>%
                            <?php endif; ?>
                        </td>

                        <!-- 商品価格 -->
                        <td>
                            <?= number_format($item['price']); ?>円
                        </td>

                        <!-- 商品編集 -->
                        <td>
                            <a href="/management/edit/<?= $item['_id']; ?>">
                                <button type="button">編集</button>
                            </a>
                        </td>

                        <!-- 商品削除 -->
                        <td>
                            <button
                                type="button"
                                onclick="delete_confirm('<?= $item['_id']; ?>', 'management')"
                            >
                                削除
                            </button>
                        </td>

                    </tr>
                    <?php endforeach; ?>

                <!-- 商品が存在しない場合 -->
                <?php else: ?>
                <tr>
                    <td colspan="6" class="text_center">
                        商品がありません
                    </td>
                </tr>
                <?php endif; ?>

            </tbody>
        </table>

        <!-- 画面遷移リンク -->
        <div class="link_area">
            <p class="list">
                <a href="/management/insert">商品登録ページ</a>
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

        <!-- CSS読込 -->
        <?= Asset::css('master.css'); ?>

        <!-- JavaScript読込 -->
        <?= Asset::js('register.js'); ?>

    </body>
</html>