<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- 文字コード・画面設定 -->
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofllow">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- jQuery読込 -->
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

        <title>お会計アプリ | レシート一覧</title>
    </head>

    <body>

        <!-- タイトル -->
        <div class="js_title">
            <h1>レシート一覧ページ</h1>
        </div>

        <!-- レシート一覧 -->
        <table class="item_list">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>お買い物をした日</th>
                    <th>支払い金額</th>
                    <th>削除</th>
                </tr>
            </thead>

            <tbody>

                <!-- 表示用連番 -->
                <?php $cnt = 1;?>

                <!-- レシートが存在する場合 -->
                <?php if (!empty($items)):?>

                    <!-- レシート一覧表示 -->
                    <?php foreach ($items as $item): ?>
                    <tr>

                        <!-- 連番 -->
                        <td>
                            <?= $cnt++; ?>
                        </td>

                        <!-- レシート詳細画面へのリンク -->
                        <td>
                            <a href="/receipt/receipt_view/<?= $item['_id'] ?>">
                                <?= $item['view_date'] ?>
                            </a>
                        </td>

                        <!-- 支払い金額 -->
                        <td>
                            <?= $item['total'] ?>円
                        </td>

                        <!-- レシート削除 -->
                        <td>
                            <button
                                type="button"
                                onclick="delete_confirm('<?= $item['_id']; ?>', 'receipt')"
                            >
                                削除
                            </button>
                        </td>

                    </tr>
                    <?php endforeach; ?>

                <!-- レシートが存在しない場合 -->
                <?php else: ?>
                <tr>
                    <td colspan="6" class="text_center">
                        レシートがありません
                    </td>
                </tr>
                <?php endif; ?>

            </tbody>
        </table>

        <!-- 画面遷移リンク -->
        <div class="link_area">
            <p class="calc">
                <a href="/receipt">お会計ページ</a>
            </p>

            <span class="separator">|</span>

            <p class="list">
                <a href="/management/list">商品一覧ページ</a>
            </p>

            <span class="separator">|</span>

            <p class="calc">
                <a href="/management/insert">商品登録ページ</a>
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