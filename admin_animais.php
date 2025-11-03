<?php require_once 'api/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Cadastrar Animal</title>
    
    <!-- Adiciona uma base de URL para que todos os links (CSS, actions) funcionem corretamente -->
    <href="/projeto-adocao/">

    <link rel="stylesheet" href="style.css">
</head>
<body id="pag-admin">
    <header class="cabecalho-admin">
        <h1>Painel Administrativo</h1>
        <nav>
            <a href="admin_animais.php" class="active">Cadastrar Animal</a>
            <a href="admin_cadastros.php">Ver Candidaturas</a>
            <a href="api/logout.php">Sair (Logout)</a>
        </nav>
    </header>

    <main class="container-admin">
        <div class="form-container-admin">
            <h2>Cadastrar Novo Animal</h2>
            
            <?php
            // Exibe mensagens de sucesso ou erro que são passadas via URL
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                echo '<p class="mensagem-sucesso">Animal cadastrado com sucesso!</p>';
            }
            if (isset($_GET['status']) && $_GET['status'] == 'error') {
                echo '<p class="mensagem-erro">Erro ao cadastrar: ' . htmlspecialchars($_GET['message']) . '</p>';
            }
            ?>

            <form action="api/cadastros/criar.php" method="POST" enctype="multipart/form-data">
                
                <label for="nome">Nome do Animal:</label>
                <input type="text" id="nome" name="nome" required>
                
                <label for="especie">Espécie:</label>
                <select id="especie" name="especie" required>
                    <option value="Cachorro">Cachorro</option>
                    <option value="Gato">Gato</option>
                </select>

                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo" required>
                    <option value="Macho">Macho</option>
                    <option value="Fêmea">Fêmea</option>
                </select>
                
                <label for="idade">Idade (texto, ex: '3 meses'):</label>
                <input type="text" id="idade" name="idade" required>
                
                <label for="porte">Porte:</label>
                <select id="porte" name="porte" required>
                    <option value="Pequeno">Pequeno</option>
                    <option value="Médio">Médio</option>
                    <option value="Grande">Grande</option>
                </select>
                
                <label for="castrado">Castrado?</label>
                <select id="castrado" name="castrado" required>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
                
                <label for="vacinado">Vacinado?</label>
                <select id="vacinado" name="vacinado" required>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
                
                <label for="descricao">Descrição / História:</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>
                
                <label for="foto">Foto do Animal:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
                
                <button type="submit">Cadastrar Animal</button>
            </form>
        </div>
    </main>
</body>
</html>

