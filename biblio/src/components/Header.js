import logo from "../assets/logo-iut.webp";
import Navbar from "./Navbar";
import SearchBar from "./SearchBar";

function Header({
  setTextSearch,
  setBook,
  searchTerm,
  setSearchTerm,
  setResults,
  indexPage,
  setIndex,
  setNbLivres,
}) {
  return (
    <div className="Header flex items-center">
      <div className="flex flex-row items-center mr-5">
        <img
          src={logo}
          alt="logo"
          className=" mb-1.5"
          style={{ width: "40px", minWidth: "40px", height: "35px" }}
        />
        <h1 className="nom ml-5 text-2xl mb-0 font-700">IUT - Bibliothèque</h1>
      </div>
      <SearchBar
        setTextSearch={setTextSearch}
        setNbLivres={setNbLivres}
        setIndex={setIndex}
        indexPage={indexPage}
        setBook={setBook}
        searchTerm={searchTerm}
        setSearchTerm={setSearchTerm}
        setResults={setResults}
      />
      <Navbar />
    </div>
  );
}

export default Header;
