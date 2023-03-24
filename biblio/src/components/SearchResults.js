import React, { Fragment } from "react";

function SearchResults({ results }) {
  return (
    <Fragment>
      <div>
        {results !== undefined ? (
          <div>
            {results.map((book) => (
              <div>
                {book.title !== null ? (
                  <span>{book.volumeInfo.title}</span>
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
