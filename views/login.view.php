<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Login</h1>
            <form>
                <div class="input-group">
                    <label for="username">Usuário:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Senha:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Entrar</button>
                <button type="button" class="create-account" onclick="window.location.href='create-account'">Criar uma Conta</button>
            </form>
        </div>
    </div>
</body>
</html>
