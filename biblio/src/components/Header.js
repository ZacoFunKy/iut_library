import { useLocation } from 'react-router-dom';
import logo from '../assets/logo-iut.png';
import Navbar from './Navbar';
import SearchBar from './SearchBar';

function Header() {
  const location = useLocation();
  
  const showSearchBar = location.pathname !== '/connexion';

  return (
    <div className="flex items-center w-full justify-between p-6 border-b-4 border-[#086969]">
      <div className="flex flex-row items-center">
        <img src={logo} alt="logo" className="w-10 mb-1.5" />
        <h1 className="text ml-5 text-2xl mb-0 font-bold text-[#009DE0]">
          IUT - Bibliothèque
        </h1>
      </div>
      {showSearchBar && <SearchBar />}
      <Navbar />
    </div>
  );
}

export default Header;
