import React, { Fragment } from "react";
import { Link, useNavigate } from "react-router-dom";

function SearchResults({
  results,
  setBook,
  setSearchTerm,
  indexPage,
  setIndex,
}) {
  const navigation = useNavigate();

  // page navigation suivante
  const nextPage = () => {
    setIndex(indexPage + 10);
    console.log(indexPage);
  };

  // page navigation précédente
  const previousPage = () => {
    setIndex(indexPage - 10);
    console.log(indexPage);
  };

  return (
    <Fragment>
      <div className="m-5">
        {results.length > 0 ? (
          <ol>
            {results.map((book) => (
              <li key={book.id} className="m-5">
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
          <span>Aucun livre pour cette auteur</span>
        )}
      </div>
      <div className="flex justify-around p-3 bg-gray-200">
        {indexPage === 0 ? null : (
          <button onClick={previousPage}>Précédent</button>
        )}
        {results.length < 10 ? null : (
          <button onClick={nextPage}>Suivant</button>
        )}
      </div>
    </Fragment>
  );
}

export default SearchResults;
