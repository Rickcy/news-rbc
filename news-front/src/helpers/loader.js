module.exports = {
    get loader() {
        let divs = document.getElementsByClassName('spinner-wrapper');
        return divs[0];
    },
    show() {
        this.loader.style.display = 'block'
    },
    hide() {
        setTimeout(() => {
            this.loader.style.display = 'none'
        }, 500);

    }
};