"use client";

import { create } from "zustand";
import { persist } from "zustand/middleware";

export interface CartItemState {
  productId: number;
  name: string;
  slug: string;
  price: number;
  quantity: number;
  image?: string;
}

interface CartStore {
  items: CartItemState[];
  isDrawerOpen: boolean;
  addItem: (item: Omit<CartItemState, "quantity">, quantity?: number) => void;
  removeItem: (productId: number) => void;
  updateQuantity: (productId: number, quantity: number) => void;
  clearCart: () => void;
  openDrawer: () => void;
  closeDrawer: () => void;
  toggleDrawer: () => void;
}

export const useCart = create<CartStore>()(
  persist(
    (set, get) => ({
      items: [],
      isDrawerOpen: false,
      addItem(item, qty = 1) {
        set((state) => {
          const existing = state.items.find((i) => i.productId === item.productId);
          let next: CartItemState[];
          if (existing) {
            next = state.items.map((i) =>
              i.productId === item.productId ? { ...i, quantity: i.quantity + qty } : i
            );
          } else {
            next = [...state.items, { ...item, quantity: qty }];
          }
          return { items: next };
        });
      },
      removeItem(productId) {
        set((state) => ({ items: state.items.filter((i) => i.productId !== productId) }));
      },
      updateQuantity(productId, quantity) {
        if (quantity <= 0) return get().removeItem(productId);
        set((state) => ({
          items: state.items.map((i) =>
            i.productId === productId ? { ...i, quantity } : i
          ),
        }));
      },
      clearCart: () => set({ items: [] }),
      openDrawer: () => set({ isDrawerOpen: true }),
      closeDrawer: () => set({ isDrawerOpen: false }),
      toggleDrawer: () => set((s) => ({ isDrawerOpen: !s.isDrawerOpen })),
    }),
    { name: "smartcenter-cart" }
  )
);
