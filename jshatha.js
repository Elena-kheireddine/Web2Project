var slidervideo = document.querySelector('.slider-video');
var videos = ['drillspart1.mp4', 'drillspart2.mp4', 'drillspart3.mp4', 'drillspart4.mp4', 'drillspart5.mp4', 'drillspart6.mp4', 'drillspart7.mp4', 'drillspart8.mp4'];
var i = 0;

function prev() {
    if(i <= 0) i = videos.length;
    --i;
    return setVid();
}

function next() {
    if(i >= videos.length - 1) i = -1;
    ++i;
    return setVid();
}

function setVid() {
    return slidervideo.setAttribute('src', 'images/' + videos[i]);
}

function setNewImage1() {
    document.getElementById("img1").src = "images/headstandpart2.jpeg";
}

function setOldImage() {
    document.getElementById("img1").src = "images/headstandpart1.jpeg"
}