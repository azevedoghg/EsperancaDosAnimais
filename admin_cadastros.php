<?php require_once 'api/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Adoções - AEA</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="cabecalho">
        <a href="inicio.html"><img src="imagens/logo-extensa.png" alt="logo" class="logo-cabecalho"></a>
        
        <!-- Menu Simples para Admin -->
        <nav class="nav-cabecalho" style="position:static; width:auto; background:transparent; box-shadow:none; flex-direction:row;">
            <a href="admin_animais.php">Novo Animal</a>
            <a href="api/logout.php" style="color:red;">Sair</a>
        </nav>
    </header>

    <main id="admin-container">
        <h2 style="color:var(--primary-blue); text-align:center; margin-bottom:20px;">Candidaturas Recebidas</h2>
        
        <div id="loading" style="text-align:center;">Carregando...</div>
        
        <table>
            <thead>
                <tr>
                    <th>Animal</th>
                    <th>Candidato</th>
                    <th>Contato</th>
                    <th>Detalhes</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="applications-table-body">
                <!-- JS Preenche aqui -->
            </tbody>
        </table>
    </main>

    <footer class="rodape">
        <p>Painel Administrativo - AEA</p>
    </footer>

    <script>
        const API_LISTAR = 'api/cadastros/listar_cadastros.php';
        const API_ATUALIZAR = 'api/cadastros/atualizar_status_cadastro.php';

        async function carregarCandidaturas() {
            const tbody = document.getElementById('applications-table-body');
            const loading = document.getElementById('loading');

            try {
                // Tenta buscar da API
                const res = await fetch(API_LISTAR);
                const data = await res.json();
                
                loading.style.display = 'none';

                if(!Array.isArray(data) || data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" style="text-align:center">Nenhuma candidatura.</td></tr>';
                    return;
                }

                tbody.innerHTML = '';
                data.forEach(app => {
                    const tr = document.createElement('tr');
                    tr.className = `status-${app.status}`;
                    
                    // IMPORTANTE: data-label é usado pelo CSS para o modo Mobile
                    tr.innerHTML = `
                        <td data-label="Animal">${app.animal_nome || 'Indefinido'}</td>
                        <td data-label="Candidato">${app.nome_completo}</td>
                        <td data-label="Contato">
                            ${app.telefone}<br>
                            <small>${app.email}</small>
                        </td>
                        <td data-label="Detalhes">
                            <small>Moradia: ${app.tipo_moradia}</small><br>
                            <small>Motivo: ${app.motivo.substring(0,20)}...</small>
                        </td>
                        <td data-label="Status">${app.status}</td>
                        <td data-label="Ações" class="actions">
                            <button class="btn-approve" onclick="alterarStatus(${app.id}, 'Aprovado')"><i class="fas fa-check"></i></button>
                            <button class="btn-reject" onclick="alterarStatus(${app.id}, 'Reprovado')"><i class="fas fa-times"></i></button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });

            } catch (err) {
                console.error(err);
                loading.innerHTML = '<p style="color:red">Erro ao carregar (Backend Offline?)</p>';
                
                // MOCK DE TESTE SE API FALHAR
                tbody.innerHTML = `
                    <tr class="status-Pendente">
                        <td data-label="Animal">Rex (Teste)</td>
                        <td data-label="Candidato">João Silva</td>
                        <td data-label="Contato">11 9999-9999</td>
                        <td data-label="Detalhes">Casa, quintal grande</td>
                        <td data-label="Status">Pendente</td>
                        <td data-label="Ações" class="actions">
                            <button class="btn-approve">V</button>
                            <button class="btn-reject">X</button>
                        </td>
                    </tr>
                `;
            }
        }

        async function alterarStatus(id, status) {
            if(!confirm(`Mudar para ${status}?`)) return;
            
            try {
                const res = await fetch(API_ATUALIZAR, {
                    method: 'POST',
                    body: JSON.stringify({ id, status })
                });
                const json = await res.json();
                if(json.success) {
                    alert('Atualizado!');
                    carregarCandidaturas();
                } else {
                    alert('Erro: ' + json.error);
                }
            } catch(e) { alert('Erro de conexão'); }
        }

        window.onload = carregarCandidaturas;
    </script>
</body>
</html>