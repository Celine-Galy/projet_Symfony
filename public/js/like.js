function onClickBtnLike(event) {

    event.preventDefault();

    const url = this.href;
    const spanCount = this.querySelector('.js-likes');
    const icone = this.querySelector('i');

    axios.get(url).then(function(response) {
        spanCount.textContent = response.data.likes;

        if (icone.classList.contains('fas'))
            icone.classList.replace('fas', 'far');
        else
            icone.classList.replace('far', 'fas');
    })
}
document.getElementsByClassName('js-like').forEach(function(link) {
    console.log(link);
    link.addEventListener('click', onClickBtnLike);
})