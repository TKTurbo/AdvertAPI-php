let retrieveID;
let retrieveResult;

let removeID;
let removeResult;

let creationType;
let creationContent;
let editID;
let editContent;
let editType;

let createInfo;
let editInfo;

let allEntries;

window.onload = function () {
    console.log('Script loaded!')
    retrieveResult = document.getElementById('retrieveResult');
    retrieveID = document.getElementById('retrieveID');
    creationType = document.getElementById('creationType');
    creationContent = document.getElementById('creationContent');

    editID = document.getElementById('editID');
    editContent = document.getElementById('editContent');
    editType = document.getElementById('editType');

    createInfo = document.getElementById('createInfo');
    editInfo = document.getElementById('editInfo');

    removeID = document.getElementById('removeID');
    removeResult = document.getElementById('removeResult');

    allEntries = document.getElementById('allEntries');
}

/**
 * for retrieving data
 */
function retrieve() {  // TODO: sanitize?
    const url = window.location.origin + '/?id=' + retrieveID.value;
    // axios.get(url, (req, res) => {
    //     console.log(res);
    // }

    console.log(url);
    axios.get(url, {}).then(function (res) {
        console.log(res.headers["content-type"]);
        if (res.headers["content-type"].startsWith('image')) {
            retrieveResult.innerHTML = '<img src="' + res.config.url + '">'
        } else {
            retrieveResult.innerHTML = res.data;
        }
    })
        .catch(function (error) {
            console.log(error);
        });
}

function create() { // TODO: sanitize?
    const url = window.location.origin + '/create' + window.location.search; // window.location.search is the parameter including the key
    axios.post(url, {
        content: creationContent.value,
        type: creationType.value
    })
        .then(function (response) {
            console.log(response);
            createInfo.innerHTML = response.data;
        })
        .catch(function (error) {
            console.log(error);
        });
}

function edit() { // TODO: sanitize?
    const url = window.location.origin + '/edit' + window.location.search; // window.location.search is the parameter including the key
    axios.post(url, {
        id: editID.value,
        content: editContent.value,
        type: editType.value
    })
        .then(function (response) {
            console.log(response);
            editInfo.innerHTML = response.data;
        })
        .catch(function (error) {
            console.log(error);
            console.log(editInfo)
            editInfo.innerHTML = error.data;
        });
}

function remove() {
    const url = window.location.origin + '/remove' + window.location.search; // window.location.search is the parameter including the key
    axios.post(url, {
        id: removeID.value,
    })
        .then(function (response) {
            console.log(response);
            removeResult.innerHTML = response.data;
        })
        .catch(function (error) {
            console.log(error);
            removeResult.innerHTML = error.data;
        });
}

function getAllEntries() {
    const url = window.location.origin + '/all' + window.location.search;

    console.log(url);
    axios.get(url).then(function (res) {
        console.log(res.data);
        // allEntries.innerHTML = res.data;
        for (i = 0; i < res.data.length; i++) {
            let tableEntry = `
                <tr>
                    <td>${res.data[i].ID}</td>
                    <td>${res.data[i].content}</td>
                    <td>${res.data[i].type}</td>
                </tr>
            `
            allEntries.insertAdjacentHTML( 'beforeend', tableEntry );
        }
    })
        .catch(function (error) {
            console.log(error);
        });
}