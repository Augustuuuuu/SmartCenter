import Link from "next/link";

export function Footer() {
  return (
    <footer className="bg-sc-gray mt-16 py-10 px-4 sm:px-6 text-sm text-sc-muted">
      <div className="max-w-6xl mx-auto">
        <div className="flex flex-wrap gap-6 mb-6">
          <Link href="/politica-de-privacidade" className="hover:text-sc-blue transition-colors duration-300">
            Política de Privacidade
          </Link>
          <Link href="/termos-de-uso" className="hover:text-sc-blue transition-colors duration-300">
            Termos de Uso
          </Link>
          <Link href="/politica-de-devolucao" className="hover:text-sc-blue transition-colors duration-300">
            Política de Devolução
          </Link>
          <span>Certificado SSL - Conexão segura</span>
        </div>
        <div className="pt-6 border-t border-black/10">
          <p>© {new Date().getFullYear()} SmartCenter. Todos os direitos reservados.</p>
        </div>
      </div>
    </footer>
  );
}
