<div class="register-form form">
    <form method="post" action="register-auth.php">
        <label>
            <span>Username</span>
            <input type="text" name="username" pattern="[\w.-]{1,32}" required>
        </label>
        <label>
            <span>Email</span>
            <input type="email" name="email" required>
        </label>
        <label>
            <span>Password</span>
            <input type="password" name="password" pattern=".{8,32}" required>
        </label>
        <label>
            <span>Confirm password</span>
            <input type="password" required>
        </label>
        <div>
            <span></span>
            <input class="action" type="submit" value="Register">
        </div>
    </form>
    <p>
        Usernames cannot contain more than 32 characters and they may only contain upper/lower case
        alphanumeric characters (A-Z, a-z, 0-9), dot (.), hyphen (-), and underscore (_).
    </p>
    <p>
        Passwords must contain between 8 and 32 characters.
    </p>
</div>