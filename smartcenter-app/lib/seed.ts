/**
 * Seed do banco: categorias e produtos de exemplo.
 * Execute: npm run db:seed (ou npx tsx lib/seed.ts)
 */
import { initDb } from "./db";
import path from "path";
import fs from "fs";

const dataDir = path.join(process.cwd(), "data");
if (!fs.existsSync(dataDir)) {
  fs.mkdirSync(dataDir, { recursive: true });
}

const db = initDb();

// Categorias
const categories = [
  { name: "Smartphones", slug: "smartphones", sort_order: 0 },
  { name: "Tablets", slug: "tablets", sort_order: 1 },
  { name: "Acessórios", slug: "acessorios", sort_order: 2 },
];

const insertCat = db.prepare(
  "INSERT OR IGNORE INTO categories (name, slug, active, sort_order) VALUES (?, ?, 1, ?)"
);
categories.forEach((c) => insertCat.run(c.name, c.slug, c.sort_order));

// Produtos de exemplo
const products = [
  {
    name: "Smartphone Galaxy S24 Ultra 256GB Preto",
    slug: "samsung-galaxy-s24-ultra-256gb-preto",
    brand: "Samsung",
    condition_type: "novo",
    description: "O mais completo da linha Galaxy com S Pen integrada.",
    specs: JSON.stringify({ RAM: "12GB", Armazenamento: "256GB", Tela: '6.8"', Bateria: "5000mAh" }),
    price: 6499,
    stock: 10,
    featured: 1,
    relevant: 1,
  },
  {
    name: "iPhone 15 Pro 128GB Titânio Natural",
    slug: "iphone-15-pro-128gb-titanio-natural",
    brand: "Apple",
    condition_type: "novo",
    description: "Chip A17 Pro, câmera 48MP, design em titânio.",
    specs: JSON.stringify({ RAM: "8GB", Armazenamento: "128GB", Tela: '6.1"', Bateria: "3274mAh" }),
    price: 7999,
    stock: 5,
    featured: 1,
    relevant: 1,
  },
  {
    name: "Xiaomi 14 512GB Preto",
    slug: "xiaomi-14-512gb-preto",
    brand: "Xiaomi",
    condition_type: "novo",
    description: "Leica, Snapdragon 8 Gen 3, carregamento 90W.",
    specs: JSON.stringify({ RAM: "16GB", Armazenamento: "512GB", Tela: '6.36"', Bateria: "4610mAh" }),
    price: 4499,
    stock: 8,
    featured: 0,
    relevant: 1,
  },
];

const insertProd = db.prepare(`
  INSERT INTO products (name, slug, brand, condition_type, description, specs, price, stock, featured, relevant, active)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
`);

const catIds = db.prepare("SELECT id, slug FROM categories").all() as { id: number; slug: string }[];
const catBySlug = Object.fromEntries(catIds.map((c) => [c.slug, c.id]));

products.forEach((p) => {
  insertProd.run(
    p.name,
    p.slug,
    p.brand,
    p.condition_type,
    p.description,
    p.specs,
    p.price,
    p.stock,
    p.featured,
    p.relevant
  );
  const row = db.prepare("SELECT id FROM products WHERE slug = ?").get(p.slug) as { id: number };
  const catId = catBySlug["smartphones"];
  if (row && catId) {
    db.prepare("INSERT OR IGNORE INTO product_categories (product_id, category_id) VALUES (?, ?)").run(
      row.id,
      catId
    );
  }
});

console.log("Seed concluído: categorias e produtos de exemplo criados.");
