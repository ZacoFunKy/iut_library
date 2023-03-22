import React, { useState, useEffect } from "react";

function SearchBar(props) {
  const [searchTerm, setSearchTerm] = useState("");
  const [searchResults, setSearchResults] = useState([]);

  const handleChange = (event) => {
    setSearchTerm(event.target.value);
  };

  /*useEffect(() => {
    const results = props.books.filter((book) =>
      book.title.toLowerCase().includes(searchTerm)
    );
    setSearchResults(results);
  }, [searchTerm]);*/

  return (
    <div className="search-bar flex items-center">
      <input
        className="p-1 pt-2.5 pl-5 pr-5 border-2 border-solid border-teal-600 rounded-tl-md rounded-bl-md min-w-300 outline-none"
        type="text"
        placeholder="Rechercher un auteur/livre"
        value={searchTerm}
        onChange={handleChange}
      />
      <button className="p-2 pt-1.5 pl-2 pr-2 border-2 border-solid border-[#009999] bg-[#009999] rounded-tr-md rounded-br-md"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 27" width="20" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M18.031 16.617l4.283 4.282-1.415 1.415-4.282-4.283A8.96 8.96 0 0 1 11 20c-4.968 0-9-4.032-9-9s4.032-9 9-9 9 4.032 9 9a8.96 8.96 0 0 1-1.969 5.617zm-2.006-.742A6.977 6.977 0 0 0 18 11c0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7a6.977 6.977 0 0 0 4.875-1.975l.15-.15z"/></svg></button>
      
    </div>
  );
}

export default SearchBar;