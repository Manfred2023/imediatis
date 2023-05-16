let form = document.getElementById('formAuthentication');



form.addEventListener('submit', function(ok){
    let email = document.getElementById('email');
    let password = document.getElementById('password');
    if(email.trim() == "" || password.trim() == ""){
        let error = document.getElementById('error');
        error.innerHTML = "please complete all fields";
        error.style.color= "red";
        ok.preventDefault();
    }
})