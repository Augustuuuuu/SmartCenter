import Link from "next/link";
import type { Category } from "@/lib/types";

export function CategoriesBar({ categories }: { categories: Category[] }) {
  return (
    <div className="bg-sc-white border-b border-sc-gray px-4 sm:px-6 py-2 overflow-x-auto">
      <ul className="flex gap-2 flex-nowrap">
        <li>
          <Link
            href="/loja"
            className="block py-2.5 px-4 text-[15px] text-sc-muted hover:bg-sc-gray hover:text-sc-text rounded-lg transition-colors duration-300 whitespace-nowrap"
          >
            Todos
          </Link>
        </li>
        {categories.filter((c) => c.active === 1).map((cat) => (
          <li key={cat.id}>
            <Link
              href={`/loja?categoria=${cat.slug}`}
              className="block py-2.5 px-4 text-[15px] text-sc-muted hover:bg-sc-gray hover:text-sc-text rounded-lg transition-colors duration-300 whitespace-nowrap"
            >
              {cat.name}
            </Link>
          </li>
        ))}
      </ul>
    </div>
  );
}
