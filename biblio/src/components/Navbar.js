

export function Navbar() {
  return (
    <div className="Navbar flex flex-row items-center">
      <Link to="/" className="text text-xl mr-5">Accueil</Link>
      <Link to="/livres" className="text text-xl mr-5">Livres</Link>
      <Link to="/auteurs" className="text text-xl mr-5">Auteurs</Link>
      <Link to="/emprunts" className="text text-xl mr-5">Emprunts</Link>
    </div>
  );
}

export default Navbar;