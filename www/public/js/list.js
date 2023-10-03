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
        postList.setHTML(getMarkup(data));
    });
}

function getMarkup(list) {
    let markup = '';

    for (const post of list) {
        const id = post.id;
        const content = post.content;

        let postHTML = '';

        postHTML += `<div class="col-12">
            <p class="h4">Post #${id}</p>
        </div>`;
        postHTML += `<div class="col-12">
            <p class="mb-0">${content}</p>
        </div>`;

        postHTML = `<div class="col-12">
            <div class="card p-3">
                <div class="row g-3">${postHTML}</div>
            </div>
        </div>`;

        markup += postHTML;
    }

    return markup;
}
