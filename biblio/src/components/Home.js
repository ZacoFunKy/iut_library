import { React, useEffect, useState } from "react";
import axios from "axios";
import Book from "./Book";

function Home({ setBook }) {
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


  // récupérer les derniers livres empruntés par un lecteur en post
  useEffect(() => {
    axios
      .post("https://localhost:8000/api/lastEmprunt", {
        token: localStorage.getItem("token"),
      })
      .then((response) => {
        console.log(response.data);
        setDerniersEmprunts(response.data);
      })
      .catch((error) => {
        console.log(error);
      });
  }, [setDerniersEmprunts]);

  return (
    <div className="home relative">
      <div className="derniers-emprunts m-20 h-auto items-center">
        <h2 className="md:text-xl text-lg">Derniers livres empruntés</h2>
        {derniersEmprunts.length > 0 && derniersEmprunts !== undefined? (
          <div className="flex flex-row justify-around">
            {derniersEmprunts.map((item) => {
              return (
                <div className="w-60" key={item.livre.titre}>
                  <Book props={item.livre} setBook={setBook} />
                </div>
              );
            })}
          </div>
        ) : (
          <p className=" w-100 text-center m-40">Aucun livre emprunté pour l'instant</p>
        )}
      </div>
      <div className="derniers-ajout m-20 h-min">
        <h2 className="md:text-xl text-lg">Derniers livres ajoutés</h2>
        {derniersLivres !== undefined && derniersLivres.length > 0 ? (
          <div className="flex flex-row flex-wrap justify-around m-5">
            {derniersLivres.map((livre) => {
                return (
                <div className="w-60" key={livre.id}>
                  <Book props={livre} setBook={setBook} />
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
