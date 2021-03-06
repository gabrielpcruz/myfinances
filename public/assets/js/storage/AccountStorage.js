var AccountStorage = (function () {

    let store = function ($object) {

        let accounts = window.localStorage.getItem('accounts') || false;

        if (!accounts) {
            accounts = [$object];
            window.localStorage.setItem('accounts', JSON.stringify(accounts));
        } else {
            accounts = JSON.parse(accounts);
            accounts.push($object);

            window.localStorage.setItem('accounts', JSON.stringify(accounts));
        }
    };

    let update = function ($object) {
        let accounts = getAll();

        let indexAccount = false;
        let idToBeUpdate = $object.id;

        accounts.forEach(function (current, index) {
            if (current.id == idToBeUpdate) {
                indexAccount = index;
            }
        })

        accounts[indexAccount] = $object;

        window.localStorage.setItem('accounts', JSON.stringify(accounts));
    };

    var isDifferent = function ($id) {
        return function (value) {
            return value.id != $id
        }
    };

    let del = function ($objectId) {
        let accounts = getAll();

        let newAccounts = accounts.filter(isDifferent($objectId));

        window.localStorage.setItem('accounts', JSON.stringify(newAccounts))
    };

    let get = function ($objectId) {

        let accounts = getAll();

        let indexAccount = false;
        let idToBeUpdate = $objectId;

        accounts.forEach(function (current, index) {
            if (current.id == idToBeUpdate) {
                indexAccount = index;
            }
        })

        return accounts[indexAccount];
    };

    let getAll = function () {
        let accounts = window.localStorage.getItem('accounts') || false;

        if (!accounts) {
            throw new Error(Message.MSG002);
        }

        return JSON.parse(accounts);
    };

    let getJsonBackup = function () {
        let accounts = window.localStorage.getItem('accounts') || false;

        if (!accounts) {
            throw new Error("Dont have data");
        }

        return accounts;
    };

    let restore = function ($backup) {
        window.localStorage.setItem('accounts', JSON.stringify($backup))
    };

    return {
        store: function ($object) {
            store($object);
        },
        update: function ($object) {
            update($object);
        },
        del: function ($objectId) {
            del($objectId);
        },
        get: function ($objectId) {
            return get($objectId);
        },
        getAll: function () {
            return getAll();
        },
        getJsonBackup: function () {
            return getJsonBackup();
        },
        restore: function ($backup) {
            return restore($backup);
        }
    }
})();
