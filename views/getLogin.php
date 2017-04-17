<div class="main-content wrapper">
    <h1>Qui êtes-vous ?</h1>
    <form action="index.php"
          method="post">
        <fieldset>
            <legend>Vos infos</legend>
            <div>
                <label for="email" class="textfield ">
                    <input type="text"
                           id="email"
                           name="email">
                    <span class="textfield__label">Votre email</span></label>
            </div>
            <div>
                <label for="password" class="textfield">
                    <input type="password"
                           id="password"
                           name="password">
                    <span class="textfield__label">Votre mot de passe</span></label>
            </div>
            <input type="hidden"
                   name="a"
                   value="postLogin">
            <input type="hidden"
                   name="r"
                   value="auth">

            <div><input type="submit"
                        value="vérifier"
                        class="f-right"></div>
        </fieldset>
    </form>
</div>
