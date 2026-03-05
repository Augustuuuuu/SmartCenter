import { notFound } from "next/navigation";
import { ProductDetail } from "@/components/ProductDetail";
import { getDb } from "@/lib/db";

async function getProduct(slug: string) {
  try {
    const db = getDb();
    const product = db.prepare("SELECT * FROM products WHERE slug = ? AND active = 1").get(slug) as any;
    if (!product) return null;
    const images = db
      .prepare("SELECT id, url, sort_order FROM product_images WHERE product_id = ? ORDER BY sort_order")
      .all(product.id) as { id: number; url: string; sort_order: number }[];
    const categories = db
      .prepare(
        "SELECT c.id, c.name, c.slug FROM categories c INNER JOIN product_categories pc ON pc.category_id = c.id WHERE pc.product_id = ?"
      )
      .all(product.id);
    return { ...product, images, categories };
  } catch {
    return null;
  }
}

const CONDITION_LABELS: Record<string, string> = {
  novo: "Novo",
  usado: "Usado",
  seminovo: "Seminovo",
  recondicionado: "Recondicionado",
  vitrine: "Vitrine",
};

export default async function ProdutoPage(props: { params: Promise<{ slug: string }> }) {
  const { slug } = await props.params;
  const product = await getProduct(slug);
  if (!product) notFound();
  const conditionLabel = CONDITION_LABELS[product.condition_type] || product.condition_type || "Novo";
  const specs = product.specs ? (JSON.parse(product.specs) as Record<string, string>) : {};
  return (
    <div className="max-w-6xl mx-auto px-4 sm:px-6 py-10">
      <ProductDetail product={{ ...product, conditionLabel, specs }} />
    </div>
  );
}
