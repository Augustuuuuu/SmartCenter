# SmartCenter — E-commerce na Hostinger

Loja virtual de smartphones e tecnologia com design minimalista (inspirado na Apple Store), em WordPress + WooCommerce.

## O que está neste repositório

- **smartcenter-theme/** — Tema filho WordPress (usa [Storefront](https://wordpress.org/themes/storefront/) como tema pai)
- **smartcenter-plugin/** — Plugin com campos de produto, categorias ativas e produtos relevantes

## Deploy na Hostinger

### 1. WordPress e WooCommerce

1. Acesse o **Painel Hostinger** (hPanel).
2. Em **Website** → **Auto Installer**, instale **WordPress**.
3. Após a instalação, em **Plugins** do WordPress, instale **WooCommerce** e conclua o assistente.
4. Em **Aparência** → **Temas**, instale o tema **Storefront** (necessário para o tema filho).

### 2. Enviar tema e plugin

**Opção A — Upload manual**

- Compacte a pasta `smartcenter-theme` em `smartcenter-theme.zip`.
- Em **Aparência** → **Temas** → **Adicionar** → **Enviar tema**, envie o ZIP e ative o tema **SmartCenter**.
- Compacte a pasta `smartcenter-plugin` em `smartcenter-plugin.zip`.
- Em **Plugins** → **Adicionar** → **Enviar plugin**, envie o ZIP e ative **SmartCenter E-commerce**.

**Opção B — FTP/SFTP**

- Conecte ao seu hosting (FTP ou Gerenciador de Arquivos).
- Envie a pasta `smartcenter-theme` para `wp-content/themes/`.
- Envie a pasta `smartcenter-plugin` para `wp-content/plugins/`.
- No WordPress: **Aparência** → **Temas**, ative **SmartCenter**; **Plugins**, ative **SmartCenter E-commerce**.

### 3. Configurações básicas

- **Configurações** → **Geral**: idioma **Português do Brasil**.
- **WooCommerce** → **Configurações**: moeda, região, páginas (loja, carrinho, checkout, minha conta).
- **Aparência** → **Personalizar**: defina a **Página inicial** como uma página estática e escolha a página que será a **Home** (a que lista os produtos em destaque). Para mostrar a grade da home, crie uma página (ex.: “Loja”) e em **Configurações** → **Leitura** defina “Sua página inicial exibe” = **Uma página estática** e **Página inicial** = essa página. Em seguida, no tema, a `front-page.php` será usada quando a página inicial for a front page; confira se a sua “Home” é a mesma que está em Leitura como página inicial.
- **CNPJ no footer**: em **Aparência** → **Personalizar** (ou no tema, se houver opção), preencha o CNPJ para exibir no rodapé.

### 4. Plugins recomendados (instalar na Hostinger)

| Função | Plugin |
|--------|--------|
| Pagamento | [Mercado Pago para WooCommerce](https://wordpress.org/plugins/woocommerce-mercadopago/), [PagSeguro](https://wordpress.org/plugins/woocommerce-pagseguro/) ou equivalente oficial |
| Favoritos (wishlist) | YITH WooCommerce Wishlist |
| Senha forte | Validação no cadastro (plugin de “strong password” ou custom) |
| Limite de tentativas de login | Limit Login Attempts Reloaded |
| URL admin customizada | WPS Hide Login |
| 2FA admin | Two-Factor ou WP 2FA |
| Sessão 30 min | Inactive Logout |
| Segurança | Wordfence ou Solid Security |
| Log do painel | WP Activity Log |
| Backup | UpdraftPlus (Google Drive / S3) |
| SEO | Yoast SEO ou Rank Math |
| Cache | WP Rocket ou LiteSpeed Cache |
| Imagens WebP | ShortPixel ou Imagify |

### 5. SSL e HTTPS

- No hPanel: **SSL** → ative certificado (Let’s Encrypt).
- No WordPress: **Configurações** → **Geral**: URLs do site e do WordPress com `https://`.
- Force HTTPS no servidor (Hostinger costuma oferecer opção “Force HTTPS”).

### 6. Páginas legais (footer)

Crie páginas e vincule no menu/rodapé:

- Política de Privacidade (LGPD) — use a página nativa do WordPress em **Configurações** → **Privacidade**.
- Termos de Uso
- Política de Devolução

O footer do tema já tem placeholders para esses links e para CNPJ/SSL.

## Uso do tema

- **Home**: exibe produtos em **destaque** (WooCommerce) e/ou **relevantes** (campo do plugin).
- **Navbar**: logo, busca, ícones de favoritos, conta e sacola (drawer lateral).
- **Categorias**: barra abaixo da navbar; no painel, em **Produtos** → **Categorias**, use “Exibir no menu” e “Ordem” (plugin).
- **Produtos**: cadastre com os campos extras (condição, marca, RAM, câmera, etc.) e marque “Produto relevante” e/ou “Em destaque” para aparecer na home. Para o filtro “Marca” na home funcionar, crie o atributo global de produto **Marca** (slug `pa_marca`) em **Produtos** → **Atributos** e associe aos produtos.
- **Checkout**: usuário não logado é redirecionado para login/cadastro com mensagem em português; após login, volta ao checkout.

## Estrutura do tema

- `style.css` — Paleta (#FFFFFF, #F5F5F7, #1D1D1F, #6E6E73, #0071E3), tipografia, cards, drawer, footer.
- `functions.php` — Suporte WooCommerce, navbar, categorias, query da home, redirecionamento de login/checkout.
- `header.php` / `footer.php` — Navbar, menu de categorias, drawer do carrinho, links legais.
- `front-page.php` — Página inicial com filtros (marca, ordenação) e grade de produtos.
- `woocommerce/content-product.php` — Card do produto (badge, preço, parcelamento, estrelas, botão Comprar).
- `woocommerce/single-product.php` — Página do produto (galeria, especificações, CEP/frete).
- `assets/js/main.js` — Drawer do carrinho, filtros, miniatura na single.

## Estrutura do plugin

- **Produtos**: condição (Novo/Usado/Seminovo/etc.), marca, RAM, tela, câmera, bateria, SO, processador, conectividade, peso, dimensões, acessórios, preço de custo (só painel), estoque mínimo, “Produto relevante”, “Em destaque”.
- **Categorias**: “Exibir no menu”, ordem de exibição.

## Requisitos

- WordPress 5.8+
- WooCommerce 6.0+
- PHP 7.4+
- Tema pai: Storefront (recomendado)

## Licença

GPL v2 ou posterior.
