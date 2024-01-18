const url = `${window.location.protocol}//auth${window.location.hostname.replace(window.location.hostname.split(".")[0], "")}/`;
console.log(url)
import(url)
    .then(async (Authentication) => {
        // You can use Authentication in this block
        Authentication = Authentication.default;
        const auth = new Authentication(window.location.protocol == "http:");

        try {
            let response = await auth.loginWithTokenFromCookie();
            console.log(response);
            if (response == false) {
                if (window.location.pathname != "/") {
                    window.location.href = "/";
                }
            } else {
                if (window.location.pathname == "/") {
                    window.location.href = "/apps";
                }
            }
            stopLoading();
        } catch (error) {
            console.log(error.responseJSON);
            if (window.location.pathname != "/") {
                window.location.href = "/";
            }
        }
        stopLoading();

        $("#login-form").on("submit", async (e) => {
            startLoading();
            try {
                var data = await auth.login($("#login-form #username").val(), $("#login-form #password").val());
                window.location.href = "/apps";
            } catch (error) {
                console.log(error.responseJSON);
            }
            stopLoading();
        });
        $("#login-form toggle#show-password").on("toggle", (_, data) => {
            const value = data.value;
            if (value) {
                $("#login-form #password").attr("type", "text");
            } else {
                $("#login-form #password").attr("type", "password");
            }
        });
        $("#logout").on("click", async () => {
            startLoading();
            try {
                auth.logout();
                window.location.href = "/";
            } catch (error) {
                console.log(error.responseJSON);
            }
            stopLoading();
        });
    })
    .catch((error) => {
        console.error(`Error importing module: ${error}`);
    });
