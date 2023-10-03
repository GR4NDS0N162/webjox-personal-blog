const pageSelector = $(`#page-selector`)[0];
const postList = $(`#post-list`)[0];

pageSelector.addEventListener('change', () => updateContent());
pageSelector.dispatchEvent(new Event('change'));

function updateContent() {
    $.ajax({
        url: '/post/get',
        method: 'get',
        dataType: 'json',
        data: {
            page: pageSelector.value
        },
    }).done((data) => {
    });
}
