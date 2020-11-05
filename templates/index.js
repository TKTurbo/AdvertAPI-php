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

let creationLink;
let editLink;

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

    creationLink = document.getElementById('creationLink');
    editLink = document.getElementById('editLink');
}

/**
 * for retrieving data
 */
function retrieve() {  // TODO: sanitize?
    const url = getURL() + '?id=' + retrieveID.value;

    console.log(url);
    axios.get(url, {}).then(function (res) {
        console.log(res);
        console.log(res.headers["content-type"]);
        if (res.headers["content-type"].startsWith('image')) {
            retrieveResult.innerHTML =
                `<a href="${getURL()}?linkID=${retrieveID.value}">
                    <img src="${res.config.url}" alt="${getURL()}?linkID=${retrieveID.value}">
                </a>`
            // retrieveResult.innerHTML = res.data;
        } else {
            retrieveResult.innerHTML =
                `<a href="${getURL()}?linkID=${retrieveID.value}">${res.data}
                </a>`
        }
    })
        .catch(function (error) {
            console.log(error);
        });
}

/**
 * Gets link because the image redirect made it impossible to
 */
function getLink() {

}

/**
 * for creating entries
 */
function create() { // TODO: sanitize?
    console.log(creationLink.value)
    const url = getURL() + 'create.php' + window.location.search; // window.location.search is the parameter including the key
    axios.post(url, {
        content: creationContent.value,
        link: creationLink.value,
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
    const url = getURL() + 'edit.php' + window.location.search; // window.location.search is the parameter including the key
    axios.post(url, {
        id: editID.value,
        content: editContent.value,
        link: editLink.value,
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
    const url = getURL() + 'remove.php' + window.location.search; // window.location.search is the parameter including the key
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
    allEntries.innerHTML = '';
    const url = getURL() + 'all.php' + window.location.search;

    console.log(url);
    axios.get(url).then(function (res) {
        console.log(res);
        for (i = 0; i < res.data.length; i++) {
            let tableEntry = `
                <tr>
                    <td>${res.data[i].ID}</td>
                    <td>${res.data[i].content}</td>
                    <td>${res.data[i].link}</td>
                    <td>${res.data[i].type}</td>
                </tr>
            `
            allEntries.insertAdjacentHTML('beforeend', tableEntry);
        }
    })
        .catch(function (error) {
            console.log(error);
        });
}

/**
 * Gets the url without the .php file while still adding the directory. Mostly for development
 */
function getURL() {
    let href = window.location.href;
    return href.substring(0, href.lastIndexOf('/')) + "/";
}
