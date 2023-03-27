import { React, useEffect, useState } from "react";
import axios from "axios";
import Book from "./Book";

function Home() {
  const [derniersLivres, setDerniersLivres] = useState([]);

  useEffect(() => {
    axios
      .get(
        "https://www.googleapis.com/books/v1/volumes?q=orderBy=newest&&maxResults=4"
      )
      .then((response) => {
        console.log(response.data.items);
        setDerniersLivres(response.data.items);
      })
      .catch((error) => {
        console.log(error);
      });
  }, [setDerniersLivres]);

  return (
    <div className="home">
      <h1>Bienvenue sur Biblio !</h1>
      <p>
        Vous pouvez rechercher des livres, ajouter des amis, et bien plus encore
        !
      </p>
      <div className="derniers-emprunts m-20">
        <h2>Derniers livres empruntés</h2>
        <div className="flex flex-row justify-around m-5">
          {derniersLivres.map((livre) => {
            return (
              <div className="w-60" key={livre.id}>
                <Book props={livre} />
              </div>
            );
          })}
        </div>
      </div>
      <div className="derniers-ajout m-20">
        <h2>Derniers livres ajoutés</h2>
        <div className="flex flex-row justify-around m-5">
          {derniersLivres.map((livre) => {
            return (
              <div className="w-60" key={livre.id}>
                <Book props={livre} />
              </div>
            );
          })}
        </div>
      </div>
    </div>
  );
}

export default Home;
