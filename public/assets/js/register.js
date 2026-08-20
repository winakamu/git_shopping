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
        var productName =
            $(this).find('input[name="product_name"]').val().trim();

        var price =
            $(this).find('input[name="price"]').val().trim();

        var hasError = false;

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
    var isDelete = window.confirm('削除してよろしいですか？');

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
        var name = $(this).data('name');
        var price = $(this).data('price');
        var tax = $(this).data('tax');

        var taxLabel = '';

        // 税区分を画面表示用の文字列へ変換
        if (tax === 'exempt') {
            taxLabel = '非課税';
        } else if (tax === 'included') {
            taxLabel = '税込';
        } else {
            taxLabel = tax + '%';
        }

        // 商品一覧へ追加
        var row = '<tr>';
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

        var itemCount = 0;

        // 商品一覧を1行ずつ処理
        $('#cart_list tr').each(function () {
            var name = $(this).find('.js_name').text();
            var price = $(this).find('.js_price').data('price');
            var tax = $(this).find('.js_tax').data('tax');

            var hiddenInputs = '';
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

/*
**********************************************
↓PG課題②用
**********************************************
*/

/**
 * 利用者登録・単位数シミュレータの処理を行います。
 *
 * 【機能】
 * ・利用者登録フォームの入力チェック
 * ・シミュレータへサービスを追加
 * ・サービス回数の入力チェック
 * ・計算に必要なサービス情報の送信
 */
$(function () {

    /**
     * 利用者登録フォームの入力チェックを行います。
     *
     * 利用者名、介護度、介護保険給付率に未入力がある場合は、
     * 各入力欄の下へエラーメッセージを表示し、
     * フォーム送信を中止します。
     *
     * @return {void}
     */
    $('.js_button').click(function () {
        var form = $(this).closest('.insert_form');

        // 前回表示したエラーメッセージを削除
        form.find('.error_message').remove();

        // 入力された利用者情報を取得
        var userName =
            form.find('[name="user_name"]').val().trim();

        var careLevel =
            form.find('[name="care_level"]').val();

        var rate =
            form.find('[name="rate"]').val().trim();

        var hasError = false;

        // 利用者名未入力チェック
        if (userName === '') {
            form
                .find('[name="user_name"]')
                .after(
                    '<p class="error_message">'
                    + '利用者名が空欄です'
                    + '</p>'
                );

            hasError = true;
        }

        // 介護度未選択チェック
        if (careLevel === '') {
            form
                .find('[name="care_level"]')
                .after(
                    '<p class="error_message">'
                    + '介護度が未選択です'
                    + '</p>'
                );

            hasError = true;
        }

        // 介護保険給付率未入力チェック
        if (rate === '') {
            form
                .find('[name="rate"]')
                .after(
                    '<p class="error_message">'
                    + '介護保険給付率(%)が空欄です'
                    + '</p>'
                );

            hasError = true;
        }

        // 入力エラーがある場合は処理を終了
        if (hasError) {
            return;
        }

        // エラーがない場合はフォーム送信
        form[0].submit();
    });


    /**
     * 計算実行ボタン押下時の処理です。
     *
     * サービスが選択されていることと、
     * 各サービスの回数が正しく入力されていることを確認します。
     *
     * 入力内容に問題がなければ、サービス情報をhidden項目として
     * 作成し、計算フォームをControllerへ送信します。
     *
     * @return {void}
     */
    $('#calc_btn').click(function () {

        // 前回表示したエラーメッセージを削除
        $('.error_message').remove();

        // サービスが選択されていない場合は処理を中止
        if ($('#service_list tr').length === 0) {
            $('#calc_btn').before(
                '<p class="error_message">'
                + 'サービスが登録されていません'
                + '</p>'
            );

            return;
        }

        // 前回作成したhidden項目を削除
        $('#hidden_area').empty();

        var hasError = false;

        /*
        * 同じサービスコードごとに
        * 回数をまとめるための配列
        */
        var services = {};

        /*
        * 選択されたサービスを1行ずつ処理
        */
        $('#service_list tr').each(function () {

            // サービス情報を取得
            var code =
                $(this).find('.js_code').text();

            var name =
                $(this).find('.js_name').text();

            var unit =
                $(this).find('.js_unit').data('unit');

            var count =
                $(this).find('.js_count').val();

            // 回数入力欄が取得できない場合
            if (count === undefined) {
                hasError = true;
                return;
            }

            var trimmedCount = count.trim();

            // 回数未入力チェック
            if (trimmedCount === '') {
                $(this)
                    .find('.js_count')
                    .after(
                        '<p class="error_message">'
                        + '回数が空です'
                        + '</p>'
                    );

                hasError = true;
                return;
            }

            // 回数の数値チェック
            if (!/^\d+$/.test(trimmedCount)) {
                $(this)
                    .find('.js_count')
                    .after(
                        '<p class="error_message">'
                        + '回数は半角数字で入力してください'
                        + '</p>'
                    );

                hasError = true;
                return;
            }

            /*
            * 同じサービスコードがすでにある場合は
            * 回数を加算
            * JavaScriptでは存在しないプロパティを取得すると、undefinedとなり、
            * 何も入っていない（初回）場合、if (undefined) でelseを実行。
            * 同じサービスコードの場合は、回数をプラス
            * 
            */
            if (services[code]) {
                services[code].count += Number(trimmedCount);
            } else {
                /*
                * 初めてのサービスコードの場合は
                * サービス情報を登録
                */
                services[code] = {
                    code: code,
                    name: name,
                    unit: unit,
                    count: Number(trimmedCount)
                };
            }
        });

        // 入力エラーがある場合は処理を中止
        if (hasError) {
            return;
        }

        /*
        * まとめたサービス情報から
        * Controllerへ送信するhidden項目を作成
        */
        var serviceCount = 0;

        $.each(services, function (code, service) {

            var hiddenInputs = '';

            hiddenInputs += '<input type="hidden"'
                + ' name="services['
                + serviceCount
                + '][code]"'
                + ' value="' + service.code + '">';

            hiddenInputs += '<input type="hidden"'
                + ' name="services['
                + serviceCount
                + '][name]"'
                + ' value="' + service.name + '">';

            hiddenInputs += '<input type="hidden"'
                + ' name="services['
                + serviceCount
                + '][unit]"'
                + ' value="' + service.unit + '">';

            hiddenInputs += '<input type="hidden"'
                + ' name="services['
                + serviceCount
                + '][count]"'
                + ' value="' + service.count + '">';

            $('#hidden_area').append(hiddenInputs);

            serviceCount++;
        });

        // Controllerへサービス情報を送信
        $('#add_service').submit();
    });


    /**
     * サービス追加ボタン押下時の処理です。
     *
     * ボタンに設定されたサービス情報を取得し、
     * 単位数シミュレータのサービス一覧へ追加します。
     *
     * @return {void}
     */
    $('.js_add_service').click(function () {

        // ボタンに設定されたサービス情報を取得
        var code = $(this).data('code');
        var name = $(this).data('name');
        var unit = $(this).data('unit');

        // サービス一覧へ追加する行を作成
        var row = '';

        row += '<tr>';
        row += '<td class="js_code">'
            + code
            + '</td>';

        row += '<td class="js_name">'
            + name
            + '</td>';

        row += '<td class="js_unit" data-unit="'
            + unit
            + '">'
            + unit
            + '</td>';

        row += '<td>'
            + '<input type="number" class="js_count">'
            + '</td>';

        row += '</tr>';

        // サービス一覧へ追加
        $('#service_list').append(row);
    });

    /**
     * 介護度選択時の利用者一覧絞り込み処理です。
     *
     * 選択された介護度を取得し、
     * Ajax通信で該当する利用者情報を取得します。
     *
     * @return {void}
     */
    $('.js_care_level').change(function () {
        var careLevel = $(this).val();

        //Ajax通信
        $.ajax({
            url: '/api/user/user_list',
            type: 'GET',
            data: {
                care_level: careLevel
            },
            dataType: 'json'
        })

        // Ajax通信が成功して完了(done)したら、以下の処理を実施(usersにはapiが返したデータが入る)
        .done(function (users) {
        var html = '';
        //usersがない OR usersが0件なら
        if (!users || users.length === 0) {
            html =
                '<tr>' +
                    '<td colspan="5">利用者がいません</td>' +
                '</tr>';
        } else {
            $.each(users, function (index, user) {
                html +=
                    '<tr>' +
                        //No.1~
                        '<td>' + (index + 1) + '</td>' +
                        //名前
                        '<td>' +
                            '<a href="/claim/simulator/' + user._id + '">' +
                                user.user_name +
                            '</a>' +
                        '</td>' +
                        //要介護度
                        '<td>' + user.care_level_name + '</td>' +
                        //編集ボタン
                        '<td>' +
                            '<a href="/user/upsert/' + user._id + '">' +
                                '<button type="button">編集</button>' +
                            '</a>' +
                        '</td>' +
                        //削除ボタン
                        '<td>' +
                            '<button type="button" ' +
                                'onclick="delete_confirm(\'' + user._id + '\', \'user\')">' +
                                '削除' +
                            '</button>' +
                        '</td>' +
                    '</tr>';
            });
        }

        // 上記で作成したHTMLで利用者一覧を書き換え
        $('.js_user_list').html(html);
        });
    });
});