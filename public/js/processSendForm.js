$.fn.processSendForm = function (view, requestData) {
    let attributes = {
        amount              : '[amount]',
        period              : '[period]',
        downPayment         : '[down-payment]',
        submitButton        : '[calc-submit]',
        typeCalculator      : '',
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

            $.post( '/index.php/calculator/calculate', { 
                totalAmount    : this.getInput(attributes.amount),
                period         : this.getInput(attributes.period),
                downPayment    : this.getInput(attributes.downPayment),
                typeCalculator : type,
            }).done(callBackActions.onResponseDone);
        }, 
    },
    callBackActions = {
        onResponseDone: function (data) {
            $('.load-' + attributes.typeCalculator + '-result').html('');


            if ( data.length == 1) {
                $('.load-' + attributes.typeCalculator + '-result').append(
                    '<li class="list-group-item d-flex justify-content-between lh-condensed">' +
                        '<span class="text-muted">' +  data[0] + '</span>' +
                    '</li>'
                );

                return this;
            }

            $.each(data, function(index, resultValue) {
                $.each(resultValue, function(key, value){
                    $('.load-' + attributes.typeCalculator + '-result').append(
                        '<li class="list-group-item d-flex justify-content-between lh-condensed">' +
                            '<div>' +
                            '<h6 class="my-0">' + key + '</h6>' +
                            '</div>' +
                            '<span class="text-muted">' +  value + '</span>' +
                        '</li>'
                    );
                });
            });

            return this;
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