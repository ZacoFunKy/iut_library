import logo from "../assets/logo-iut.png";
import Navbar from "./Navbar";
import SearchBar from "./SearchBar";
import { React } from "react";
import { useLocation } from "react-router-dom";

function Header({ searchTerm, setSearchTerm }) {
  const location = useLocation();
  const showSearchBar = location.pathname !== '/connexion';
  return (

    <div className="flex items-center justify-between  px-3 py-3 border-b-2 border-teal-600 rounded-bl-3xl rounded-br-3xl">
        <div className="flex flex-row items-center">
            <img src={logo} alt="logo" className="w-10 mb-1.5"/>
            <h1 className="text ml-5 text-2xl mb-0 font-700">IUT - Bibliothèque</h1>
        </div>
        {showSearchBar && <SearchBar searchTerm={searchTerm} setSearchTerm={setSearchTerm} />}
        <Navbar />
    </div>
  );
}

export default Header;
