/**
 * register.js
 *
 * 【機能】
 * ・商品登録画面の入力チェック
 * ・商品削除確認
 * ・お会計画面の商品追加・会計処理
 */

console.log('register.js loaded');

/**
 * 商品登録画面
 * 入力チェック
 */
$(function () {

    // 商品登録フォームのjquery読み込み時にproduct_formを探し、あればsubmitイベントを登録
    // 登録ボタン押下時に{}内イベント(入力チェックを実行)
    $('.product_form').on('submit', function (event) {

        // 前回表示したエラーメッセージを削除
        $('.error_message').remove();

        // 入力された商品名・価格を取得
        const productName =
            $(this).find('input[name="product_name"]').val().trim();

        const price =
            $(this).find('input[name="price"]').val().trim();

        let hasError = false;

        // 商品名未入力チェック
        if (productName === '') {
            $(this)
                .find('input[name="product_name"]')
                .after(
                    '<p class="error_message">商品名が空欄です</p>'
                );

            hasError = true;
        }

        // 価格未入力チェック
        if (price === '') {
            $(this)
                .find('input[name="price"]')
                .after(
                    '<p class="error_message">1個あたりの値段(税抜)が空欄です</p>'
                );

            hasError = true;

        // 数値入力チェック
        } else if (!/^\d+$/.test(price)) {
            $(this)
                .find('input[name="price"]')
                .after(
                    '<p class="error_message">※1個あたりの値段(税抜)には数値を入力してください。</p>'
                );

            hasError = true;
        }

        // エラーがある場合はフォーム送信を中止
        if (hasError) {
            event.preventDefault();
        }
    });
});

/**
 * 商品一覧画面
 * 商品削除確認ダイアログ
 * こちらはjavascriptの書き方(jqueryと別パターンで記載可)
 */
function delete_confirm(id, controller) {

    // 削除確認ダイアログを表示
    const isDelete = window.confirm('削除してよろしいですか？');

    // キャンセル時は処理終了
    if (!isDelete) {
        return;
    }

    // 削除処理を実行
    window.location.href =
        '/' + controller + '/delete/' + id;
}

/**
 * お会計画面
 * 商品追加・会計処理
 */
$(function () {

    // hidden項目の連番管理
    let itemCount = 0;

    // 商品追加ボタン押下
    $('.js_add_item').on('click', function () {

        // ボタンに設定された商品情報を取得
        const name = $(this).data('name');
        const price = $(this).data('price');
        const tax = $(this).data('tax');

        let taxLabel = '';

        // 税率表示用の文字列へ変換
        if (tax === 'exempt') {
            taxLabel = '非課税';
        } else if (tax === 'included') {
            taxLabel = '税込';
        } else {
            taxLabel = tax + '%';
        }

        // 商品一覧へ追加
        const row = `
            <tr>
                <td>${name}</td>
                <td>${Number(price).toLocaleString()}円</td>
                <td>${taxLabel}</td>
            </tr>
        `;

        $('#cart_list').append(row);

        // Controllerへ送信するhidden項目を追加
        const hiddenInputs = `
            <input
                type="hidden"
                name="items[${itemCount}][name]"
                value="${name}"
            >
            <input
                type="hidden"
                name="items[${itemCount}][price]"
                value="${price}"
            >
            <input
                type="hidden"
                name="items[${itemCount}][tax]"
                value="${tax}"
            >
        `;

        $('#hidden_area').append(hiddenInputs);

        itemCount++;
    });

    // 会計ボタン押下
    $('#checkout_btn').on('click', function () {

        // 商品未選択時は会計不可
        if (itemCount === 0) {
            alert('商品が登録されていません');
            return;
        }

        // Controllerへ商品情報を送信
        $('#cart_form').submit();
    });
});