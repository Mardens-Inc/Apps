import("/assets/lib/mardens-auth-lib.js")
    .then(async (Authentication) => {
        Authentication = Authentication.default;
        const auth = new Authentication(window.location.protocol === "http:");

        await handleLoginWithTokenFromCookieResponse(auth);
        addLoginFormSubmitHandler(auth);
        addShowPasswordToggleHandler();
        addLogoutClickHandler(auth);
    })
    .catch((error) => {
        console.error(`Error importing module: ${error}`);
    });

/**
 * Handles the response from a login attempt using a token from a cookie.
 *
 * @param {Authentication} auth - The authentication object.
 * @return {void}
 */
async function handleLoginWithTokenFromCookieResponse(auth) {
    try {
        let response = await auth.loginWithTokenFromCookie();
        if (!response && window.location.pathname !== "/") {
            window.location.href = "/";
        } else if (response && window.location.pathname === "/") {
            window.location.href = "/apps";
        }
        stopLoading();
    } catch (error) {
        handleErrorResponse(error);
    }
    stopLoading();
}

/**
 * Handle error response.
 *
 * @param {Object} error - The error object.
 */
function handleErrorResponse(error) {
    let errorObject = error.responseJSON || error;
    console.error(errorObject);
    if (errorObject !== error && window.location.pathname !== "/") {
        window.location.href = "/";
    }
}

/**
 * Adds form submit handler to the login form.
 *
 * @param {Authentication} auth - An authentication object.
 * @returns {void}
 */
function addLoginFormSubmitHandler(auth) {
    $("#login-form").on("submit", async () => {
        startLoading();
        try {
            await auth.login($("#login-form #username").val(), $("#login-form #password").val());
            window.location.href = "/apps";
        } catch (error) {
            console.log(error.responseJSON);
            $("#login-form .error").html(error.responseJSON.message);
        }
        stopLoading();
    });
}

/**
 * Adds a show password toggle handler to the login form.
 *
 * @returns {void}
 */
function addShowPasswordToggleHandler() {
    $("#login-form toggle-field#show-password").on("toggle", (_, data) => {
        $("#login-form #password").attr("type", data.value ? "text" : "password");
    });
}

/**
 * Adds a click handler to the logout button, which logs out the user and redirects to the home page.
 *
 * @param {Authentication} auth - The authentication object used for logging out the user.
 * @return {void}
 */
function addLogoutClickHandler(auth) {
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
}
