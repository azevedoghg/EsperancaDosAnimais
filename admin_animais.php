<?php require_once 'api/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Cadastrar Animal</title>
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome para ícones (opcional, mas recomendado) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body id="pag-admin">
    <header class="cabecalho-admin">
        <div class="logo-admin">
            <!-- Certifique-se de que o caminho da imagem está correto -->
            <img src="imagens/logo-extensa.png" alt="Logo" style="height: 40px; filter: brightness(0) invert(1);">
            <span>Painel Administrativo</span>
        </div>
        <nav>
            <a href="admin_animais.php" class="active"><i class="fas fa-paw"></i> Cadastrar Animal</a>
            <a href="admin_cadastros.php"><i class="fas fa-list-alt"></i> Ver Candidaturas</a>
            <a href="api/logout.php" class="btn-sair"><i class="fas fa-sign-out-alt"></i> Sair</a>
        </nav>
    </header>

    <main class="container-admin">
        <div class="form-container-admin">
            <h2><i class="fas fa-dog"></i> Cadastrar Novo Animal</h2>
            <p class="subtitulo-admin">Preencha os dados abaixo para disponibilizar um animal para adoção.</p>
            
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                echo '<div class="alert success"><i class="fas fa-check-circle"></i> Animal cadastrado com sucesso!</div>';
            }
            if (isset($_GET['status']) && $_GET['status'] == 'error') {
                echo '<div class="alert error"><i class="fas fa-exclamation-circle"></i> Erro ao cadastrar: ' . htmlspecialchars($_GET['message']) . '</div>';
            }
            ?>

            <form action="api/animais/criar_animal.php" method="POST" enctype="multipart/form-data">
                
                <!-- Nome (Linha Inteira) -->
                <div class="form-group">
                    <label for="nome">Nome do Animal</label>
                    <input type="text" id="nome" name="nome" placeholder="Ex: Rex, Mel, Thor" required>
                </div>
                
                <!-- Linha 1: Espécie, Sexo, Idade -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="especie">Espécie</label>
                        <select id="especie" name="especie" required>
                            <option value="" disabled selected>Selecione</option>
                            <option value="Cachorro">Cachorro</option>
                            <option value="Gato">Gato</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sexo">Sexo</label>
                        <select id="sexo" name="sexo" required>
                            <option value="" disabled selected>Selecione</option>
                            <option value="Macho">Macho</option>
                            <option value="Fêmea">Fêmea</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idade">Idade</label>
                        <input type="text" id="idade" name="idade" placeholder="Ex: 2 anos" required>
                    </div>
                </div>

                <!-- Linha 2: Porte, Castrado, Vacinado -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="porte">Porte</label>
                        <select id="porte" name="porte" required>
                            <option value="" disabled selected>Selecione</option>
                            <option value="Pequeno">Pequeno</option>
                            <option value="Médio">Médio</option>
                            <option value="Grande">Grande</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="castrado">Castrado?</label>
                        <select id="castrado" name="castrado" required>
                            <option value="" disabled selected>Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="vacinado">Vacinado?</label>
                        <select id="vacinado" name="vacinado" required>
                            <option value="" disabled selected>Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                </div>
                
                <!-- Descrição -->
                <div class="form-group">
                    <label for="descricao">Descrição / História</label>
                    <textarea id="descricao" name="descricao" rows="4" placeholder="Conte um pouco sobre a história e personalidade dele..." required></textarea>
                </div>
                
                <!-- Upload de Foto com Preview -->
                <div class="form-group">
                    <label>Foto do Animal</label>
                    <div class="upload-preview-container">
                        <label for="foto" class="custom-file-upload">
                            <i class="fas fa-cloud-upload-alt"></i> Escolher Imagem
                        </label>
                        <input type="file" id="foto" name="foto" accept="image/*" required onchange="previewImage(event)">
                        <div id="image-preview-box" class="image-preview-box" style="display: none;">
                            <p>Pré-visualização:</p>
                            <img id="preview-img" src="" alt="Pré-visualização">
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Salvar Cadastro</button>
            </form>
        </div>
    </main>

    <script>
        // Script simples para mostrar a foto antes de enviar
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('preview-img');
                output.src = reader.result;
                document.getElementById('image-preview-box').style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>