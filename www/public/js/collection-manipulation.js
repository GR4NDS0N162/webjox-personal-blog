for (const container of $(`fieldset[name="list"]`)) {
    const currentIndex = container.childNodes.length - 3;
    container.setAttribute('current-index', currentIndex);
}

function add_item(button) {
    const container = getContainerOfButton(button);
    const containerId = container.getAttribute('id');
    let template = $(`#${containerId} [data-template]`)[0];
    template = template.getAttribute('data-template');

    const currentIndex = container.getAttribute('current-index');
    container.appendChild(new DOMParser().parseFromString(template.replace(/__index__/g, currentIndex), "text/html").body.firstElementChild);

    container.setAttribute('current-index', parseInt(currentIndex, 10) + 1);
}

function delete_item(button) {
    const container = getContainerOfButton(button);
    const btnName = button.getAttribute('name');
    const element = container.querySelector(`[name="${btnName.slice(0, btnName.length - '[delete]'.length)}"]`).parentNode;

    container.removeChild(element);
}

function getContainerOfButton(button) {
    const containerId = button.getAttribute('data-container-id');
    return $(`#${containerId}`)[0];
}
