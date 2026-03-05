import { CategoriesBar } from "@/components/CategoriesBar";
import { ProductCard } from "@/components/ProductCard";
import type { Category, Product } from "@/lib/types";

async function getCategories(): Promise<Category[]> {
  const base = process.env.NEXT_PUBLIC_BASE_URL || "http://localhost:3000";
  const res = await fetch(`${base}/api/categories`, { cache: "no-store" });
  if (!res.ok) return [];
  return res.json();
}

async function getFeaturedProducts(): Promise<Product[]> {
  const base = process.env.NEXT_PUBLIC_BASE_URL || "http://localhost:3000";
  const res = await fetch(
    `${base}/api/products?home=1`,
    { cache: "no-store" }
  );
  if (!res.ok) return [];
  return res.json();
}

export default async function HomePage() {
  const [categories, products] = await Promise.all([
    getCategories(),
    getFeaturedProducts(),
  ]);

  return (
    <>
      <CategoriesBar categories={categories} />
      <ul className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 p-4 sm:p-6 max-w-7xl mx-auto list-none">
        {products.length === 0 ? (
          <li className="col-span-full text-center text-sc-muted py-12">
            Nenhum produto em destaque no momento.
          </li>
        ) : (
          products.map((product) => (
            <ProductCard key={product.id} product={{ ...product, images: product.images || [] }} />
          ))
        )}
      </ul>
    </>
  );
}
