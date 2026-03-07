# VETTRYX WP Site Signature

> ⚠️ **Atenção:** Este repositório agora atua exclusivamente como um **Submódulo** do ecossistema principal `VETTRYX WP Core`. Ele não deve mais ser instalado como um plugin standalone (isolado) nos clientes.

Este submódulo gerencia a identidade corporativa no rodapé dos sites de clientes, garantindo que as datas de copyright estejam sempre corretas e que a assinatura de desenvolvimento permaneça vinculada à marca VETTRYX, mesmo em caso de rebranding.

## 🚀 Funcionalidades

* **Copyright Automático:** Atualiza o ano no rodapé automaticamente a cada virada de ano (ex: 2025 -> 2026), sem necessidade de manutenção manual.
* **Assinatura Conectada:** Exibe "Desenvolvido por: VETTRYX Tech". O nome da empresa é buscado via API REST. Se a VETTRYX mudar de nome no futuro, todos os sites de clientes são atualizados automaticamente em até 24h.
* **Cache Inteligente:** Utiliza a Transient API do WordPress para armazenar os dados por 24 horas, garantindo zero impacto na performance do site do cliente.

## ⚙️ Arquitetura e Deploy (CI/CD)

Este repositório não gera mais arquivos `.zip` para instalação manual. O fluxo de deploy é 100% automatizado:

1. Qualquer push na branch `main` deste repositório dispara um webhook (Repository Dispatch) para o repositório principal do Core.
2. O repositório do Core puxa este código atualizado para dentro da pasta `/modules/`.
3. O GitHub Actions do Core empacota tudo e gera uma única Release oficial.

## 🛠️ Como Usar (Shortcodes)

Uma vez que o **VETTRYX WP Core** esteja instalado e o módulo Signature ativado no painel do cliente, utilize os shortcodes abaixo:

**1. Copyright do Cliente**
Coloque no rodapé do Elementor/Tema:
`[vettryx_copyright]`
*(Saída: © 2026 Nome do Cliente. Todos os direitos reservados.)*

**2. Assinatura da VETTRYX**
Coloque ao lado do copyright:
`[vettryx_developer]`
*(Saída: Desenvolvido por: VETTRYX Tech)*

---

**VETTRYX Tech**
*Transformando ideias em experiências digitais.*
