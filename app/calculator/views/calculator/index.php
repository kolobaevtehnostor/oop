
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Два калькулятора Д/З</title>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>

    <body class="bg-light">
        <div class="container">
            <div class="py-5 text-center">
                <img class="d-block mx-auto" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
                <h2>Два калькулятора</h2>
                <p class="lead">Создать два калькулятора:
                    <a href="#calc1">Калькулятор рассрочки</a>,
                    <a href="#calc2">Калькулятор кредитования</a>
                </p>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-5 order-md-2">
                    <h4 class="d-flex justify-content-between align-items-center  ">
                    <span class="text-muted">Расчет</span>
                    </h4>
                    <ul class="list-group load-loan-result">
                    </ul>
                </div>
                <div class="col-md-7 order-md-1">
                    <h4 class="">Калькулятор кредитования</h4>
                    <form class="needs-validation" id="loan" novalidate="">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="amount">Сумма, рублей</label>
                                <input type="text" class="form-control" id="amount-loan" placeholder="" amount value="100000" required="">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="period">Период, месяцев</label>
                                <input type="text" class="form-control" id="period-loan" placeholder="" period value="6" required="">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="downPayment">Первоначальный взнос</label>
                                <input type="text" class="form-control" id="downPayment-loan" placeholder="" down-payment value="0" required="">
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-primary btn-lg btn-block" id="calc-loan-submit" data-type-form="loan" calc-submit type="button">Узнать условия кредита</button>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-5 order-md-2">
                    <h4 class="d-flex justify-content-between align-items-center  ">
                    <span class="text-muted">Расчет</span>
                    </h4>
                    <ul class="list-group load-installment-result">
                    </ul>
                </div>
                <div class="col-md-7 order-md-1">
                    <h4 class="">Калькулятор рассрочки</h4>
                        <form class="needs-validation" id="installment" novalidate="">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="amount">Сумма, рублей</label>
                                <input type="text" class="form-control" id="amount-installment" amount placeholder="" value="100000" required="">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="period">Период, месяцев</label>
                                <input type="text" class="form-control" id="period-installment" period placeholder="" value="6" required="">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="downPayment">Первоначальный взнос</label>
                                <input type="text" class="form-control" id="downPayment-installment" down-payment placeholder="" value="0" required="">
                            </div>
                        </form>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" id="calc-installment-submit" data-type-form="installment" calc-submit type="button">Узнать условия кредита</button>
                </div>
            </div>
        </div>
    </body>
</html>


<script>

$( document ).ready(function() {
        $(this).processSendForm($('body'));
    });

    $.fn.processSendForm = function (view, requestData) {
        let attributes = {
            amount              : '[amount]',
            period              : '[period]',
            downPayment         : '[down-payment]',
            submitButton        : '[calc-submit]',
            typeCalculator      : '',
            annualInterestRate  : "4.71" 
        },
        process = {
            init: function () {

                view.on('click', attributes.submitButton, callBackActions.onSubmit);
                
                return this;
            },
            getInput: function (input) {
                return $('#' + attributes.typeCalculator + ' ' + input).val();
            },
            postData: function(type) {
                let id = $(attributes.inputId).val();
                $.post( 'http://oop.lan/?c=calculator&a=calculate', { 
                    amount: this.getInput(attributes.amount),
                    period: this.getInput(attributes.period),
                    downPayment: this.getInput(attributes.downPayment),
                    typeCalculator: type,
                    annualInterestRate: "4.71" 
                }).done(callBackActions.onResponseDone);
            }, 
        },
        callBackActions = {
            onResponseDone: function (data) {
                console.log(123);
                $('.load-' + attributes.typeCalculator + '-result').html('');
                $.each(data, function(index, value) {
                $('.load-' + attributes.typeCalculator + '-result').append(
                        '<li class="list-group-item d-flex justify-content-between lh-condensed">' +
                                '<div>' +
                                '<h6 class="my-0">' + value.name + '</h6>' +
                                '</div>' +
                                '<span class="text-muted">' +  value.value + '</span>' +
                        '</li>'
                    );
                });
            },
            onSubmit: function () {
                attributes.typeCalculator = $(this).data('type-form');
                process.postData(attributes.typeCalculator);

                return this;
            },
        };
        
        process.init();

        return this;
    }

</script>