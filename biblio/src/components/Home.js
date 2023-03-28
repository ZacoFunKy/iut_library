import { React, useEffect, useState } from "react";
import axios from "axios";
import Book from "./Book";

function Home({ setBook}) {
  const [derniersLivres, setDerniersLivres] = useState([]);
  const [derniersEmprunts, setDerniersEmprunts] = useState([]);
  const [indexResp, setIndexResp] = useState(4);

  useEffect(() => {
    axios
      .get("https://localhost:8000/api/books/last_posts")
      .then((response) => {
        console.log(response.data);
        setDerniersLivres(response.data.slice(0, indexResp));
      })
      .catch((error) => {
        console.log(error);
      });
  }, [indexResp, setDerniersLivres]);

  window.addEventListener("resize", resize);

  // changer la valeur de indexResp selon la largeur de l'ecran
  function resize() {
    if (window.innerWidth < 1200) {
      setIndexResp(2);
    } else if (window.innerWidth < 1500) {
      setIndexResp(3);
    } else {
      setIndexResp(4);
    }
  };

  useEffect(() => {
    resize();
  }, []);

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
    <div className="home relative">

      <div className="derniers-emprunts m-20 items-center">
        <h2>Derniers livres empruntés</h2>
        {derniersEmprunts.length > 0 ? (
          <div className="flex flex-row justify-around m-5">
            {derniersEmprunts.map((livre) => {
              return (
                <div className="w-60" key={livre.id}>
                  <Book props={livre} />
                </div>
              );
            })}
          </div>
        ) : <p className="m-auto w-max">Aucun livre emprunté pour l'instant</p>}
      </div>
      <div className="derniers-ajout m-20">
        <h2>Derniers livres ajoutés</h2>
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
