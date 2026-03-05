export type ProductCondition = "novo" | "usado" | "seminovo" | "recondicionado" | "vitrine";

export interface Category {
  id: number;
  name: string;
  slug: string;
  active: number;
  sort_order: number;
}

export interface Product {
  id: number;
  name: string;
  slug: string;
  brand: string | null;
  condition_type: string;
  description: string | null;
  specs: string | null;
  price: number;
  compare_at_price: number | null;
  cost_price: number | null;
  stock: number;
  min_stock: number;
  featured: number;
  relevant: number;
  active: number;
  created_at: string;
  updated_at: string;
  images?: { id: number; url: string; sort_order: number }[];
  categories?: Category[];
}

export interface CartItem {
  productId: number;
  name: string;
  slug: string;
  price: number;
  quantity: number;
  image?: string;
}

export interface User {
  id: number;
  email: string;
  name: string;
  cpf: string | null;
  phone: string | null;
}
