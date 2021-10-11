function followUser(userId) {
    const followBox = document.getElementById('followUser');
    const totFollow = document.getElementById('totFollow');

    const ajax = new XMLHttpRequest();
    
    ajax.onreadystatechange = function (){
        if(this.readyState == 4 && this.status == 200){
            const resp = JSON.parse(this.responseText);
            
            if(resp.error == 1){
                if(confirm('É necessário estar logado!\nClique OK para se cadastrar.')){
                    window.location.href='../pages/cadastro.php';
                }
            } else {
                followBox.innerHTML = resp.fb;
                totFollow.innerHTML = resp.tf;
            }
        }
    }

    ajax.open("POST", "../php/followUserAjax.php");
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send("followed="+userId);
}

function openMainNotify() {
    event.preventDefault;
    const notifyBg = document.getElementById('notifications-bg');
    const notifyBox = document.querySelector("div#notifications-bg .notifications .box");

    document.body.style.overflowY = 'hidden';
    notifyBg.style.display = "block";

    const ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function (){
        if(this.readyState == 4 && this.status == 200){
            notifyBox.innerHTML = this.responseText;
        }
    }

    ajax.open("POST", "../php/loadNotificationAjax.php");
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send();
}

function closeMainNotify() {
    const notify = document.getElementById('notifications-bg');

    document.body.style.overflowY = 'scroll';
    notify.style.display = "none";
}

function reportUser(userId) {
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

    request.open("POST", "../php/userReportAjax.php");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const toSend = "repUserId=" + userId;
    request.send(toSend);    
}

function changeBio(form){
    event.preventDefault();
    const bio = form.querySelector("textarea");
    // const hidden = form.querySelector("input[type='hidden']");

    if(bio.textLength > 0){
        const ajax = new XMLHttpRequest();

        ajax.onload = function(){
            alert("Bio Alterada");
        }

        ajax.open("POST", "../php/userConfig.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        const toSend = 'action=bio&bio='+bio.value;
        ajax.send(toSend);
        bio.value = '';
    }
}

function changePass(form){
    event.preventDefault();

    var oldpass = form.querySelector("input[name='oldpass']");
    var newpass = form.querySelector("input[name='newpass']");
    var newpass2 = form.querySelector("input[name='newpass2']");
    var div = form.querySelector("div.erro");

    if(oldpass.value !== "" && newpass.value !== "" && newpass2.value !== ""){
        const ajax = new XMLHttpRequest();

        ajax.onreadystatechange = function (){
            if(this.readyState == 4 && this.status == 200){
                const resp = JSON.parse(this.responseText);

                if(resp.error == ''){
                    form.reset();
                    div.value='';
                    alert("Senha Alterada");
                } else {
                    div.innerHTML = resp.error;
                }
            }
        }

        ajax.open("POST", "../php/userConfig.php");
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        const toSend = 'action=pass&oldpass='+oldpass.value+'&newpass='+newpass.value+'&newpass2='+newpass2.value;
        ajax.send(toSend);
    } else {
        div.innerHTML = "Preencha os Campos";
    }
}

/* para futuras pessoas que lerem meu code,
    é possível que se perguntem pq eu n usei formData que reduziria o code?
    EU TENTEI TÁ, MAS N IA, QUALQUER COISA QUE ACONTECIA ELE JÁ PARAVA DE FUNFA
    então espero que compreendam
    boa noite
*/

function deleteAccount() {
    event.preventDefault();

    if(confirm("Quer DELETAR sua Conta?")){
        if(confirm("Sua CONTA, POSTAGENS e COMENTÁRIOS Serão APAGADOS.\nQuer Realmente DELETAR?")){
            const password = prompt("Confirme a SENHA da Conta", '');

            const ajax = new XMLHttpRequest();

            ajax.onload = function(){
                const resp = JSON.parse(this.responseText);

                if(resp.error == ''){
                    alert("Conta Deletada");
                    window.location.href = "../pages/login.php";
                } else {
                    alert(resp.error);
                }
                console.log(this.responseText);
            }

            ajax.open("POST", "../php/userConfig.php");
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            const toSend = 'action=del&senha='+password;
            ajax.send(toSend);

        }
    }
}