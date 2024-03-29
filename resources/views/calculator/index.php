<?php
    use App\Calculator\Requests\CreditRequest;
?>

<div class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h2> 
            <?= $this->pageTitle ?>
        </h2>
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
                        <input type="number" class="form-control" id="amount-loan" placeholder="" amount value="100000" required="">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="period">Период, месяцев</label>
                        <input type="number" class="form-control" id="period-loan" placeholder="" period value="6" required="">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="downPayment">Первоначальный взнос</label>
                        <input type="number" class="form-control" id="downPayment-loan" placeholder="" down-payment value="0" required="">
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
                        <input type="number" class="form-control" id="amount-installment" amount placeholder="" value="100000" required="">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="period">Период, месяцев</label>
                        <input type="number" class="form-control" id="period-installment" period placeholder="" value="6" required="">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="downPayment">Первоначальный взнос</label>
                        <input type="number" class="form-control" id="downPayment-installment" down-payment placeholder="" value="0" required="">
                    </div>
                </form>
            </div>
            <button class="btn btn-primary btn-lg btn-block" id="calc-installment-submit" data-type-form="installment" calc-submit type="button">Узнать условия кредита</button>
        </div>
    </div>
</div>


<script src="/js/processSendForm.js"></script>
<script>
$( document ).ready(function() {
    $(this).processSendForm($('body'));
});

</script>