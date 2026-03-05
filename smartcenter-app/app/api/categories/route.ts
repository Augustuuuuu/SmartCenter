import { NextResponse } from "next/server";
import { getDb } from "@/lib/db";

export async function GET() {
  try {
    const db = getDb();
    const rows = db
      .prepare(
        `SELECT id, name, slug, active, sort_order FROM categories WHERE active = 1 ORDER BY sort_order ASC, name ASC`
      )
      .all();
    return NextResponse.json(rows);
  } catch (e) {
    console.error(e);
    return NextResponse.json([], { status: 200 });
  }
}
