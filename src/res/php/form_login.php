<div class="modal fade" id="form-login" tabindex="-1" aria-labelledby="title-form-login" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-form-login">Accedi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">
                <form id="login-form" method="post">
                    <div class="alert alert-warning d-none" role="alert" id="login-error">
                        Errore di accesso! Controllare email e password!
                    </div>
                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="email-login" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email-login" name="email" required>
                        <div class="invalid-feedback">
                            Controlla la tua email!
                        </div>
                    </div>
                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="pass-login" class="form-label">Password</label>
                        <input type="password" class="form-control" id="pass-login" name="pass" required>
                        <div class="invalid-feedback">
                            Controlla la tua password!
                        </div>
                    </div>


                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-primary" data-bs-target="#form-singup" data-bs-toggle="modal">
                    Registrati
                </button>
                <button type="button" class="btn btn-primary" id="login-confirm-btn">Accedi</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="form-singup" tabindex="-1" aria-labelledby="title-form-singup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-form-singup">Registrati</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">
                <form id="singup-form" method="post">
                    <div class="alert alert-warning d-none" role="alert" id="singup-error">
                        Errore durante la registrazione!
                    </div>
                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="email-singup" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email-singup" name="email" required>
                        <div class="invalid-feedback">
                            Controlla la tua email!
                        </div>
                    </div>

                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="name-singup" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name-singup" name="name" required>
                        <div class="invalid-feedback">
                            Controlla il nome!
                        </div>
                    </div>
                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="surname-singup" class="form-label">Cognome</label>
                        <input type="surname" class="form-control" id="surname-singup" name="surname" required>
                        <div class="invalid-feedback">
                            Controlla il cognome!
                        </div>
                    </div>


                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="pass-singup" class="form-label">Password</label>
                        <input type="password" class="form-control" id="pass-singup" name="pass" required>
                        <div class="invalid-feedback">
                            Controlla la tua password!
                        </div>
                    </div>

                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="confirm-pass-singup" class="form-label">Conferma password</label>
                        <input type="password" class="form-control" id="confirm-pass-singup" name="confirm-pass" required>
                        <div class="invalid-feedback">
                            Le password non corrispondono!
                        </div>
                    </div>


                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-primary" id="singup-confirm-btn">Registrati</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.querySelector("#login-confirm-btn").onclick = function() {

        let form = document.querySelector("#login-form");

        let email = form.querySelector("#email-login");
        let password = form.querySelector("#pass-login");

        let loginError = form.querySelector("#login-error");

        email.classList.remove("is-invalid");
        password.classList.remove("is-invalid");

        loginError.classList.replace("d-block", "d-none");

        let formData = new FormData();
        formData.append("email", email.value);
        formData.append("pass", password.value);

        const url = "/~S5146769/login.php";

        fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(responseText => {
                if (responseText === "loginSuccess") {
                    location.reload();
                } else {
                    if (responseText === "emailError") {
                        email.classList.add("is-invalid");
                    }
                    if (responseText === "passwordError") {
                        password.classList.add("is-invalid");
                    }
                    if (responseText === "loginError") {
                        loginError.classList.replace("d-none", "d-block");
                    }
                }
            })
            .catch(error => {
                loginError.classList.replace("d-none", "d-block");
            });


    }

    document.querySelector("#singup-confirm-btn").onclick = function() {

        let form = document.querySelector("#singup-form");

        let email = form.querySelector("#email-singup");
        let name = form.querySelector("#name-singup");
        let surname = form.querySelector("#surname-singup");
        let password = form.querySelector("#pass-singup");
        let confirm = form.querySelector("#confirm-pass-singup");

        let singupError = form.querySelector("#singup-error");

        email.classList.remove("is-invalid");
        name.classList.remove("is-invalid");
        surname.classList.remove("is-invalid");
        password.classList.remove("is-invalid");
        confirm.classList.remove("is-invalid");

        singupError.classList.replace("d-block", "d-none");

        let formData = new FormData();
        formData.append("email", email.value);
        formData.append("firstname", name.value);
        formData.append("lastname", surname.value);
        formData.append("pass", password.value);
        formData.append("confirm", confirm.value);

        const url = "../../registration.php";

        fetch(url, {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(responseText => {
                if (responseText === "singupSuccess") {
                    location.reload();
                } else {
                    if (responseText === "emailError") {
                        email.classList.add("is-invalid");
                    }
                    if (responseText === "nameError") {
                        name.classList.add("is-invalid");
                    }
                    if (responseText === "surnameError") {
                        surname.classList.add("is-invalid");
                    }
                    if (responseText === "passwordError") {
                        password.classList.add("is-invalid");
                    }
                    if (responseText === "confirmError") {
                        confirm.classList.add("is-invalid");
                    }
                    if (responseText === "singupError") {
                        singupError.classList.replace("d-none", "d-block");
                    }
                }
            })
            .catch(error => {
                singupError.classList.replace("d-none", "d-block");
            });


    }
</script>