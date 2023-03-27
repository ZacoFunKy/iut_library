import React, { Fragment } from "react";
import { Link, useNavigate } from "react-router-dom";

function SearchResults({ results, setBook,setSearchTerm }) {
  console.log(results);
  const navigation = useNavigate();

  return (
    <Fragment>
      <div className="m-5">
        {results.length > 0 ? (
          <ol>
            {results.map((book) => (
              <li key={book.id}>
                <Link
                  
                  className="p-2 text-black hover:cursor-pointer hover:bg-slate-400"
                  onMouseDown={(event) => {
                    event.preventDefault();
                    setBook(book);
                    navigation("/book");
                    setSearchTerm("");
                  }}
                >
                  {book.titre !== null ? (
                    <span>{book.titre}</span>
                  ) : (
                    <span>Titre non renseigné</span>
                  )}
                </Link>
              </li>
            ))}
          </ol>
        ) : (
          <span>Résultats</span>
        )}
      </div>
    </Fragment>
  );
}

export default SearchResults;
