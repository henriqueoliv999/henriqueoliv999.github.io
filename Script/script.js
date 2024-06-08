// Pega o modal
var modal = document.getElementById('modal');

// Pega o <span> que fecha o modal
var span = document.getElementsByClassName('close')[0];

// Quando o usuário clica no <span> (x), fecha o modal
span.onclick = function () {
    modal.style.display = 'none';
}

// Quando o usuário clica fora do modal, fecha o modal
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
