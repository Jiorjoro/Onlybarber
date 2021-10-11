function storyArrows() {
	const char = event.keyCode || event.which;
	if(char == 37){
        changeStory(-1);
	} else if(char == 39){
        changeStory(1);
    }
}

var storyIndex = 1;
function loadStory(userId) {
    const container = document.querySelector(".storyContainer");
    container.classList.toggle("hidden");

    const ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            console.log(this.responseText);
            container.innerHTML = this.responseText;
            showStory(storyIndex);
            window.addEventListener('keydown', storyArrows);
        }
    }

    ajax.open("POST", "../php/loadStoryAjax.php");
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send("storyUserId="+userId);
}

function closeStory() {
    const story = document.getElementsByClassName("storyContainer")[0];
    
    story.classList.toggle("hidden");
    story.innerHTML = "";
}

function showStory(n) {
    var i;
    var stories = document.querySelectorAll(".storyContainer .story");
    if (n > stories.length) {
        storyIndex = 1;
    }
    if (n < 1) {
        storyIndex = stories.length;
    }
    for (i = 0; i < stories.length; i++) {
        stories[i].classList.add("hidden");
    }
    stories[storyIndex-1].classList.remove("hidden");
}

function changeStory(direction) {
    showStory(storyIndex += direction);
}

function likeStory(like, storyId) {
    const req = new XMLHttpRequest();

    req.onreadystatechange = function (){
        if(this.readyState == 4 && this.status == 200){
            const resp = JSON.parse(this.responseText);
            
            if(resp.error == 1){
                if(confirm('É necessário estar logado!\nClique OK para se cadastrar.')){
                    window.location.href='../pages/cadastro.php';
                }
            } else {
                like.src = resp.class;
                like.nextElementSibling.innerHTML = resp.totLike;
            }
        }
    }

    req.open("POST", "../php/storyLikeAjax.php");
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const toSend = "storyId=" + storyId;
    req.send(toSend);
}

function toggleComm(storyId) {
    const commBox = document.querySelector(".storyContainer #story"+storyId+" .story-comments");
    const newComm = document.querySelector(".storyContainer #story"+storyId+" form");
    const setinhaChata1 = document.querySelectorAll(".storyContainer #story"+storyId+" .story-media i")[0];
    const setinhaChata2 = document.querySelectorAll(".storyContainer #story"+storyId+" .story-media i")[1];

    commBox.classList.toggle("hidden");
    newComm.classList.toggle("hidden");
    setinhaChata1.classList.toggle("hidden");
    setinhaChata2.classList.toggle("hidden");
}

function sendStoryComment(form, storyId) {
    const userCommBox = form.elements[0];
    const userComm = userCommBox.value;

    event.preventDefault();

    if(userComm.replaceAll(' ', '').length > 0){
        const commBox = document.querySelector(".storyContainer #story"+storyId+" .story-comments");

        userCommBox.value = "";

        const req = new XMLHttpRequest();

        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                
                const resp = JSON.parse(this.responseText);

                if(resp.error == 1){
                    if(confirm('É necessário estar logado!\nClique OK para se cadastrar.')){
                        window.location.href='../pages/cadastro.php';
                    }
                } else {
                    commBox.innerHTML = resp.comms;
                    commBox.scrollTop = commBox.scrollHeight;
                }      
            }
        }

        req.open("POST", "../php/storyCommAjax.php");
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        const toSend = "userComm=" + userComm + "&storyId=" + storyId;
        req.send(toSend);
    }
}

function deleteStory(storyId, storyUserId) {
    if(confirm("Quer Realmente Deletar?")){
        const ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                resp = JSON.parse(this.responseText);

                if(resp.error != 0){
                    alert("Não foi possível deletar o Story");
                } else {
                    alert("Story Deletado");
                    document.location.reload(true);
                }
            }
        }

        ajax.open("POST", "../php/deleteStoryAjax.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        const toSend = "storyId=" + storyId + "&storyUserId=" + storyUserId;
        ajax.send(toSend);
    }
}

function reportStory(storyId){

    const request = new XMLHttpRequest();

    request.onload = function(){
		const resp = JSON.parse(this.responseText);
        if(resp.error == 1){
            if(confirm('É necessário estar logado!\nClique OK para se cadastrar.')){
                window.location.href='../pages/cadastro.php';
            }
        } else {
            alert(resp.msg);
        }
    }

    request.open("POST", "../php/storyReportAjax.php");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const toSend = "storyId=" + storyId;
    request.send(toSend);    
}

function deleteComment(commentId, commentUserId) {
    if(confirm("Quer Realmente Deletar?")){
        const ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                resp = JSON.parse(this.responseText);

                if(resp.error != 0){
                    alert("Não foi possível deletar o comentário");
                } else {
                    alert("Comentário Deletado");
                    document.location.reload(true);
                }
            }
        }

        ajax.open("POST", "../php/deleteStoryCommAjax.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        const toSend = "commentId=" + commentId + "&commentUserId=" + commentUserId;
        ajax.send(toSend);
    }
}