import React from "react";

function SearchResults(props) {
    
  return (
    <ol className="books-grid">
      <li> { props.searchTerm} </li>
    </ol>
  );
}

export default SearchResults;