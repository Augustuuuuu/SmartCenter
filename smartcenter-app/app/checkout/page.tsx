"use client";

import { useCart } from "@/lib/cart-store";
import Link from "next/link";

function fmt(v: number) {
  return new Intl.NumberFormat("pt-BR", { style: "currency", currency: "BRL" }).format(v);
}

export default function CheckoutPage() {
  const items = useCart((s) => s.items);
  const total = items.reduce((a, i) => a + i.price * i.quantity, 0);

  if (items.length === 0) {
    return (
      <div className="max-w-2xl mx-auto px-4 py-12">
        <h1 className="text-2xl font-bold mb-8">Finalizar compra</h1>
        <p className="text-sc-muted mb-4">Sua sacola está vazia.</p>
        <Link href="/loja" className="text-sc-blue font-semibold">Continuar comprando</Link>
      </div>
    );
  }

  return (
    <div className="max-w-2xl mx-auto px-4 py-12">
      <h1 className="text-2xl font-bold mb-8">Finalizar compra</h1>
      <ul className="divide-y divide-sc-gray mb-6">
        {items.map((i) => (
          <li key={i.productId} className="py-4 flex justify-between">
            <span>{i.name} × {i.quantity}</span>
            <span className="font-semibold text-sc-blue">{fmt(i.price * i.quantity)}</span>
          </li>
        ))}
      </ul>
      <p className="text-xl font-bold mb-6">Total: {fmt(total)}</p>
      <p className="text-sm text-sc-muted mb-4">Integre Mercado Pago ou PagSeguro nas rotas de API.</p>
      <button type="button" className="w-full py-3.5 rounded-full bg-sc-blue text-white font-semibold">
        Ir para pagamento
      </button>
    </div>
  );
}
