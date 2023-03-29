import React, { Fragment } from "react";
import Book from "./Book";

function SearchResults({
  results,
  setBook,
  indexPage,
  setIndex,
}) {

  // page navigation suivante
  const nextPage = () => {
    setIndex(indexPage + 10);
  };

  // page navigation précédente
  const previousPage = () => {
    setIndex(indexPage - 10);
  };

  return (
    <Fragment>
      <div className="m-12  flex-row flex-wrap justify-center">
        {results.length > 0 ? (
          <div className="flex flex-row flex-wrap justify-center">
            {results.map((book) => (
              <Book props={book} key={book.titre} setBook={setBook} />
            ))}
          </div>
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
