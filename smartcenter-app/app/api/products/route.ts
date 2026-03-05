import { NextRequest, NextResponse } from "next/server";
import { getDb } from "@/lib/db";

export async function GET(request: NextRequest) {
  const { searchParams } = new URL(request.url);
  const featured = searchParams.get("featured");
  const relevant = searchParams.get("relevant");
  const home = searchParams.get("home");
  const category = searchParams.get("categoria");
  const q = searchParams.get("q");
  const order = searchParams.get("order") || "relevancia";

  try {
    const db = getDb();
    let sql = `
      SELECT p.*,
        (SELECT json_group_array(json_object('id', pi.id, 'url', pi.url, 'sort_order', pi.sort_order))
         FROM product_images pi WHERE pi.product_id = p.id ORDER BY pi.sort_order) AS images_json
      FROM products p
      LEFT JOIN product_categories pc ON pc.product_id = p.id
      WHERE p.active = 1
    `;
    const params: (string | number)[] = [];

    if (home === "1") {
      sql += ` AND (p.featured = 1 OR p.relevant = 1)`;
    } else {
      if (featured === "1") sql += ` AND p.featured = 1`;
      if (relevant === "1") sql += ` AND p.relevant = 1`;
    }
    if (category) {
      sql += ` AND pc.category_id = (SELECT id FROM categories WHERE slug = ?)`;
      params.push(category);
    }
    if (q && q.trim()) {
      sql += ` AND (p.name LIKE ? OR p.brand LIKE ? OR p.description LIKE ?)`;
      const term = `%${q.trim()}%`;
      params.push(term, term, term);
    }

    sql += ` GROUP BY p.id`;

    switch (order) {
      case "preco-asc":
        sql += ` ORDER BY p.price ASC`;
        break;
      case "preco-desc":
        sql += ` ORDER BY p.price DESC`;
        break;
      case "novos":
        sql += ` ORDER BY p.created_at DESC`;
        break;
      default:
        sql += ` ORDER BY p.featured DESC, p.relevant DESC, p.name ASC`;
    }

    const rows = db.prepare(sql).all(...params) as any[];
    const products = rows.map((r) => ({
      ...r,
      images: r.images_json ? JSON.parse(r.images_json) : [],
      images_json: undefined,
    }));
    return NextResponse.json(products);
  } catch (e) {
    console.error(e);
    return NextResponse.json({ error: "Erro ao listar produtos" }, { status: 500 });
  }
}
