"use client";

import { useRouter, useSearchParams } from "next/navigation";
import { CategoriesBar } from "@/components/CategoriesBar";
import { ProductCard } from "@/components/ProductCard";
import type { Category, Product } from "@/lib/types";

export function LojaClient({
  categories,
  products,
  currentCategoria,
  currentQ,
  currentOrder,
}: {
  categories: Category[];
  products: Product[];
  currentCategoria?: string;
  currentQ?: string;
  currentOrder?: string;
}) {
  const router = useRouter();
  const searchParams = useSearchParams();

  const setOrder = (order: string) => {
    const p = new URLSearchParams(searchParams?.toString() || "");
    if (order && order !== "relevancia") p.set("order", order);
    else p.delete("order");
    router.push(`/loja?${p.toString()}`);
  };

  return (
    <>
      <CategoriesBar categories={categories} />
      <div className="flex flex-wrap items-center justify-between gap-4 px-4 sm:px-6 py-4">
        <form
          className="flex gap-2"
          onSubmit={(e) => {
            e.preventDefault();
            const q = (e.currentTarget.q as HTMLInputElement).value;
            const p = new URLSearchParams(searchParams?.toString() || "");
            if (q) p.set("q", q);
            else p.delete("q");
            router.push(`/loja?${p.toString()}`);
          }}
        >
          <input
            name="q"
            type="search"
            defaultValue={currentQ}
            placeholder="Buscar..."
            className="py-2 px-3 rounded-lg border border-sc-gray text-[15px] w-40 sm:w-56 focus:outline-none focus:border-sc-blue"
          />
          <button type="submit" className="py-2 px-4 rounded-lg bg-sc-gray text-sc-text text-sm font-medium">
            Buscar
          </button>
        </form>
        <div className="flex items-center gap-2">
          <label htmlFor="order" className="text-sc-muted text-[15px]">
            Ordenar:
          </label>
          <select
            id="order"
            className="py-2 px-3 rounded-lg border border-sc-gray text-[15px] min-w-[140px] focus:outline-none focus:border-sc-blue"
            value={currentOrder || "relevancia"}
            onChange={(e) => setOrder(e.target.value)}
          >
            <option value="relevancia">Relevância</option>
            <option value="preco-asc">Menor preço</option>
            <option value="preco-desc">Maior preço</option>
            <option value="novos">Lançamentos</option>
          </select>
        </div>
      </div>
      <ul className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 p-4 sm:p-6 max-w-7xl mx-auto list-none">
        {products.length === 0 ? (
          <li className="col-span-full text-center text-sc-muted py-12">
            Nenhum produto encontrado.
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
