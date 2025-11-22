<?php require_once 'api/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Animal - AEA</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="cabecalho">
        <a href="inicio.html"><img src="imagens/logo-extensa.png" alt="Logo" class="logo-cabecalho"></a>
        <div class="mobile-menu-icon" id="menu-toggle">
            <span class="bar"></span><span class="bar"></span><span class="bar"></span>
        </div>
        <nav class="nav-cabecalho" id="nav-list">
            <a href="admin_cadastros.php">Ver Candidaturas</a>
            <a href="admin_animais.php">Novo Animal</a>
            <a href="api/logout.php" style="color:red;">Sair</a>
        </nav>
    </header>

    <div class="container-admin">
        <!-- O formulário agora fica dentro deste container limitado e centralizado -->
        <div class="form-container-admin" style="max-width: 900px; margin: 0 auto;"> 
            
            <div class="form-header" style="border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 30px;">
                <!-- Ícone e texto agora em azul escuro para alto contraste no fundo branco -->
                <h2 style="color: var(--primary-blue); display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <i class="fas fa-dog" style="font-size: 1.5em;"></i> Cadastrar Novo Animal
                </h2>
                <p style="color: #666; margin-top: 5px;">Preencha os dados para disponibilizar um animal para adoção.</p>
            </div>
            
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                echo '<div style="background:#d4edda; color:#155724; padding:15px; border-radius:8px; margin-bottom:20px; text-align:center; font-weight:bold; border:1px solid #c3e6cb;"><i class="fas fa-check-circle"></i> Animal cadastrado com sucesso!</div>';
            }
            if (isset($_GET['status']) && $_GET['status'] == 'error') {
                echo '<div style="background:#f8d7da; color:#721c24; padding:15px; border-radius:8px; margin-bottom:20px; text-align:center; font-weight:bold; border:1px solid #f5c6cb;"><i class="fas fa-exclamation-triangle"></i> Erro: ' . htmlspecialchars($_GET['message']) . '</div>';
            }
            ?>

            <form action="api/animais/criar_animal.php" method="POST" enctype="multipart/form-data">
                
                <!-- Linha 1: Nome (Ocupa toda a largura) -->
                <div class="form-group">
                    <label style="font-weight: bold; color: #333;">Nome do Animal</label>
                    <div style="position: relative;">
                        <i class="fas fa-paw" style="position: absolute; left: 15px; top: 15px; color: #aaa;"></i>
                        <input type="text" name="nome" placeholder="Ex: Rex, Mel, Thor" required style="padding-left: 40px;">
                    </div>
                </div>

                <!-- Grid Simétrico (2 Colunas no Desktop) -->
                <div class="form-grid" style="margin-top: 20px;">
                    
                    <!-- Coluna Esquerda -->
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div class="form-group">
                            <label>Espécie</label>
                            <select name="especie" required>
                                <option value="" disabled selected>Selecione...</option>
                                <option value="Cachorro">Cachorro</option>
                                <option value="Gato">Gato</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Sexo</label>
                            <select name="sexo" required>
                                <option value="" disabled selected>Selecione...</option>
                                <option value="Macho">Macho</option>
                                <option value="Fêmea">Fêmea</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Castrado?</label>
                            <select name="castrado" required>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                    </div>

                    <!-- Coluna Direita -->
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div class="form-group">
                            <label>Idade</label>
                            <input type="text" name="idade" placeholder="Ex: 2 anos" required>
                        </div>
                        <div class="form-group">
                            <label>Porte</label>
                            <select name="porte" required>
                                <option value="" disabled selected>Selecione...</option>
                                <option value="Pequeno">Pequeno</option>
                                <option value="Médio">Médio</option>
                                <option value="Grande">Grande</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Vacinado?</label>
                            <select name="vacinado" required>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Área de Texto Grande -->
                <div class="form-group" style="margin-top: 25px;">
                    <label>Descrição / História</label>
                    <textarea name="descricao" rows="4" placeholder="Conte um pouco sobre a personalidade dele..." required style="resize: vertical;"></textarea>
                </div>
                
                <!-- Upload de Imagem Destacado -->
                <div class="form-group" style="margin-top: 20px;">
                    <label>Foto do Animal</label>
                    <div style="border: 2px dashed #ccc; padding: 30px; text-align: center; border-radius: 10px; background: #f8f9fa; transition: 0.3s;" onmouseover="this.style.borderColor='#0449ac'; this.style.background='#eef6ff';" onmouseout="this.style.borderColor='#ccc'; this.style.background='#f8f9fa';">
                        <input type="file" id="foto" name="foto" accept="image/*" required onchange="previewImage(event)" style="display:none;">
                        <label for="foto" style="cursor:pointer; display:block;">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: var(--primary-blue); margin-bottom: 10px;"></i><br>
                            <span style="font-weight: bold; color: #555;">Clique para enviar uma foto</span><br>
                            <small style="color: #888;">(JPG, PNG - Max 2MB)</small>
                        </label>
                        <img id="preview-img" style="max-width: 100%; max-height: 250px; margin-top: 15px; display: none; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-left: auto; margin-right: auto;">
                    </div>
                </div>
                
                <button type="submit" class="btn-submit" style="margin-top: 30px; height: 55px; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <i class="fas fa-save"></i> Salvar Animal
                </button>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('preview-img');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
        
        // Menu Mobile
        const menuToggle = document.getElementById('menu-toggle');
        if(menuToggle) {
            menuToggle.onclick = () => document.getElementById('nav-list').classList.toggle('active');
        }
    </script>
</body>
</html>