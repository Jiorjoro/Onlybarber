onbeforeunload = sessionStorage.clear();

function loadFeed(page) {
    if(window.pageYOffset + window.innerHeight >= (document.documentElement.scrollHeight - 700)) {
        // verifica se o ajax está em espera
        if(sessionStorage.feedLStatus != 'exec' && Number(sessionStorage.lastPostId) != 1) {
            // define que o ajax está sendo processado
            sessionStorage.feedLStatus = 'exec';
            // verifica a sessão
            if(!(Number(sessionStorage.lastPostId) > 0)){
                sessionStorage.lastPostId = 0;
            }

            const feedReq = new XMLHttpRequest();

            feedReq.onreadystatechange = function () {
                if(this.readyState == 4 && this.status == 200) {
                    const resp = JSON.parse(this.responseText);
                    document.querySelector("div.feedTray").innerHTML += resp.posts;
                    sessionStorage.lastPostId = resp.lastPostId;
                    sessionStorage.feedLStatus = 'done';
                }
            }

            feedReq.open("POST", "../php/loadFeedAjax.php");

            feedReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            const data = {action: page, lastPostId: sessionStorage.lastPostId};
            const toSend = "data=" + JSON.stringify(data); 
            /*let toSend = "action="+page+"&lastPostId="+sessionStorage.lastPostId;*/

            feedReq.send(toSend);

        }
    }
}

function likePost(like, postId) {
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

    req.open("POST", "../php/postLikeAjax.php");
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const toSend = "postId=" + postId;
    req.send(toSend);
}

function showComments(postId) {
    const commBox = document.querySelector("div.feedTray div.post div#postComm" + postId);
    const commForm = document.querySelector("div.feedTray div#post" + postId + " form");

    commBox.classList.toggle("hidden");
    commForm.classList.toggle("hidden");
}

function sendPostComment(form, postId) {
    const userCommBox = form.elements[0];
    const userComm = userCommBox.value;

    event.preventDefault();

    if(userComm.replaceAll(' ', '').length > 0){
        const commBox = document.querySelector("div.feedTray div.post #postComm" + postId);
        const commTotBox = document.querySelector("div.feedTray div#post"+postId+" .feather-message-square span");

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
                    commTotBox.innerHTML = resp.totComms;
                }
            }
        }

        req.open("POST", "../php/postCommAjax.php");
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        const toSend = "userComm=" + userComm + "&postId=" + postId;
        req.send(toSend);
    }
}

function sharePost(postId) {
    document.getElementById("post" + postId).focus();
    let link = 'https://www.onlybarber.net/pages/sharePost.php?postId=' + postId;
    let share = {url:link};
    
    navigator.clipboard.writeText(link);
    navigator.share(share);
}

function deletePost(postId, postUserId) {
    if(confirm("Quer Realmente Deletar?")){
        const ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                resp = JSON.parse(this.responseText);

                if(resp.error !== 0){
                    alert("Não foi possível deletar a postagem");
                } else {
                    alert("Postagem Deletada");
                    document.location.reload(true);
                }
            }
        }

        ajax.open("POST", "../php/deletePostAjax.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        const toSend = "postId=" + postId + "&postUserId=" + postUserId;
        ajax.send(toSend);
    }
}

function reportPost(postId){

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

    request.open("POST", "../php/postReportAjax.php");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const toSend = "postId=" + postId;
    request.send(toSend);    
}

function deleteComment(commentId, commentUserId) {
    if(confirm("Quer Realmente Deletar?")){
        const ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                resp = JSON.parse(this.responseText);

                if(resp.error !== 0){
                    alert("Não foi possível deletar o comentário");
                } else {
                    alert("Comentário Deletado");
                    document.location.reload(true);
                }
            }
        }

        ajax.open("POST", "../php/deletePostCommAjax.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        const toSend = "commentId=" + commentId + "&commentUserId=" + commentUserId;
        ajax.send(toSend);
    }
}