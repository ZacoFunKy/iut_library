import logo from "../assets/logo-iut.png";
import Navbar from "./Navbar";
import SearchBar from "./SearchBar";
import { React } from "react";

function Header({setBook, searchTerm, setSearchTerm }) {

  return (
    <div className="Header flex items-center">
        <div className="flex flex-row items-center">
            <img src={logo} alt="logo" className="w-10 mb-1.5"/>
            <h1 className="text ml-5 text-2xl mb-0 font-700">IUT - Bibliothèque</h1>
        </div>
        <SearchBar setBook={setBook} searchTerm={searchTerm} setSearchTerm={setSearchTerm}/>
        <Navbar />
    </div>
  );
}

export default Header;
