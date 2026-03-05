"use client";

import Link from "next/link";
import { useCart } from "@/lib/cart-store";

export function CartDrawer() {
  const { items, isDrawerOpen, closeDrawer, removeItem, updateQuantity } = useCart();
  const total = items.reduce((a, i) => a + i.price * i.quantity, 0);

  return (
    <>
      <div
        className={`fixed inset-0 bg-black/40 z-[9998] transition-opacity duration-300 ${isDrawerOpen ? "opacity-100" : "opacity-0 pointer-events-none"}`}
        aria-hidden="true"
        onClick={closeDrawer}
      />
      <div
        className={`fixed top-0 right-0 w-full max-w-[420px] h-full bg-sc-white shadow-xl z-[9999] overflow-y-auto flex flex-col transition-transform duration-300 ${isDrawerOpen ? "translate-x-0" : "translate-x-full"}`}
        role="dialog"
        aria-label="Sacola"
      >
        <div className="flex items-center justify-between p-5 border-b border-sc-gray">
          <h2 className="text-xl font-bold">Sacola</h2>
          <button
            type="button"
            onClick={closeDrawer}
            className="p-2.5 rounded-full text-sc-muted hover:bg-sc-gray hover:text-sc-text transition-colors duration-300"
            aria-label="Fechar"
          >
            <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
            </svg>
          </button>
        </div>
        <div className="flex-1 overflow-y-auto p-6">
          {items.length === 0 ? (
            <p className="text-sc-muted">Sua sacola está vazia.</p>
          ) : (
            <ul className="space-y-4">
              {items.map((item) => (
                <li key={item.productId} className="flex gap-4 border-b border-sc-gray pb-4">
                  {item.image && (
                    <img
                      src={item.image}
                      alt=""
                      className="w-16 h-16 object-contain bg-sc-gray rounded-lg"
                    />
                  )}
                  <div className="flex-1 min-w-0">
                    <Link
                      href={`/produto/${item.slug}`}
                      onClick={closeDrawer}
                      className="font-semibold text-sc-text hover:text-sc-blue line-clamp-2"
                    >
                      {item.name}
                    </Link>
                    <p className="text-sc-blue font-semibold mt-1">
                      {formatPrice(item.price)}
                      {item.quantity > 1 && (
                        <span className="text-sc-muted font-normal"> × {item.quantity}</span>
                      )}
                    </p>
                    <div className="flex items-center gap-2 mt-2">
                      <button
                        type="button"
                        onClick={() => updateQuantity(item.productId, item.quantity - 1)}
                        className="w-8 h-8 rounded border border-sc-gray text-sc-muted hover:bg-sc-gray"
                      >
                        −
                      </button>
                      <span className="w-8 text-center">{item.quantity}</span>
                      <button
                        type="button"
                        onClick={() => updateQuantity(item.productId, item.quantity + 1)}
                        className="w-8 h-8 rounded border border-sc-gray text-sc-muted hover:bg-sc-gray"
                      >
                        +
                      </button>
                      <button
                        type="button"
                        onClick={() => removeItem(item.productId)}
                        className="ml-2 text-sm text-sc-muted hover:text-red-600"
                      >
                        Remover
                      </button>
                    </div>
                  </div>
                </li>
              ))}
            </ul>
          )}
        </div>
        {items.length > 0 && (
          <div className="p-6 border-t border-sc-gray">
            <p className="text-lg font-bold mb-4">Total: {formatPrice(total)}</p>
            <Link
              href="/checkout"
              onClick={closeDrawer}
              className="block w-full py-3.5 text-center font-semibold bg-sc-blue text-white rounded-full hover:bg-sc-blue-hover transition-colors duration-300"
            >
              Finalizar compra
            </Link>
          </div>
        )}
      </div>
    </>
  );
}

function formatPrice(value: number) {
  return new Intl.NumberFormat("pt-BR", {
    style: "currency",
    currency: "BRL",
  }).format(value);
}
