import Authentication from "http://auth.local/";

const auth = new Authentication(true);
auth.loginWithTokenFromCookie().then((data) => {
    console.log(data)
    if (data == false) {
        if (window.location.pathname != "/login.php") {
            window.location.href = "/login.php";
        }
    } else {
        window.location.href = "/";
    }
}).catch((error) => {
    console.log(error.responseJSON);
    if (window.location.pathname != "/login.php") {
        window.location.href = "/login.php";
    }
});


$("#login-form").on("submit", e=>{
    e.preventDefault();
    auth.login($("#login-form #username").val(), $("#login-form #password").val()).then(data=>{
        // window.location.href = "/";
    }).catch(error=>{
        console.log(error.responseJSON);
    });
});