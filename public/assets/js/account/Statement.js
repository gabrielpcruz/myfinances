var Account = (function () {

    let createNewStatment = function () {
        $(document).on("click", "#save", function (event) {
            event.preventDefault();

            try {
                if (isAnyFieldEmpty()) {
                    throw new Error(Message.MSG001);
                }

                let balance = $("#newAccountForm #initialBalance").val().replace("R$", '');
                balance = balance.replace('.', '');
                balance = balance.replace(',', '.').trim();


                let targetValue = $("#newAccountForm #targetValue").val().replace('R$', '');
                targetValue = targetValue.replace('.', '');
                targetValue = targetValue.replace(',', '.').trim();


                let account = {
                    id: Script.uuid(),
                    accountName: $("#newAccountForm #accountName").val(),
                    balance,
                    targetValue,
                    description: $("#newAccountForm #description").val(),
                };

                AccountStorage.store(account);

                Script.goHome();
            } catch (error) {
                toastr.error(error.message);
            }
        });
    };

    

    return {
        init: function () {
            createNewStatment();
        }
    }
})();
