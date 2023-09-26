const header = document.querySelector("header");

window.addEventListener ("scroll", function(){
    header.classList.toggle ("sticky", window.scrollY > 120);
});


// menu
let menu = document.querySelector('#menu-icon');
let navlist = document.querySelector('.navlist');

menu.onclick = () => {
    menu.classList.toggle('bx-x');
    navlist.classList.toggle('active');
};

window.onscroll = () =>{
    menu.classList.remove('bx-x');
    navlist.classList.remove('active');
}

// question js

const btns = document.querySelectorAll(".question-btn");

btns.forEach(function (btn) {
    btn.addEventListener("click", function (e) {
        const question = e.currentTarget.parentElement.parentElement
        question.classList.toggle("show-text");
    })
});
