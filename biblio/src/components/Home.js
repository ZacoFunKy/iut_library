import { React, useEffect, useState } from "react";
import axios from "axios";
import Book from "./Book";

function Home() {
  const [derniersLivres, setDerniersLivres] = useState([]);
  const [derniersEmprunts, setDerniersEmprunts] = useState([]);

  useEffect(() => {
    axios
      .get("https://localhost:8000/api/books/last_posts")
      .then((response) => {
        console.log(response.data);
        setDerniersLivres(response.data);
      })
      .catch((error) => {
        console.log(error);
      });
  }, [setDerniersLivres]);

  useEffect(() => {
    axios
      .get("https://localhost:8000/api/books/last_emprunts")
      .then((response) => {
        console.log(response.data);
        setDerniersEmprunts(response.data);
      })
      .catch((error) => {
        console.log(error);
      });
  }, [setDerniersEmprunts]);

  return (
    <div className="home">
      <div className="m-auto w-max text-center mt-5">
        <h1 className="md:text-2xl text-xl mb-2">Bienvenue sur Biblio !</h1>
        <p>
          Vous pouvez rechercher des livres, ajouter des amis, et bien plus
          encore !
        </p>
      </div>

      <div className="derniers-emprunts m-20">
        <h2>Derniers livres empruntés</h2>
        {derniersEmprunts !== undefined && derniersLivres.length > 0 ? (
          <div className="flex flex-row justify-around m-5">
            {derniersEmprunts.map((livre) => {
              return (
                <div className="w-60" key={livre.id}>
                  <Book props={livre} />
                </div>
              );
            })}
          </div>
        ) : null}
      </div>
      <div className="derniers-ajout m-20">
        <h2>Derniers livres ajoutés</h2>
        {derniersLivres !== undefined && derniersLivres.length > 0 ? (
          <div className="flex flex-row justify-around m-5">
            {derniersLivres.map((livre) => {
              return (
                <div className="w-60" key={livre.id}>
                  <Book props={livre} />
                </div>
              );
            })}
          </div>
        ) : null}
      </div>
    </div>
  );
}

export default Home;
