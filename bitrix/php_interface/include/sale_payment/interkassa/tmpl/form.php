<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="/bitrix/php_interface/include/sale_payment/interkassa/css/interkassa.css">
 
<div class="interkasssa" style="text-align: center;">
    <img style="display: inline-block; width:300px;" src="/bitrix/php_interface/include/sale_payment/interkassa/images/logo_interkassa.png"/>

<form name="payment_interkassa" id="InterkassaForm" action="javascript:selpayIK.selPaysys()" method="POST">
<?php foreach ($dataForm as $key => $value)
    echo "<input type='hidden' name='$key' value='$value'>";
?>
<button class="btn btn-lg btn-success" type="submit"><?=GetMessage("SCI_BTN_PAY")?> </button>
</form>
<?php
if($interkassa->api_enable) {
   include(dirname(__FILE__) . '/modal_ps.php');
}
?>
</div>
<script type="text/javascript">
var selpayIK = {
    actForm: 'https://sci.interkassa.com/',
    req_url: location.href + '&paysys',
//    req_url: '/payment-interkassa/callback.php?paysys',
    selPaysys: function () {
        if($('button.sel-ps-ik').length > 0)
            $('.sel-ps-ik').click()
        else{
            var form = $('form[name="payment_interkassa"]')
            form[0].action = selpayIK.actForm
            setTimeout(function(){form[0].submit()},200)
        }
    },
    paystart : function (data) {
        data_array = (this.IsJsonString(data))? JSON.parse(data) : data
        console.log(data_array);
        var form = $('form[name="payment_interkassa"]');
        if (data_array['resultCode'] != 0) {
            $('input[name="ik_act"]').remove();
            $('input[name="ik_int"]').remove();
            $('form[name="payment_interkassa"]').attr('action', selpayIK.actForm).submit()
        }
        else {
            if (data_array['resultData']['paymentForm'] != undefined) {
                var data_send_form = [];
                var data_send_inputs = [];
                data_send_form['url'] = data_array['resultData']['paymentForm']['action'];
                data_send_form['method'] = data_array['resultData']['paymentForm']['method'];
                for (var i in data_array['resultData']['paymentForm']['parameters']) {
                    data_send_inputs[i] = data_array['resultData']['paymentForm']['parameters'][i];
                }
                $('body').append('<form method="' + data_send_form['method'] + '" id="tempformIK" action="' + data_send_form['url'] + '"></form>');
                for (var i in data_send_inputs) {
                    $('#tempformIK').append('<input type="hidden" name="' + i + '" value="' + data_send_inputs[i] + '" />');
                }
                $('#tempformIK').submit();
            }
            else {
                if (document.getElementById('tempdivIK') == null)
                    $('form[name="payment_interkassa"]').after('<div id="tempdivIK">' + data_array['resultData']['internalForm'] + '</div>');
                else
                    $('#tempdivIK').html(data_array['resultData']['internalForm']);
                $('#internalForm').attr('action', 'javascript:selpayIK.selPaysys2()')
            }
        }
    },
    selPaysys2 : function () {
        var form2 = $('#internalForm');
        var msg2 = form2.serialize();
        $.ajax({
            type: 'POST',
            url: selpayIK.req_url,
            data: msg2,
            success: function (data) {
                selpayIK.paystart2(data.responseText);
            },
            error: function (xhr, str) {
                alert('Error: ' + xhr.responseCode);
            }
        });
    },
    paystart2 : function (string) {
        data_array = (this.IsJsonString(data))? JSON.parse(data) : data;
        console.log(data_array);
        var form2 = $('#internalForm');
        if (data_array['resultCode'] != 0) {
            form2[0].action = selpayIK.actForm;
            $('input[name="ik_act"]').remove();
            $('input[name="ik_int"]').remove();
            $('input[name="sci[ik_int]"]').remove();
            setTimeout(function(){form2[0].submit()},200)
        }
        else {
            $('#tempdivIK').html('');
            if (data_array['resultData']['paymentForm'] != undefined) {
                var data_send_form = [];
                var data_send_inputs = [];
                data_send_form['url'] = data_array['resultData']['paymentForm']['action'];
                data_send_form['method'] = data_array['resultData']['paymentForm']['method'];
                for (var i in data_array['resultData']['paymentForm']['parameters']) {
                    data_send_inputs[i] = data_array['resultData']['paymentForm']['parameters'][i];
                }
                $('#tempdivIK').append('<form method="' + data_send_form['method'] + '" id="tempformIK2" action="' + data_send_form['url'] + '"></form>');
                for (var i in data_send_inputs) {
                    $('#tempformIK2').append('<input type="hidden" name="' + i + '" value="' + data_send_inputs[i] + '" />');
                }
                $('#tempformIK2').submit();
            }
            else {
                $('#tempdivIK').append(data_array['resultData']['internalForm']);
            }
        }
    },
    IsJsonString : function(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }
}

$(document).ready(function () {
    $('body').prepend('<div class="blLoaderIK"><div class="loaderIK"></div></div>');
    var checkSelCurrPS = []

    $('.ik-payment-confirmation').click(function (e) {
        e.preventDefault();

        var pm = $(this).closest('.payment_system');
        var ik_pw_via = $(pm).find('.radioBtn a.active').data('title')
        if (!$(pm).find('.radioBtn a').hasClass('active') || ($.inArray(ik_pw_via, checkSelCurrPS) == -1)) {
            alert('You did not choose currency');
            return;
        } else {
            if (ik_pw_via.search('test_interkassa|qiwi|rbk') == -1) {
                var form = $('form[name="payment_interkassa"]');
                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'ik_act',
                        val: 'process'
                    }));
                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'ik_int',
                        val: 'json'
                    }));
                $('.blLoaderIK').css('display', 'block');
                $.post(selpayIK.req_url, form.serialize(), function (data) {
                        selpayIK.paystart(data);
                    })
                    .fail(function () {
                        alert('Something wrong');
                    })
                    .always(function () {
                        $('.blLoaderIK').css('display', 'none');
                    })
            }
            else {
                $('form[name="payment_interkassa"]').attr('action', selpayIK.actForm).submit()
            }
        }
        $('#InterkassaModal').hide()
        $('.fade.in').hide()
    });

    $('.radioBtn a').on('click', function () {
        $('.blLoaderIK').css('display', 'block');
        var form = $('form[name="payment_interkassa"]');
        var sel = $(this).data('title');
        var tog = $(this).data('toggle');
        $('#' + tog).prop('value', sel);
        $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass('notActive');
        $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');

        var ik_pw_via = $(this).attr('data-title');
        checkSelCurrPS.push(ik_pw_via)
        if ($('input[name ="ik_pw_via"]').length > 0)
            $('input[name ="ik_pw_via"]').val(ik_pw_via);
        else
            form.append($('<input>', {type: 'hidden', name: 'ik_pw_via', val: ik_pw_via}));

        $.post(selpayIK.req_url, form.serialize())
            .always(function (data, status) {
                $('.blLoaderIK').css('display', 'none');				
                if(status == 'success'){
                    $('input[name="ik_sign"]').val(data);
                }
                else
                    alert('Something wrong');
            })
    })
});
</script>
