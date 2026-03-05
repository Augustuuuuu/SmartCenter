# SmartCenter — E-commerce (Next.js)

Loja de smartphones e tecnologia com design minimalista (inspirado na Apple Store), feita em **Next.js 14** (React), TypeScript e Tailwind CSS.

## Stack

- **Next.js 14** (App Router)
- **React 18** + TypeScript
- **Tailwind CSS** (paleta #FFFFFF, #F5F5F7, #1D1D1F, #6E6E73, #0071E3)
- **Zustand** (carrinho persistido no localStorage)
- **SQLite** (better-sqlite3) para produtos, categorias, usuários e pedidos

## Como rodar

1. Instale as dependências:
   ```bash
   cd smartcenter-app
   npm install
   ```

2. Crie o banco e dados de exemplo:
   ```bash
   npm run db:seed
   ```

3. Inicie o servidor:
   ```bash
   npm run dev
   ```

4. Acesse [http://localhost:3000](http://localhost:3000).

## Estrutura

- `app/` — Páginas (home, loja, produto/[slug], checkout, conta)
- `app/api/` — API Routes (categories, products, products/[slug])
- `components/` — Navbar, Footer, CartDrawer, ProductCard, ProductDetail, CategoriesBar
- `lib/` — db.ts (SQLite), types.ts, cart-store.ts (Zustand), seed.ts

## Deploy (Hostinger / VPS / Vercel)

- **Vercel**: Next.js é suportado. SQLite com better-sqlite3 não persiste no serverless; use um banco externo (ex.: Turso, PlanetScale) ou API separada.
- **Hostinger VPS ou Node.js**: faça build (`npm run build`), rode `npm run start` e exponha a porta 3000. Crie a pasta `data` e execute `npm run db:seed` no servidor (ou migre para PostgreSQL/MySQL).
- **Variáveis**: opcionalmente defina `NEXT_PUBLIC_BASE_URL` para a URL pública (ex.: https://seusite.com) para fetches da home/loja em SSR.

## Próximos passos

- Autenticação: rotas `/api/auth/login`, `/api/auth/register`, JWT ou sessão; proteger `/checkout` e `/conta`.
- Pagamento: integrar Mercado Pago ou PagSeguro nas rotas de API e na página de checkout.
- Painel admin: CRUD de produtos e categorias (ex.: rotas em `/admin` com autenticação).
- Imagens: upload para storage (S3, Cloudinary) e salvar URL em `product_images`.
