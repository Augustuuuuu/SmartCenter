"use client";

import Link from "next/link";
import type { Product } from "@/lib/types";
import { useCart } from "@/lib/cart-store";

const CONDITION_LABELS: Record<string, string> = {
  novo: "Novo",
  usado: "Usado",
  seminovo: "Seminovo",
  recondicionado: "Recondicionado",
  vitrine: "Vitrine",
};

export function ProductCard({ product }: { product: Product }) {
  const addItem = useCart((s) => s.addItem);
  const openDrawer = useCart((s) => s.openDrawer);
  const imageUrl = product.images?.[0]?.url || "https://placehold.co/400x400/f5f5f7/6e6e73?text=Produto";
  const conditionLabel = CONDITION_LABELS[product.condition_type] || product.condition_type || "Novo";

  const handleBuy = (e: React.MouseEvent) => {
    e.preventDefault();
    addItem({
      productId: product.id,
      name: product.name,
      slug: product.slug,
      price: product.price,
      image: imageUrl,
    }, 1);
    openDrawer();
  };

  const installments = product.price >= 12 ? (product.price / 12).toFixed(2) : null;

  return (
    <li className="bg-sc-white rounded-xl overflow-hidden shadow-card hover:shadow-card-hover hover:scale-[1.02] transition-all duration-300 opacity-0 animate-fade-in">
      <Link href={`/produto/${product.slug}`} className="block">
        <div className="aspect-square bg-sc-white flex items-center justify-center p-6 relative">
          <span className="absolute top-3 left-3 bg-sc-muted text-white text-xs font-semibold px-2.5 py-1 rounded-md">
            {conditionLabel}
          </span>
          <img
            src={imageUrl}
            alt={product.name}
            className="max-w-full max-h-full object-contain"
          />
        </div>
      </Link>
      <div className="p-4">
        <Link href={`/produto/${product.slug}`}>
          <h3 className="font-bold text-[17px] leading-tight line-clamp-2 hover:text-sc-blue transition-colors duration-300">
            {product.name}
          </h3>
        </Link>
        <p className="text-[22px] font-bold text-sc-text mt-2">{formatPrice(product.price)}</p>
        {installments && (
          <p className="text-sm text-sc-muted mt-1">
            ou em até 12x de {formatPrice(Number(installments))}
          </p>
        )}
        <button
          type="button"
          onClick={handleBuy}
          className="mt-4 w-full py-3 rounded-full bg-sc-blue text-white font-semibold text-[15px] hover:bg-sc-blue-hover transition-all duration-300 hover:scale-[1.02]"
        >
          Comprar
        </button>
      </div>
    </li>
  );
}

function formatPrice(value: number) {
  return new Intl.NumberFormat("pt-BR", { style: "currency", currency: "BRL" }).format(value);
}
