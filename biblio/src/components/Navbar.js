import React from 'react';
import { Link } from 'react-router-dom';

function Navbar() {
  return (
    <div className="Navbar flex flex-row items-center">
      <Link to="/" className="text text-xl mr-5 hover:underline">Accueil</Link>
      <Link to="/amis" className="text text-xl mr-5 hover:underline">Amis</Link>
        <Link to="/connexion" className="text text-xl mr-5 hover:underline">Connexion</Link>
    </div>
  );
}

export default Navbar;