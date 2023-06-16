function msgbox_error(message) {
    $.growl({
        icon: 'fa fa-comments',
        title: ' ',
        message: message,
        url: ''
    }, {
        element: 'body',
        type: 'danger',
        allow_dismiss: true,
        placement: {
            from: 'top',
            align: 'center'
        },
        offset: {
            x: 30,
            y: 30
        },
        spacing: 10,
        z_index: 999999,
        delay: 2500,
        timer: 1000,
        url_target: '_blank',
        mouse_over: false,
        icon_type: 'class',
        template: '<div data-growl="container" class="alert background-danger" role="alert">' +
            '<button type="button" class="close" data-growl="dismiss">' +
            '<span aria-hidden="true">&times;</span>' +
            '<span class="sr-only">Close</span>' +
            '</button>' +
            '<span data-growl="icon"></span>' +
            '<span data-growl="title"></span>' +
            '<span data-growl="message"></span>' +
            '<a href="#" data-growl="url"></a>' +
            '</div>'
    });
};

function msgbox_success(message) {
    $.growl({
        icon: 'fa fa-bell-o',
        title: ' ',
        message: message,
        url: ''
    }, {
        element: 'body',
        type: 'success',
        allow_dismiss: true,
        placement: {
            from: 'top',
            align: 'center'
        },
        offset: {
            x: 30,
            y: 30
        },
        spacing: 10,
        z_index: 999999,
        delay: 2500,
        timer: 1000,
        url_target: '_blank',
        mouse_over: false,
        icon_type: 'class',
        template: '<div data-growl="container" class="alert background-success" role="alert">' +
            '<button type="button" class="close" data-growl="dismiss">' +
            '<span aria-hidden="true">&times;</span>' +
            '<span class="sr-only">Close</span>' +
            '</button>' +
            '<span data-growl="icon"></span>' +
            '<span data-growl="title"></span>' +
            '<span data-growl="message"></span>' +
            '<a href="#" data-growl="url"></a>' +
            '</div>'
    });
};

function redirect_url(url) {
    window.location.href = url;
}

$(function () {
    $('[data-toggle="popover"]').popover({
        trigger: 'focus',
        container: 'body',
        boundary: 'body',
        fallbackPlacement: ['bottom', 'bottom', 'bottom', 'bottom']
    })
})

// ===========================>
const createNewProjectModal = document.getElementById('createNewProject')
const projectName = document.getElementById('project_name')
const projectKey = document.getElementById('project_key')
const projectDescriptions = document.getElementById('project_descriptions')

let flag = false
let alreadyClick = false

createNewProjectModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget
    // const recipient = button.getAttribute('data-bs-whatever')
})

projectName.addEventListener('input', () => {
    if (!flag) {
        text = projectName.value.split(' ').map(str => str.charAt(0).toUpperCase()).join('');
        projectKey.value = removeDiacritics(text)
    }
})

projectKey.addEventListener('input', () => {
    flag = true
    if (projectKey.value == '') {
        flag = false
    }
})
// <===========================

// ===========================>
function removeDiacritics(str) {
    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

document.getElementById("create-project").addEventListener("submit", function (event) {
    event.preventDefault()
});

// <===========================