"use client";

import { useState } from "react";
import Link from "next/link";
import { useCart } from "@/lib/cart-store";

interface ProductDetailProps {
  product: {
    id: number;
    name: string;
    slug: string;
    brand: string | null;
    conditionLabel: string;
    description: string | null;
    specs: Record<string, string>;
    price: number;
    images: { id: number; url: string; sort_order: number }[];
  };
}

export function ProductDetail({ product }: ProductDetailProps) {
  const [mainImage, setMainImage] = useState(
    product.images?.[0]?.url || "https://placehold.co/600x600/f5f5f7/6e6e73?text=Produto"
  );
  const addItem = useCart((s) => s.addItem);
  const openDrawer = useCart((s) => s.openDrawer);

  const handleBuy = () => {
    addItem({
      productId: product.id,
      name: product.name,
      slug: product.slug,
      price: product.price,
      image: product.images?.[0]?.url,
    }, 1);
    openDrawer();
  };

  const installments = product.price >= 12 ? (product.price / 12).toFixed(2) : null;

  return (
    <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
      <div className="sticky top-24">
        <div className="aspect-square bg-sc-gray rounded-xl flex items-center justify-center p-6 mb-4">
          <img
            src={mainImage}
            alt={product.name}
            className="max-w-full max-h-full object-contain"
          />
        </div>
        {product.images && product.images.length > 1 && (
          <div className="flex gap-2 overflow-x-auto pb-2">
            {product.images.map((img) => (
              <button
                key={img.id}
                type="button"
                onClick={() => setMainImage(img.url)}
                className={`shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 transition-colors ${
                  mainImage === img.url ? "border-sc-blue" : "border-transparent"
                }`}
              >
                <img src={img.url} alt="" className="w-full h-full object-cover" />
              </button>
            ))}
          </div>
        )}
      </div>
      <div>
        <h1 className="text-2xl sm:text-3xl font-bold text-sc-text mb-2">{product.name}</h1>
        <p className="text-sc-muted text-[15px] mb-4">
          {[product.brand, product.conditionLabel].filter(Boolean).join(" · ")}
        </p>
        {Object.keys(product.specs).length > 0 && (
          <ul className="space-y-2 mb-6 text-[15px]">
            {Object.entries(product.specs).map(([key, value]) => (
              <li key={key} className="flex justify-between py-2 border-b border-sc-gray">
                <span className="text-sc-muted font-medium">{key}</span>
                <span>{value}</span>
              </li>
            ))}
          </ul>
        )}
        <div className="mb-6">
          <p className="text-3xl font-bold text-sc-text">{formatPrice(product.price)}</p>
          {installments && (
            <p className="text-sc-muted mt-1">
              ou em até 12x de {formatPrice(Number(installments))}
            </p>
          )}
        </div>
        <div className="flex flex-wrap gap-3">
          <button
            type="button"
            onClick={handleBuy}
            className="px-8 py-3.5 rounded-full bg-sc-blue text-white font-semibold text-base hover:bg-sc-blue-hover transition-colors duration-300"
          >
            Adicionar à sacola
          </button>
          <Link
            href="/checkout"
            className="px-8 py-3.5 rounded-full border-2 border-sc-blue text-sc-blue font-semibold text-base hover:bg-sc-blue hover:text-white transition-colors duration-300 inline-block text-center"
          >
            Comprar agora
          </Link>
        </div>
        {product.description && (
          <div className="mt-8 pt-8 border-t border-sc-gray prose prose-sc-text max-w-none">
            <h2 className="text-lg font-bold mb-2">Descrição</h2>
            <div className="text-sc-muted text-[15px] whitespace-pre-wrap">{product.description}</div>
          </div>
        )}
      </div>
    </div>
  );
}

function formatPrice(value: number) {
  return new Intl.NumberFormat("pt-BR", { style: "currency", currency: "BRL" }).format(value);
}
