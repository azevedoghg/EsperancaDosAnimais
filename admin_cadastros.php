<?php require_once 'api/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Gestão de Adoções</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-nav { padding: 10px; background-color: #333; text-align: right; }
        .admin-nav a { color: white; text-decoration: none; padding: 5px 10px; }
        #admin-container {
            width: 95%; margin: 20px auto; padding: 20px;
            background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-radius: 8px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; vertical-align: middle; }
        th { background-color: #f2f2f2; }
        .status-Pendente { background-color: #fffacd; }
        .status-Aprovado { background-color: #d4edda; }
        .status-Reprovado { background-color: #f8d7da; }
        .actions button {
            padding: 5px 10px; margin-right: 5px; border: none;
            border-radius: 4px; cursor: pointer; color: white;
        }
        .btn-approve { background-color: #28a745; }
        .btn-reject { background-color: #dc3545; }
    </style>
</head>
<body>
    <header class="cabecalho">
        <a href="inicio.html" class="link-logo">
            <img src="imagens/logo-extensa.png" alt="logo" class="logo-cabecalho">
        </a>
        <h1 id="cabecalho-h1">Painel de Adoções</h1>
    </header>

    <nav class="admin-nav">
        <a href="admin_animais.php">Cadastrar Novo Animal</a>
        <a href="api/logout.php">Sair (Logout)</a>
    </nav>

    <main id="admin-container">
        <h2>Candidaturas Recebidas</h2>
        <div id="loading">Carregando candidaturas...</div>
        <table>
            <thead>
                <tr>
                    <th>Animal Desejado</th>
                    <th>Candidato(a)</th>
                    <th>Contato</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="applications-table-body">
                <!-- Linhas da tabela serão inseridas aqui pelo JavaScript -->
            </tbody>
        </table>
    </main>

    <script>
        // O JavaScript continua o mesmo da versão anterior, pois a verificação de segurança
        // é feita pelo PHP no topo da página.
        const API_LISTAR_URL = 'api/cadastros/listar.php';
        const API_ATUALIZAR_URL = 'api/cadastros/atualizar_status.php';

        async function carregarCandidaturas() {
            const tableBody = document.getElementById('applications-table-body');
            const loadingDiv = document.getElementById('loading');
            tableBody.innerHTML = '';
            loadingDiv.style.display = 'block';

            try {
                const response = await fetch(API_LISTAR_URL);
                const candidaturas = await response.json();

                loadingDiv.style.display = 'none';

                if (candidaturas.error) {
                    throw new Error(candidaturas.error);
                }

                if (candidaturas.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Nenhuma candidatura encontrada.</td></tr>';
                    return;
                }

                candidaturas.forEach(app => {
                    const tr = document.createElement('tr');
                    tr.className = `status-${app.status}`;
                    tr.innerHTML = `
                        <td>${app.animal_nome}</td>
                        <td>${app.nome_completo}</td>
                        <td>Email: ${app.email}<br>Insta: ${app.instagram}</td>
                        <td>${app.status}</td>
                        <td class="actions">
                            <button class="btn-approve" onclick="atualizarStatus(${app.id}, 'Aprovado')">Aprovar</button>
                            <button class="btn-reject" onclick="atualizarStatus(${app.id}, 'Reprovado')">Reprovar</button>
                        </td>
                    `;
                    tableBody.appendChild(tr);
                });

            } catch (error) {
                loadingDiv.innerHTML = `<p style="color:red;">Erro ao carregar candidaturas: ${error.message}</p>`;
                console.error("Erro:", error);
            }
        }

        async function atualizarStatus(id, novoStatus) {
            if (!confirm(`Tem certeza que deseja alterar o status da candidatura #${id} para "${novoStatus}"?`)) {
                return;
            }

            try {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('status', novoStatus);

                const response = await fetch(API_ATUALIZAR_URL, {
                    method: 'POST',
                    body: formData
                });

                const resultado = await response.json();

                if (resultado.success) {
                    alert('Status atualizado com sucesso!');
                    carregarCandidaturas(); // Recarrega a tabela para mostrar a mudança
                } else {
                    throw new Error(resultado.error);
                }
            } catch (error) {
                alert(`Erro ao atualizar status: ${error.message}`);
                console.error("Erro:", error);
            }
        }

        window.onload = carregarCandidaturas;
    </script>
</body>
</html>
