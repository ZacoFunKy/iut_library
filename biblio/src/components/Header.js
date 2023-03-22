import "../styles/Header.css";
import logo from "../assets/logo-iut.png";
import Navbar from "./Navbar";

function Header() {
  return (
    <div className="Header flex items-center w-100">
        <div className="flex flex-row items-center">
            <img src={logo} alt="logo" className="w-10 mb-1.5"/>
            <h1 className="text ml-5 text-2xl mb-0 font-700">IUT - Bibliothèque</h1>
        </div>
        <Navbar/>
    </div>
  );
}

export default Header;