# VETTRYX Site Signature

> Plugin de infraestrutura essencial para sites desenvolvidos pela VETTRYX Tech.

Este plugin leve gerencia a identidade corporativa no rodapé dos sites de clientes, garantindo que as datas de copyright estejam sempre corretas e que a assinatura de desenvolvimento permaneça vinculada à marca VETTRYX, mesmo em caso de rebranding.

## 🚀 Funcionalidades

* **Copyright Automático:** Atualiza o ano no rodapé automaticamente a cada virada de ano (ex: 2025 -> 2026), sem necessidade de manutenção manual.
* **Assinatura Conectada:** Exibe "Desenvolvido por: VETTRYX Tech". O nome da agência é buscado via API REST. Se a VETTRYX mudar de nome no futuro, todos os sites de clientes são atualizados automaticamente em até 24h.
* **Cache Inteligente:** Utiliza a Transient API do WordPress para armazenar os dados por 24 horas, garantindo zero impacto na performance do site do cliente.

## 🛠️ Como Usar

### Instalação

1. Baixe o `.zip` deste repositório.
2. Instale via **Plugins > Adicionar Novo**.
3. Ative o plugin.

### Shortcodes

**1. Copyright do Cliente**
Coloque no rodapé do Elementor/Tema:
`[vettryx_copyright]`

**2. Assinatura da Agência**
Coloque ao lado do copyright:
`[vettryx_developer]`

---

**VETTRYX Tech**
*Transformando ideias em experiências digitais.*
