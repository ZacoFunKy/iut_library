import React, { Fragment } from "react";
import Book from "./Book";
import Pagination from "./Pagination";

function SearchResults({
  results,
  setBook,
  indexPage,
  setIndex,
  nbLivres,
  textSearch,
}) {
  return (
    <Fragment>
      <div className=" resultsResearch justify-between flex flex-col">
        <Pagination
          nbLivres={nbLivres}
          setIndex={setIndex}
          indexPage={indexPage}
          results={results}
        />
        <div className="m-12  flex-row flex-wrap justify-center text-center">
          {results !== undefined && results.length > 0 ? (
            <div className="flex flex-row flex-wrap justify-center">
              {results.map((book) => (
                <Book props={book} key={book.titre} setBook={setBook} />
              ))}
            </div>
          ) : (
            <span> {textSearch} </span>
          )}
        </div>
        <Pagination
          nbLivres={nbLivres}
          setIndex={setIndex}
          indexPage={indexPage}
          results={results}
        />
      </div>
    </Fragment>
  );
}

export default SearchResults;
