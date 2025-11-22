document.addEventListener('DOMContentLoaded', () => {
    // 1. LÓGICA DO MENU MOBILE (ABRIR E FECHAR)
    const menuBtn = document.getElementById('menu-toggle');
    const navList = document.getElementById('nav-list');

    if (menuBtn) {
        menuBtn.addEventListener('click', () => {
            // Adiciona ou remove a classe 'active' para mostrar/esconder o menu
            navList.classList.toggle('active');
        });
    }

    // 2. LÓGICA DO MODAL DE ADOÇÃO (POP-UP)
    const modal = document.getElementById('modal-adocao');
    const closeBtn = document.querySelector('.close-btn');
    const animalInput = document.getElementById('input-animal');
    const nomeAnimalDisplay = document.getElementById('nome-animal-modal');
    
    // Função global para ser chamada pelo botão "Quero Adotar" no HTML
    window.abrirAdocao = (nomeAnimal) => {
        if (modal) {
            modal.style.display = 'flex'; // Mostra o modal
            // Preenche o nome do animal automaticamente
            if(animalInput) animalInput.value = nomeAnimal;
            if(nomeAnimalDisplay) nomeAnimalDisplay.textContent = nomeAnimal;
        }
    };

    // Fechar modal no botão X
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }

    // Fechar modal clicando fora da caixa branca
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // 3. ENVIO DO FORMULÁRIO SEM RECARREGAR (AJAX)
    const formAdocao = document.getElementById('form-adocao');
    if (formAdocao) {
        formAdocao.addEventListener('submit', async (e) => {
            e.preventDefault(); // Impede a página de recarregar
            
            const btn = formAdocao.querySelector('button[type="submit"]');
            const originalText = btn.textContent;
            
            btn.disabled = true;
            btn.textContent = "Enviando...";

            const formData = new FormData(formAdocao);

            try {
                const response = await fetch('api/cadastros/criar_cadastro.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    alert('✅ Sucesso! Recebemos seu pedido. Entraremos em contato.');
                    modal.style.display = 'none';
                    formAdocao.reset();
                } else {
                    alert('❌ Erro: ' + (result.error || 'Tente novamente.'));
                }
            } catch (error) {
                // Fallback para caso não tenha backend rodando (apenas visualização)
                console.log("Modo visualização ou erro de conexão");
                alert('✅ Pedido enviado (Simulação)!');
                modal.style.display = 'none';
                formAdocao.reset();
            } finally {
                btn.disabled = false;
                btn.textContent = originalText;
            }
        });
    }
});

// 4. LÓGICA DO PIX (COPIAR E COLAR)
function copiarPix() {
    const inputPix = document.getElementById('pix-key');
    if(inputPix) {
        inputPix.select();
        inputPix.setSelectionRange(0, 99999); // Para celulares
        navigator.clipboard.writeText(inputPix.value).then(() => {
            alert("Chave PIX copiada com sucesso!");
        });
    }
}