/**
 * 商品登録・削除・会計処理を行います。
 *
 * 【機能】
 * ・商品登録画面の入力チェック
 * ・商品一覧画面の削除確認
 * ・お会計画面の商品追加および会計処理
 */

/**
 * 商品登録フォームの入力チェックを設定します。
 *
 * 商品名または価格が未入力の場合、もしくは価格が数値以外の場合は
 * エラーメッセージを表示し、フォーム送信を中止します。
 *
 * @return {void}
 */
$(function () {
    $('.product_form').submit(function (event) {
        // 前回表示したエラーメッセージを削除
        $('.error_message').remove();

        // 入力された商品名と価格を取得
        const productName =
            $(this).find('input[name="product_name"]').val().trim();

        const price =
            $(this).find('input[name="price"]').val().trim();

        let hasError = false;

        // 商品名が未入力の場合はエラーメッセージを表示
        if (productName === '') {
            $(this)
                .find('input[name="product_name"]')
                .after(
                    '<p class="error_message">商品名が空欄です</p>'
                );

            hasError = true;
        }

        // 価格が未入力の場合はエラーメッセージを表示
        if (price === '') {
            $(this)
                .find('input[name="price"]')
                .after(
                    '<p class="error_message">1個あたりの値段(税抜)が空欄です</p>'
                );

            hasError = true;

        // 価格が数値以外の場合はエラーメッセージを表示
        } else if (!/^\d+$/.test(price)) {
            $(this)
                .find('input[name="price"]')
                .after(
                    '<p class="error_message">※1個あたりの値段(税抜)には数値を入力してください。</p>'
                );

            hasError = true;
        }

        // 入力エラーがある場合はフォーム送信を中止
        if (hasError) {
            event.preventDefault();
        }
    });
});

/**
 * 商品削除前に確認ダイアログを表示します。
 *
 * ユーザーが削除を承認した場合は、指定されたControllerの
 * 削除処理へ遷移します。
 *
 * @param {string} id 削除対象の商品ID
 * @param {string} controller 遷移先のController名
 * @return {void}
 */
function delete_confirm(id, controller) {
    // 削除確認ダイアログを表示
    const isDelete = window.confirm('削除してよろしいですか？');

    // OK押下時のみ削除処理を実行
    if (isDelete) {
        window.location.href =
            '/' + controller + '/delete/' + id;
    }
}

/**
 * お会計画面の商品追加および会計処理を設定します。
 *
 * 商品追加ボタン押下時は、商品情報を商品一覧へ追加します。
 * 会計ボタン押下時は、商品一覧をループしてhidden項目を作成し、
 * 会計フォームを送信します。
 *
 * @return {void}
 */
$(function () {

    /**
     * 商品追加ボタン押下時の処理です。
     *
     * ボタンに設定された商品情報を取得し、
     * 商品一覧へ追加します。
     *
     * @return {void}
     */
    $('.js_add_item').click(function () {
        // ボタンに設定された商品情報を取得
        const name = $(this).data('name');
        const price = $(this).data('price');
        const tax = $(this).data('tax');

        let taxLabel = '';

        // 税区分を画面表示用の文字列へ変換
        if (tax === 'exempt') {
            taxLabel = '非課税';
        } else if (tax === 'included') {
            taxLabel = '税込';
        } else {
            taxLabel = tax + '%';
        }

        // 商品一覧へ追加
        let row = '<tr>';
        row += '<td class="js_name">' + name + '</td>';
        row += '<td class="js_price" data-price="' + price + '">'
            + Number(price).toLocaleString() + '円</td>';
        row += '<td class="js_tax" data-tax="' + tax + '">'
            + taxLabel + '</td>';
        row += '</tr>';

        $('#cart_list').append(row);
    });

    /**
     * 会計ボタン押下時の処理です。
     *
     * 商品が選択されていない場合は警告を表示します。
     * 商品が選択されている場合は、商品一覧をループして
     * hidden項目を作成し、会計フォームを送信します。
     *
     * @return {void}
     */
    $('#checkout_btn').click(function () {

        // 前回表示したエラーメッセージを削除
        $('.error_message').remove();

        // 商品が未選択の場合は会計処理を中止
        if ($('#cart_list tr').length === 0) {

            $('#checkout_btn').before(
                '<p class="error_message">商品が登録されていません</p>'
            );

            return;
        }

        // 作成済みのhidden項目を削除
        $('#hidden_area').empty();

        let itemCount = 0;

        // 商品一覧を1行ずつ処理
        $('#cart_list tr').each(function () {
            const name = $(this).find('.js_name').text();
            const price = $(this).find('.js_price').data('price');
            const tax = $(this).find('.js_tax').data('tax');

            let hiddenInputs = '';
            hiddenInputs += '<input type="hidden"'
                + ' name="items[' + itemCount + '][name]"'
                + ' value="' + name + '">';
            hiddenInputs += '<input type="hidden"'
                + ' name="items[' + itemCount + '][price]"'
                + ' value="' + price + '">';
            hiddenInputs += '<input type="hidden"'
                + ' name="items[' + itemCount + '][tax]"'
                + ' value="' + tax + '">';

            $('#hidden_area').append(hiddenInputs);

            itemCount++;
        });

        // Controllerへ商品情報を送信
        $('#cart_form').submit();
    });
});