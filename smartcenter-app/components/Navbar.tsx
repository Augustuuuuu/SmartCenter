"use client";

import Link from "next/link";
import { useRouter } from "next/navigation";
import { useState } from "react";
import { useCart } from "@/lib/cart-store";

export function Navbar() {
  const router = useRouter();
  const [query, setQuery] = useState("");
  const items = useCart((s) => s.items);
  const count = items.reduce((a, i) => a + i.quantity, 0);
  const openDrawer = useCart((s) => s.openDrawer);

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    if (query.trim()) router.push(`/loja?q=${encodeURIComponent(query.trim())}`);
  };

  return (
    <nav className="sticky top-0 z-50 bg-sc-white border-b border-sc-gray flex items-center justify-between gap-6 px-4 sm:px-6 py-3 min-h-[52px]">
      <Link href="/" className="font-bold text-sc-text text-lg shrink-0">
        SmartCenter
      </Link>
      <form onSubmit={handleSearch} className="flex-1 max-w-md mx-auto hidden sm:block">
        <input
          type="search"
          value={query}
          onChange={(e) => setQuery(e.target.value)}
          placeholder="Buscar produtos..."
          className="w-full py-2.5 pl-10 pr-4 rounded-lg border border-sc-gray bg-sc-gray bg-[url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2718%27 height=%2718%27 fill=%27%236E6E73%27 viewBox=%270 0 16 16%27%3E%3Cpath d=%27M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z%27/%3E%3C/svg%3E')] bg-[length:18px] bg-[position:14px_center] bg-no-repeat text-[15px] focus:outline-none focus:border-sc-blue focus:ring-2 focus:ring-sc-blue/20 transition-[border-color,box-shadow] duration-300"
        />
      </form>
      <div className="flex items-center gap-5 shrink-0">
        <Link
          href="/conta"
          className="p-2.5 rounded-full text-sc-muted hover:bg-sc-gray hover:text-sc-text transition-colors duration-300"
          aria-label="Minha conta"
        >
          <AccountIcon />
        </Link>
        <button
          type="button"
          onClick={openDrawer}
          className="relative p-2.5 rounded-full text-sc-muted hover:bg-sc-gray hover:text-sc-text transition-colors duration-300"
          aria-label="Sacola"
        >
          <CartIcon />
          {count > 0 && (
            <span className="absolute -top-1 -right-1 bg-sc-blue text-sc-white text-[11px] min-w-[18px] h-[18px] rounded-full flex items-center justify-center">
              {count > 99 ? "99+" : count}
            </span>
          )}
        </button>
      </div>
    </nav>
  );
}

function AccountIcon() {
  return (
    <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
      <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
    </svg>
  );
}

function CartIcon() {
  return (
    <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
      <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z" />
    </svg>
  );
}
