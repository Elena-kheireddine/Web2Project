var sliderimg = document.querySelector('.slider-img');
var images = ['figure5.jpeg', 'figure11.jpeg', 'figure10.jpeg', 'figure9.jpeg', 'figure12.jpeg'];
var i = 0;

function prev() {
    if(i <= 0) i = images.length;
    --i;
    return setImg();
}

function next() {
    if(i >= images.length - 1) i = -1;
    ++i;
    return setImg();
}

function setImg() {
    return sliderimg.setAttribute('src', 'images/' + images[i]);
}

document.getElementById("top").innerHTML = "Aerial Yoga"