import React, { Fragment } from "react";

function SearchResults({ results }) {

  console.log(results);

  return (
    <Fragment>
      <div>
        {results.length > 0 ? (
          <div>
            {results.map((book) => (
              <div>
                {book.titre !== null ? (
                  <span>{book.titre}</span>
                ) : (
                  <span>Titre non renseigné</span>
                )}
              </div>
            ))}
          </div>
        ) : (
          <span>Résultats</span>
        )}
      </div>
    </Fragment>
  );
}

export default SearchResults;
