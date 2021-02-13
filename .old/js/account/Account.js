var Account = (function () {

    let createNewAccount = function () {
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

                let transaction = Script.getNewTransaction(account.id);
                transaction.value = balance;
                transaction.description = $("#newAccountForm #description").val();

                AccountStorage.store(account);
                StatementStorage.store(transaction);

                Script.goHome();
            } catch (error) {
                toastr.error(error.message);
            }
        });
    };

    let deleteAnAccount = function () {
        $(document).on("click", ".remove", function (event) {
            event.preventDefault();

            try {
                let id;

                if ($(event.target).is("a")) {
                    id = $(event.target).data('id');
                } else {
                    id = $(event.target).parent().data('id');
                }

                AccountStorage.del(id);

                Script.goHome();
            } catch (error) {
                toastr.error(error.message);
            }
        });
    };

    let updateAnAccount = function () {
        $(document).on("click", "#update", function (event) {
            event.preventDefault();

            try {
                let id = AccountStorage.get(Script.getParamUrl('id')).id;

                let accountOld = AccountStorage.get(id);
                
                accountOld.accountName = $("#newAccountForm #accountName").val();
                accountOld.description = $("#newAccountForm #description").val();

                AccountStorage.update(accountOld);

                Script.goHome();
            } catch (error) {
                toastr.error(error.message);
            }
        });
    };

    let listAllAccounts = function () {
        let accounts = AccountStorage.getAll();

        if (accounts && Script.isHome()) {
            let total = 0;
            accounts.forEach(function (current) {
                total += makeLine(current);
            });

            makeFooter(total);
        }
    };

    let fillAccountUpdate = function () {
        if (Script.isUpdate()) {
            let account = AccountStorage.get(Script.getParamUrl('id'));

            $("#newAccountForm #accountName").val(account.accountName);
            $("#newAccountForm #initialBalance").val(account.balance);
            $("#newAccountForm #targetValue").val(account.targetValue);
            $("#newAccountForm #description").val(account.description);
        }
    };

    let fillAccountSelect = function () {
        if (Script.isDeposit() || Script.isDraft()) {
            let accounts = AccountStorage.getAll();

            accounts.forEach(function (element) {
                let option = $("<option>");
                option.attr("value", element.id);
                option.text(element.accountName);

                $("#selectAccounts").append(option);
            });
        }

        if (Script.isTransfer()) {
            let accounts = AccountStorage.getAll();

            accounts.forEach(function (element) {
                let optionOrigin = $("<option>");
                optionOrigin.attr("value", element.id);
                optionOrigin.text(element.accountName);

                $("#originAccount").append(optionOrigin);

                let optionTarget = $("<option>");
                optionTarget.attr("value", element.id);
                optionTarget.text(element.accountName);

                $("#targetAccount").append(optionTarget);

            });
        }

        if (Script.isAccountStatement()) {
            let accounts = AccountStorage.getAll();

            accounts.forEach(function (element) {
                let option = $("<option>");
                option.attr("value", element.id);
                option.text(element.accountName);

                $("#accountStatement").append(option);
            });
        }
    };

    let makeLine = function (current) {
        let tr = $("<tr>");

        let accountName = $("<td>");
        accountName.text(current.accountName);
        
        let objective = $("<td>");
        objective.addClass("text-right");
        objective.addClass("money");
        objective.text("R$ " + current.targetValue);

        let balance = $("<td>");
        balance.addClass("text-right");

        balance.text("R$ " + current.balance);
        balance.addClass("money");


        let targetValue = $("<td>");
        targetValue.addClass("text-right");

        let percentage = ((current.balance * 100) / current.targetValue).toFixed(2);
        targetValue.text(percentage + "%");

        let actions = $("<td>");
        actions.addClass('text-right');

        let delButton = $("<a>");
        delButton.addClass('btn btn-danger text-right text-light');
        delButton.addClass('remove');
        delButton.attr('data-id', current.id);
        delButton.attr('href', '#');

        let updateButton = $("<a>");
        updateButton.addClass('btn btn-info text-right');
        updateButton.addClass('update mr-1 text-light');
        updateButton.attr('data-id', current.id);
        updateButton.attr('href', `update_account.html?id=${current.id}`);

        delButton.text("Delete");
        updateButton.text("Update");

        actions.append(updateButton);
        actions.append(delButton);

        tr.append(accountName);
        tr.append(objective);
        tr.append(balance);
        tr.append(targetValue);
        tr.append(actions);

        $("table tbody").append(tr);

        return parseFloat(current.balance);
    };

    let makeFooter = function (total) {
        $("table tfoot #total").text(total.toFixed(2));
        $("table tfoot #total").mask("#.##0,00", { reverse: true});

        $("table tbody .money").mask("000.000,00");
        $("table tbody .money").mask("000.000,00", { reverse: true});
    };

    let isAnyFieldEmpty = function () {
        return false;
    };

    return {
        init: function () {
            createNewAccount();
            listAllAccounts();
            deleteAnAccount();
            updateAnAccount();
            fillAccountUpdate();
            fillAccountSelect();
        }
    }
})();
