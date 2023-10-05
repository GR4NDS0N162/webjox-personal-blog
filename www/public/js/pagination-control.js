$('#pagination-control')[0].addEventListener('change', function () {
    window.location = this.options[this.selectedIndex].value;
});
$('#count-per-page')[0].addEventListener('change', function () {
    window.location = this.getAttribute('data-redirect-location').replace(/__count__/g, this.value);
});
