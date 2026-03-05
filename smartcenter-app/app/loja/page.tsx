import { LojaClient } from "./LojaClient";
import type { Category, Product } from "@/lib/types";

async function getCategories(): Promise<Category[]> {
  const base = process.env.NEXT_PUBLIC_BASE_URL || "http://localhost:3000";
  const res = await fetch(`${base}/api/categories`, { cache: "no-store" });
  if (!res.ok) return [];
  return res.json();
}

async function getProducts(searchParams: {
  categoria?: string;
  q?: string;
  order?: string;
}): Promise<Product[]> {
  const base = process.env.NEXT_PUBLIC_BASE_URL || "http://localhost:3000";
  const params = new URLSearchParams();
  if (searchParams.categoria) params.set("categoria", searchParams.categoria);
  if (searchParams.q) params.set("q", searchParams.q);
  if (searchParams.order) params.set("order", searchParams.order);
  const res = await fetch(`${base}/api/products?${params}`, { cache: "no-store" });
  if (!res.ok) return [];
  return res.json();
}

export default async function LojaPage({
  searchParams,
}: {
  searchParams: Promise<{ categoria?: string; q?: string; order?: string }>;
}) {
  const params = await searchParams;
  const [categories, products] = await Promise.all([
    getCategories(),
    getProducts(params),
  ]);

  return (
    <LojaClient
      categories={categories}
      products={products}
      currentCategoria={params.categoria}
      currentQ={params.q}
      currentOrder={params.order}
    />
  );
}
