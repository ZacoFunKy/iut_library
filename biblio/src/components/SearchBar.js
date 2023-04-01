import { React, useState, useEffect, Fragment } from "react";
import { useNavigate } from "react-router-dom";
import Suggestion from "./Suggestion";

function SearchBar({
  setBook,
  searchTerm,
  setSearchTerm,
  setResults,
  indexPage,
  setIndex,
  setNbLivres,
  setTextSearch,
}) {
  const [listSuggestions, setListSuggestions] = useState([]);

  const navigation = useNavigate();
  const [focused, setFocused] = useState(false);
  const onFocus = () => setFocused(true);
  const onBlur = () => setFocused(false);

  const handleChange = (event) => {
    setSearchTerm(event.target.value);
    if (event.target.value.length === 1) {
      navigation("/results");
    } else if (event.target.value.length === 0) {
      navigation("/");
    }
  };

  useEffect(() => {
    const search = setTimeout(() => {
      if (searchTerm.length >= 1) {
        fetch(
          `http://185.212.226.191:8000/api/books/research/?name=${searchTerm}&&startIndex=${indexPage}&&maxResults=8`
        )
          .then((response) => response.json())
          .then((data) => {
            console.log(data);
            if (data.livres === undefined) {
              setResults([]);
              setTextSearch(
                "Aucun résultat pour l'auteur/livre : " + searchTerm
              );
            } else {
              setResults(data.livres);
            }
            if (data.nbResults === undefined) {
              setNbLivres(0);
            } else {
              setNbLivres(data.nbResults);
            }
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        setResults([]);
        setNbLivres(0);
      }
    }, 250);
    return () => clearTimeout(search);
  }, [indexPage, searchTerm, setNbLivres, setResults, setTextSearch]);

  // pareil que auddessus mais avec fetch
  useEffect(() => {
    const search = setTimeout(() => {
      if (searchTerm.length >= 4) {
        fetch(
          `http://185.212.226.191:8000/api/authors/research/?name=${searchTerm}&&maxResults=10`
        )
          .then((response) => response.json())
          .then((data) => {
            setListSuggestions(data);
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        setListSuggestions([]);
      }
    }, 250);
    return () => clearTimeout(search);
  }, [searchTerm]);

  const rebootIndex = () => {
    setIndex(0);
  };

  return (
    <Fragment>
      <div className="flex flex-col">
        <div className="search-bar flex items-center">
          <input
            className="inputBar p-3.5 pl-5 pr-5"
            type="text"
            placeholder="Rechercher un auteur/livre"
            value={searchTerm}
            onChange={(event) => {
              handleChange(event);
              rebootIndex();
            }}
            onFocus={onFocus}
            onBlur={onBlur}
          />
          <button
            className="loupe p-1.5 pl-3 pr-3 rounded-tr-md rounded-br-md"
            onMouseDown={(e) => navigation("/results")}
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 27"
              width="20"
              height="24"
              className="m-auto"
            >
              <path fill="none" d="M0 0h24v24H0z" />
              <path d="M18.031 16.617l4.283 4.282-1.415 1.415-4.282-4.283A8.96 8.96 0 0 1 11 20c-4.968 0-9-4.032-9-9s4.032-9 9-9 9 4.032 9 9a8.96 8.96 0 0 1-1.969 5.617zm-2.006-.742A6.977 6.977 0 0 0 18 11c0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7a6.977 6.977 0 0 0 4.875-1.975l.15-.15z" />
            </svg>
            <p className="text-xs">rechercher</p>
          </button>
        </div>
        {listSuggestions.length > 0 ? (
          <div
            className="suggestions flex flex-col absolute top-20 bg-white"
            style={{ display: focused ? "flex" : "none" }}
          >
            {listSuggestions.map((suggestion) => {
              return (
                <Suggestion
                  suggestion={suggestion}
                  setListSuggestions={setListSuggestions}
                  setBook={setBook}
                  setSearchTerm={setSearchTerm}
                  navigation={navigation}
                  key={suggestion.titre}
                />
              );
            })}
          </div>
        ) : null}
      </div>
    </Fragment>
  );
}

export default SearchBar;
