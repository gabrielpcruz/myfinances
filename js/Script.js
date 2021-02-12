var Script = (function () {

    let uuid = function () {

        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    };

    let getFilePathName = function () {
        let reg = new RegExp('[A-Za-z_]{1,}\.html');
        let result = reg.exec(window.location.pathname);

        return result[0];
    };

    let isHome = function () {
        return getFilePathName() == 'index.html';
    };

    let isUpdate = function () {
        return getParamUrl('id');
    };

    let isDeposit = function () {
        return getFilePathName() == 'deposit.html';
    };

    let isDraft = function () {
        return getFilePathName() == 'draft.html';
    };

    let isTransfer = function () {
        return getFilePathName() == 'transfer.html';
    };

    let isAccountStatement = function () {
        return getFilePathName() == 'account_statement.html';
    };

    let goHome = function () {
        let currentPath = window.location.pathname;
        let currentFile = getFilePathName();

        location.href = currentPath.replace(currentFile, 'index.html');
    };

    let getParamUrl = function ($param) {
        let url = new URL(location.href);
        return url.searchParams.get($param);
    };

    let getNewTransaction = function (accountId) {
        return {
            id: uuid(),
            accountId,
            date: new Date(),
            value: 0,
            description : ""
        }
    };

    return {
        uuid: uuid,
        isHome: isHome,
        isUpdate: isUpdate,
        isDeposit: isDeposit,
        isDraft: isDraft,
        isTransfer: isTransfer,
        isAccountStatement: isAccountStatement,
        goHome: goHome,
        getParamUrl : function ($param) {
            return getParamUrl($param)
        },
        getNewTransaction:getNewTransaction
    }
})();
